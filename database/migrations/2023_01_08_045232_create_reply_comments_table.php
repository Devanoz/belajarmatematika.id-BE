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
        Schema::create('reply_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->text('title');
            $table->timestamps();

            //relationship to comments
            $table
                ->foreign('comment_id')
                ->references('id')
                ->on('comments')
                ->onDelete('cascade');

            //relationship to teschers
            $table
                ->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
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
        Schema::dropIfExists('reply_comments');
    }
};
