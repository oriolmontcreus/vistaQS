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
        Schema::create('survey_question', function (Blueprint $table) {
            $table->unsignedBigInteger('idSurvey');
            $table->unsignedBigInteger('idQuestion');
            $table->primary(['idSurvey', 'idQuestion']);
            $table->foreign('idSurvey')->references('id')->on('survey');
            $table->foreign('idQuestion')->references('id')->on('question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_question');
    }
};
