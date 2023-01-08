<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug', 'materi_id'];

    public function studentChallenges(){
        return $this->hasMany(StudentChallenge::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function materi(){
        return $this->belongsTo(Materi::class);
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
