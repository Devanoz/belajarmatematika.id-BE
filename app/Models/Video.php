<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->format('Y-m-d');
    }   

    public function getUpdatedAtAttribute($updated_at)
    {
        return Carbon::parse($updated_at)->format('Y-m-d');
    }
}