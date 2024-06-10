<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectEquipmentsFilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_equipments_files', function (Blueprint $table) {
			$table->id();
			$table->foreignId('equipment_type')->constrained('equipment_types')->onDelete('cascade');
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
			$table->longText('file')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('project_equipments_files');
	}
}
