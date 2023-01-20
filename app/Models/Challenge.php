<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug', 'materi_id', 'is_published', 'updated_at'];

    public function studentChallenges(){
        return $this->hasMany(StudentChallenge::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function completedQuestions(){
        return $this->hasManyThrough(StudentAnswer::class, Question::class)->where('student_id', auth()->guard('api_student')->user()->id);
    }

    public function materi(){
        return $this->belongsTo(Materi::class);
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
