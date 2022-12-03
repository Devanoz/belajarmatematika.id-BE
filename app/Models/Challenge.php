<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
