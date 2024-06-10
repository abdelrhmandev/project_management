<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectExploreTourTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_explore_tour', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
			$table->foreignId('type_id')->nullable();
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('cascade');
			$table->longText('explore_tour')->nullable();
			$table->enum('is_fieldwork_done', ['0', '1'])->default('0');
			$table->enum('is_observer_done', ['0', '1'])->default('0');
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
		Schema::dropIfExists('project_explore_tour');
	}
}
