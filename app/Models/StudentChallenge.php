<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentChallenge extends Model
{
    use HasFactory;

    protected $fillable = ['challenge_id', 'student_id', 'score'];

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
