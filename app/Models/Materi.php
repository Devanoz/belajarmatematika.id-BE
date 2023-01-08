<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'topik_id'
    ];

    public function videos(){
        return $this->hasMany(Video::class);
    }

    public function challenges(){
        return $this->hasMany(Challenge::class);
    }

        /**
     * getImageAttribute
     *
     * @param  mixed $image
     * @return void
     */
    public function getContentAttribute($content)
    {
        if($content){
            return asset('storage/materis/' . $content);
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

