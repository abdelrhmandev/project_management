<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingUrlTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('training_url', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->foreignId('type_id')->constrained('team_rank_types')->onDelete('cascade');
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->enum('is_correction', [0, 1])->default(0);
			$table->dateTime('start_date');
			$table->dateTime('end_date');
			$table->string('url');
			$table->string('train_file_url')->nullable();
			$table->string('train_kashef_url')->nullable();
			$table->string('train_kashef_account_email')->nullable();
			$table->string('train_kashef_account_password')->nullable();
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
		Schema::dropIfExists('training_url');
	}
}
