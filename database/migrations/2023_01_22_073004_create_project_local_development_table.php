<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectLocalDevelopmentTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_local_development', function (Blueprint $table) {
			$table->id();
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->foreignId('user_add')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('user_edit')->nullable()->constrained('users')->onDelete('cascade');
			$table->string('research_survey');
			$table->string('coordinate_file');
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
		Schema::dropIfExists('project_local_development');
	}
}
