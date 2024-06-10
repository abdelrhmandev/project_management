<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectFinancialEstimateTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_financial_estimate', function (Blueprint $table) {
			$table->id();
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
 
			$table->decimal('beneficiary_preparation_pricing', 9, 2)->nullable();
			$table->decimal('writing_report_cost', 9, 2)->nullable();
			$table->enum('is_family_list_required', ['0', '1'])->default('0');
			$table->enum('is_coordinate_required', ['0', '1'])->default('0');
			$table->enum('is_explore_tour_required', ['0', '1'])->default('0');
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->date('observer_training_date')->nullable();
			$table->date('auditor_training_date')->nullable();
			$table->date('inspector_visit_date')->nullable();

			$table->integer('observer_qty')->nullable();
			$table->decimal('observer_price', 5, 2)->nullable();
			$table->integer('observer_audit_qty')->nullable();
			$table->decimal('observer_audit_price', 5, 2)->nullable();
			$table->integer('auditor_qty')->nullable();
			$table->decimal('auditor_price', 5, 2)->nullable();
			$table->integer('supervisor_qty')->nullable();
			$table->decimal('supervisor_price', 5, 2)->nullable();
			$table->integer('researcher_qty')->nullable();
			$table->decimal('researcher_price', 5, 2)->nullable();
			$table->integer('inspector_qty')->nullable();
			$table->decimal('inspector_price', 5, 2)->nullable();
			$table->integer('trainer_qty')->nullable();
			$table->decimal('trainer_price', 5, 2)->nullable();
			$table->string('finance_file')->nullable();
			$table->enum('observer_training_required', [0, 1])->nullable();
			$table->enum('auditor_training_required', [0, 1])->nullable();
			$table->enum('is_espeical_training_needed', [0, 1])->default('0');
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
		Schema::dropIfExists('project_financial_estimate');
	}
}