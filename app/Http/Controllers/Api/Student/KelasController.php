<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\KelasResource;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get kelas
        $kelas = Kelas::when(request()->title, function ($kelas) {
            $kelas = $kelas->where('title', 'like', '%' . request()->title . '%');
        })->oldest()->get();

        //return with Api Resource
        return new KelasResource(true, 'List Data Kelas', $kelas);
    }
}
