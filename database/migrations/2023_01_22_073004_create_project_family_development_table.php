<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectFamilyDevelopmentTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_family_development', function (Blueprint $table) {
			$table->id();
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->foreignId('user_add')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('user_edit')->nullable()->constrained('users')->onDelete('cascade');
			$table->string('family_list');
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
		Schema::dropIfExists('project_family_development');
	}
}
