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
        Schema::create('survey_surveyor', function (Blueprint $table) {
            $table->unsignedBigInteger('idSurvey');
            $table->unsignedBigInteger('idSurveyor');
            $table->primary(['idSurvey', 'idSurveyor']);
            $table->foreign('idSurvey')->references('id')->on('survey');
            $table->foreign('idSurveyor')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_surveyor');
    }
};
