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
        Schema::create('givebacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_record_id');
            $table->foreign('game_record_id')->references('id')->on('game_records')->onDelete('cascade');
            $table->boolean('question_1');
            $table->boolean('question_2');
            $table->boolean('question_3');
            $table->boolean('question_4');
            $table->boolean('question_5');
            $table->boolean('question_6');
            $table->boolean('question_7');
            $table->text('comment');
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('givebacks');
    }
};
