<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamRankItemTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_team_rank_item', function (Blueprint $table) {
			$table->id();
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->foreignId('type_id')->constrained('team_rank_types')->onDelete('cascade');
			$table->string('title');
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
		Schema::dropIfExists('project_team_rank_item');
	}
}
