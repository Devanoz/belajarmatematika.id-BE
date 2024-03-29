<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentVideo extends Model
{
    use HasFactory;

    protected $fillable = ['video_id', 'student_id', 'updated_at'];

    public function video(){
        return $this->belongsTo(Video::class);
    }
}