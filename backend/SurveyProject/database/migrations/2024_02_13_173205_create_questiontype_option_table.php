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
        Schema::create('questiontype_option', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idQuestion');
            $table->unsignedBigInteger('idAnswer');
            $table->text('descr');
            $table->foreign('idQuestion')->references('id')->on('question');
            $table->foreign('idAnswer')->references('id')->on('answer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questiontype_option');
    }
};
