<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scoreboard extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'game_id',
		'score',
	];


	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'score' => 'float',
	];
}
