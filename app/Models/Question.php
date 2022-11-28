<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'image', 'answer_key', 'challenge_id'];

    public function options(){
        return $this->hasMany(Option::class);
    }

    /**
     * getImageAttribute
     *
     * @param  mixed $image
     * @return void
     */
    public function getImageAttribute($image)
    {
        return asset('storage/questions/' . $image);
    }
}
