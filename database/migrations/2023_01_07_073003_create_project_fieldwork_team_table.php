<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectFieldworkTeamTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_fieldwork_team', function (Blueprint $table) {
			$table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
			$table->foreignId('type_id')->constrained('team_rank_types')->onDelete('cascade');
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->integer('supervisor_qty')->nullable();
			$table->integer('researcher_qty')->nullable();
			$table->integer('auditor_qty')->nullable();
			$table->integer('old_supervisor_qty')->nullable();
			$table->integer('old_researcher_qty')->nullable();
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
		Schema::dropIfExists('project_fieldwork_team');
	}
}
