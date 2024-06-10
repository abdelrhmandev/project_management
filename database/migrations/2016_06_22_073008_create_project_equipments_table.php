<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectEquipmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_equipments', function (Blueprint $table) {
			$table->id();
			$table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade');
			$table->foreignId('equipment_type')->constrained('equipment_types')->onDelete('cascade');
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->decimal('price', 9, 2);
			$table->integer('qty');
			$table->enum('send_equipment_receipt', [0, 1])->default('0');
			$table->enum('return_equipment_receipt', [0, 1])->default('0');
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
		Schema::dropIfExists('project_equipments');
	}
}
