<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ReplyComment extends Model
{
    use HasFactory;

    protected $fillable = ['comment_id', 'teacher_id', 'student_id', 'title'];

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->format('Y-m-d');
    }   

    public function getUpdatedAtAttribute($updated_at)
    {
        return Carbon::parse($updated_at)->format('Y-m-d');
    }
}
