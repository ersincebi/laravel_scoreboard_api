<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreboardsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scoreboards', function (Blueprint $table) {
			$table->id();

			$table->foreignId('user_id')
				->nullable()
				->constrained()
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->foreignId('game_id')
				->nullable()
				->constrained()
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->float('score')
					->default(0);
			
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('scoreboards');
	}
}
