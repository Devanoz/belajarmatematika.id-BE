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
        Schema::create('student_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('video_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();

            // relation to videos
            $table
            ->foreign('video_id')
            ->references('id')
            ->on('videos')
            ->onDelete('cascade');
            
            // relation to students
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
        Schema::dropIfExists('student_videos');
    }
};
