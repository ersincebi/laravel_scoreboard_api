<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GamesResource;
use App\Models\Games;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller{

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(){

		$games = DB::select('SELECT G.id, G.title, count(S.user_id) AS unique_users,
								SUM(CASE WHEN S.score > 0 THEN 1 ELSE 0 END) total_play_count
								FROM games G
								INNER JOIN scoreboards S ON S.game_id = G.id
								GROUP BY S.user_id, G.id
								ORDER BY G.id DESC');

		return response(
			[
				'out' => collect($games)
			],
			200
		);
	}
}
