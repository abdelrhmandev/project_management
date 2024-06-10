<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_equipments_division', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade');
			$table->foreignId('equipment_type')->constrained('equipment_types')->onDelete('cascade');
			$table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
			$table->foreignId('observer_id')->nullable()->constrained('attracting_team')->onDelete('cascade');
			$table->float('amount')->nullable();
            $table->string('notes',500)->nullable();
            $table->text('files')->nullable();
            $table->text('shipment_files')->nullable(); 
            $table->enum('is_agree', [0, 1])->nullable(); 
            $table->string('rejection_reason',500)->nullable();
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
        Schema::dropIfExists('project_equipments_division');
    }
};
