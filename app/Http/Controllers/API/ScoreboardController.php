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

		$games = $this->get_collection($game_id)
						->skip(0)
						->take(25)
						->get();

		$ranks = 0;
		foreach($games as $game) $game->ranks = $ranks++;

		return response(
			[
				'out' => ScoreboardResource::collection($games)
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
		$old_rank = $this->findRank(
					$this->get_collection(
						$request->game_id
						)->get(),
					(int) $request->user_id
				);

		$scoreboard = Scoreboard::create($data);

		// getting the new rank
		$new_rank = $this->findRank(
			$this->get_collection(
				$request->game_id
				)->get(),
			(int) $request->user_id
		);


		//finding the sweeps
		$sweep = $this->get_collection(
					$request->game_id
					)->skip($new_rank)
					->take($old_rank)
					->get();

		return response(
				[
					'out' => collect([
						'old_rank' => (int) $old_rank,
						'new_rank' => (int) $new_rank,
						'sweep' => $sweep,
					])
				],
				201
			);
	}

	/**
	 * finds the scoreboard results for given game_id
	 * 
	 * @return Scoreboard collection
	 */
	private function get_collection(int $game_id){
		return Scoreboard::select('user_id','score')
							->where('game_id', $game_id)
							->orderBy('score');
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
