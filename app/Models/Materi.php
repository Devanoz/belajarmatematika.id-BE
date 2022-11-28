<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return asset('storage/materis/' . $content);
    }
}

