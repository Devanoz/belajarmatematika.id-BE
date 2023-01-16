<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class StudentChallenge extends Model
{
    use HasFactory;

    protected $fillable = ['challenge_id', 'student_id', 'score', 'correct_answer', 'total_question'];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function getCreatedAtAttribute($created_at)
    {
        // return Carbon::parse($created_at)->format('Y-m-d H:i:s');
        return Carbon::createFromTimestamp(strtotime($created_at))
        ->timezone(Config::get('app.timezone'))
        ->toDateTimeString();
    }   

    public function getUpdatedAtAttribute($updated_at)
    {
        // return Carbon::parse($updated_at)->format('Y-m-d H:i:s');
        return Carbon::createFromTimestamp(strtotime($updated_at))
        ->timezone(Config::get('app.timezone'))
        ->toDateTimeString();
    }
}
