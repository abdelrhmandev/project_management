<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHistoryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaction_history', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('previous');
			$table->enum('class', ['primary', 'secondary', 'dark','success','warning','danger','info'])->default('success');
			$table->string('icons',255)->nullable(); 
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('transaction_history');
	}
}
