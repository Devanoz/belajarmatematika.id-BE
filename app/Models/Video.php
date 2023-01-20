<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug',
        'url',
        'materi_id',
    ];   

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function studentVideos(){
        return $this->hasMany(StudentVideo::class)->where('student_id', auth()->guard('api_student')->user()->id);
    }

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