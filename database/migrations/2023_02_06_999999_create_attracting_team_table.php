<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttractingTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attracting_team', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable()->default('uploads/users-avatar/blank.png');
            $table->string('name');
            $table->string('en_name')->nullable();
            $table->string('national_id')->nullable();
            $table->string('mobile')->nullable();
            $table->string('occupation')->nullable();
            $table->foreignId('qualification_id')->nullable()->constrained('qualifications')->onDelete('cascade');
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('cascade')->default('1');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('cascade')->default('1');
            $table->string('email')->nullable();
            $table->foreignId('type_id')->constrained('team_rank_types')->onDelete('cascade');
            $table->date('enrolled_date')->nullable();
            $table->Integer('accomplished_projects')->nullable()->default('0');
            $table->bigInteger('performance_percentage')->nullable()->default('0');
            $table->unique(['national_id'])->nullable();
            $table->enum('is_processed', [0, 1])->default('0');
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
        Schema::dropIfExists('attracting_team');
    }
}
