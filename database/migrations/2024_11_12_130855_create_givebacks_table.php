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
            $table->string('student_id');
            $table->foreignId('game_record_id')->nullable()->constrained();
            $table->integer('type');
            $table->boolean('question_1');
            $table->boolean('question_2');
            $table->boolean('question_3');
            $table->boolean('question_4');
            $table->boolean('question_5');
            $table->boolean('question_6');
            $table->boolean('question_7');
            $table->text('comment')->nullable();
            $table->integer('score');
            $table->integer('game_seconds')->comment('玩遊戲花費時間');
            $table->timestamps();

            $table->index('student_id');
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
