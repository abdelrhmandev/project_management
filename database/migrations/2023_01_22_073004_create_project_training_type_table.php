<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTrainingTypeTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_training_type', function (Blueprint $table) {
			$table->id();
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->string('training_type');
			$table->string('training_headquarter');
			$table->string('participant_type');
			$table->integer('duration');
			$table->integer('training_count');
			$table->date('training_date');
			$table->string('training_on');
			$table->foreignId('user_add')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('user_edit')->nullable()->constrained('users')->onDelete('cascade');
			$table->string('training_agenda');
			$table->string('trainee_list');
			$table->enum('is_hall_required', ['0', '1']);
			$table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('cascade');
			$table->string('training_plan');
			$table->string('user_manual');
			$table->string('training_material');
			$table->string('training_report');
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
		Schema::dropIfExists('project_training_type');
	}
}
