<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTrainingDetailTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Project_training_detail', function (Blueprint $table) {
			$table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->enum('is_trainers_needed', ['0', '1'])->default('0');
			$table->string('file')->nullable();
			$table->date('training_date')->nullable();
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
		Schema::dropIfExists('Project_training_detail');
	}
}
