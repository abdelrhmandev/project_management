<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectEmpowerCharityTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_empower_charity', function (Blueprint $table) {
			$table->id();
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->foreignId('user_add')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('user_edit')->nullable()->constrained('users')->onDelete('cascade');
			$table->integer('charity_count')->nullable();
			$table->string('charity_list_file')->nullable();
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
		Schema::dropIfExists('project_empower_charity');
	}
}
