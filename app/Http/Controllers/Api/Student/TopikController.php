<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopikResource;
use App\Models\Topik;
use Illuminate\Http\Request;

class TopikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get topiks
        $topiks = Topik::when(request()->title, function ($topiks) {
            $topiks = $topiks->where('title', 'like', '%' . request()->title . '%');
        })->when(request()->kelas_id, function ($topiks) {
            $topiks = $topiks->where('kelas_id', request()->kelas_id);
        })->latest()->get();

        //return with Api Resource
        return new TopikResource(true, 'List Data topiks', $topiks);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexWithMateris()
    {
        //get topiks
        $topiks = Topik::with('materis')->when(request()->title, function ($topiks) {
            $topiks = $topiks->where('title', 'like', '%' . request()->title . '%');
        })->when(request()->kelas_id, function ($topiks) {
            $topiks = $topiks->where('kelas_id', request()->kelas_id);
        })->latest()->get();

        //return with Api Resource
        return new TopikResource(true, 'List Data topiks with Materi', $topiks);
    }
}
