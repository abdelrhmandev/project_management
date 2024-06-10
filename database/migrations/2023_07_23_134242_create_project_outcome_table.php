<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_outcome', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('title', 255);
            $table->string('description', 1000);
            $table->string('template', 255)->nullable();
            $table->string('file', 255)->nullable();
            $table->enum('is_accepted', [0, 1])->nullable();
            $table->enum('is_template_approved', [0,1])->nullable();
            $table->text('template_reject_reason')->nullable();
            $table->string('client_rejection_note', 255)->nullable();
            $table->foreignId('user_add')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('user_edit')->nullable()->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('project_outcome');
    }
};