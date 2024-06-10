<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectKashefAccountsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_kashef_accounts', function (Blueprint $table) {
			$table->id();
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->string('admin_email')->nullable();
			$table->string('admin_password')->nullable();
			$table->string('report_email')->nullable();
			$table->string('report_password')->nullable();
			$table->string('studies_email')->nullable();
			$table->string('studies_password')->nullable();
			$table->string('url')->nullable();
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
		Schema::dropIfExists('project_kashef_accounts');
	}
}
