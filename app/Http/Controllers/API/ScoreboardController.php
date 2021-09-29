<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ScoreboardResource;
use App\Models\Scoreboard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreboardController extends Controller{

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function show(int $game_id){

		$games = Scoreboard::select('user_id','score')
							->where('game_id', $game_id)
							->orderBy('score')
							->skip(0)
							->take(25)
							->get();

		$ranks = 0;
		foreach($games as $game) $game->ranks = $ranks++;

		return response(
			[
				'games' => ScoreboardResource::collection($games),
				'message' => 'Retrieved successfully'
			],
			200
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$data = $request->all();

		$validator = Validator::make(
			$data,
			[
				'user_id' => 'required',
				'game_id' => 'required',
				'score' => 'required'
			]
		);

		if ($validator->fails())
			return response(
				[
					'error' => $validator->errors(),
					'Validation Error'
				]
			);

		// else
		// here we find the old rank of the user
		//SELECT ROW_NUMBER() OVER (ORDER BY SomeField) AS Row, * FROM SomeTable
		$scoreboardCollection = $this->get_collection($request->game_id);
		$old_rank = $this->findRank($scoreboardCollection, (int) $request->user_id);

		// {old_rank: ”, new_rank: "”, sweep: [1,2,3,4,5]}
		$scoreboard = Scoreboard::create($data);

		// getting the new rank
		$scoreboardCollection = $this->get_collection($request->game_id);
		$new_rank = $this->findRank($scoreboardCollection, (int) $request->user_id);


		//finding the sweeps


		return response(
				[
					'score' => collect([
						'old_rank' => $old_rank,
						'new_rank' => $new_rank,
						'sweep' => $sweep,
					]),
					'message' => 'Created successfully'
				],
				201
			);
	}

	/**
	 * 
	 */
	private function get_collection(int $game_id){
		return Scoreboard::select('user_id','score')
							->where('game_id', $game_id)
							->orderBy('score')
							->get();
	}

	/**
	 * finds the required gamers row number
	 * 
	 * @return row_number in collection
	 */
	private function findRank(Collection $collection, int $needle){
		return $collection->search(function ($item) use ($needle) {
			return $item->user_id == $needle;
		});
	}
}
