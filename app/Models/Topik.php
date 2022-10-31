<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'slug',
        'kelas_id',
    ];

    public function materis(){
        return $this->hasMany(Materi::class);
    }
}
