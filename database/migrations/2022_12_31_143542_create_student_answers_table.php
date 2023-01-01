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
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('student_id');
            $table->string('answer');
            $table->timestamps();

            //relationship to questions
            $table
                ->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade');

            //relationship to students
            $table
                ->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_answers');
    }
};
