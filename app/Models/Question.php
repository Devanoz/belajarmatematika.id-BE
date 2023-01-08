<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'image', 'answer_key', 'is_pilihan_ganda', 'challenge_id'];

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function studentAnswers(){
        return $this->hasMany(StudentAnswer::class);
    }

    /**
     * getImageAttribute
     *
     * @param  mixed $image
     * @return void
     */
    public function getImageAttribute($image)
    {
        if($image){
            return asset('storage/questions/' . $image);
        }else{
            return null;
        }
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
