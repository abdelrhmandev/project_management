<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTourFileTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_tour_file', function (Blueprint $table) {
			$table->id();
            $table->foreignId('explore_tour_id')->constrained('project_explore_tour')->onDelete('cascade');
			$table->enum('file_type', ['img', 'video', 'file']);
			$table->string('file')->nullable();
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
		Schema::dropIfExists('project_tour_file');
	}
}
