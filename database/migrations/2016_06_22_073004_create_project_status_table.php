<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStatusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_status', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('trans');
			$table->string('history'); 
			$table->enum('class', ['primary', 'secondary', 'dark','success','warning','danger','info'])->default('success');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('project_status');
	}
}
