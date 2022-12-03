<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug'
    ];

    public function topiks(){
        return $this->hasMany(Topik::class);
    }
}