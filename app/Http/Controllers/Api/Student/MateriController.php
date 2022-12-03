<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\MateriResource;
use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get materi
        $materi = Materi::when(request()->title, function($materi) {
            $materi = $materi->where('title', 'like', '%'. request()->title . '%');
        })->when(request()->topik_id, function($materi) {
            $materi = $materi->where('topik_id', request()->topik_id);
        })->latest()->get();
        
        //return with Api Resource
        return new MateriResource(true, 'List Data Materi', $materi);
    }
}
