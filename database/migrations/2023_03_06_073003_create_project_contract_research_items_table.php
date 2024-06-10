<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectContractResearchItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_contract_research_items', function (Blueprint $table) {
			$table->id();
			$table->decimal('price', 10, 2)->nullable();
			$table->text('notices')->nullable();
 			$table->foreignId('realestate_id')->constrained('realestate_type')->onDelete('cascade');
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('project_contract_research_items');
	}
}
