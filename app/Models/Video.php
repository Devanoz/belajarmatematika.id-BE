<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug',
        'url',
        'materi_id',
    ];   

    public function getUrlAttribute($url)
    {
        if($url){
            return str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $url);
        }else{
            return null;
        }
    }
}