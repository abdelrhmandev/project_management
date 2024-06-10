<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function (Blueprint $table) {
			$table->id();
			$table->foreignId('type_id')->constrained('project_types')->onDelete('cascade');
			$table->string('logo');
			$table->string('title');
			$table->foreignId('status_id')->constrained('project_status')->onDelete('cascade');
			$table->date('potential_approved_date')->nullable();
			$table->date('start_date');
			$table->date('end_date');
			$table->integer('cases_count')->nullable()->unsigned();
			$table->integer('building_count')->nullable()->unsigned();
			$table->decimal('progress_bar', 4, 1)->default(8.3);
			$table->enum('is_training_correction', [0, 1])->default('0');
			$table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
			$table->foreignId('user_add')->nullable()->constrained('users')->onDelete('cascade');
			$table->foreignId('user_edit')->nullable()->constrained('users')->onDelete('cascade');

			$table->string('rfp');
			$table->string('additional_questions')->nullable();
			$table->string('requirements_specifications');
			$table->string('google_map')->nullable();

			$table->integer('preparation_days')->nullable()->unsigned();
			$table->integer('execution_days')->nullable()->unsigned();
			$table->string('confirm_letter')->nullable();

			$table->enum('opening', [0, 1])->default('0');
			$table->enum('opening_reserve_hall', [0, 1])->nullable();
			$table->enum('opening_attendance_nature', ['regulars', 'leaders'])->nullable();
			$table->date('opening_date')->nullable();
			$table->enum('closing', [0, 1])->default('0');
			$table->enum('closing_reserve_hall', [0, 1])->nullable();
			$table->enum('closing_attendance_nature', ['regulars', 'leaders'])->nullable();
			$table->date('closing_date')->nullable();
			$table->enum('flexibility_project_dates', [0, 1])->default('0');
			$table->enum('is_client_involved', [0, 1])->default('0');

			$table->string('coordinates')->nullable();
			$table->softDeletes();
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
		Schema::dropIfExists('projects');
	}
}