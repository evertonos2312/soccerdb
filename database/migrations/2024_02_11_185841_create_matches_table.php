<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('round_id')->index();
            $table->uuid('home_team_id')->index();
            $table->uuid('away_team_id')->index();
            $table->dateTime('match_date');
            $table->uuid('home_team_goals')->default(0);
            $table->uuid('away_team_goals')->default(0);
            $table->string('result');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
