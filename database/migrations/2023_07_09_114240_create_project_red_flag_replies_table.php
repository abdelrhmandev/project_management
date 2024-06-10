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
        Schema::create('project_red_flag_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('redflag_id')->constrained('project_red_flags')->onDelete('cascade');
            $table->foreignId('reply_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('reply', 500)->nullable(); 
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
        Schema::dropIfExists('project_red_flag_replies');
    }
};
