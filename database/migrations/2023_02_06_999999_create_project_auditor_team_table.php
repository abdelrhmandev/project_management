<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAuditorTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_auditor_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_user_id')->constrained('attracting_team')->onDelete('cascade');
            $table->foreignId('type_id')->constrained('team_rank_types')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->enum('is_correction', [0, 1])->default('0');
            $table->foreignId('superior_id')->constrained('users')->onDelete('cascade');
            $table->Integer('qty');
            $table->enum('contract_url_sent', [0, 1])->default('0');
			$table->enum('received_train', [0, 1])->default('0');
			$table->enum('approved_member', [0, 1])->default('0');
            $table->enum('created_kashef', [0, 1])->default('0');
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
        Schema::dropIfExists('project_auditor_team');
    }
}
