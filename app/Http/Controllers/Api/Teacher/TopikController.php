<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Topik;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TopikResource;
use App\Models\Kelas;
use Illuminate\Support\Facades\Validator;

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
        $topiks = Kelas::when(request()->kelas_id, function ($kelas) {
           $kelas->where('kelas_id', request()->kelas_id);
        })
        ->with('topiks', function($topiks){
            $topiks->when(request()->title, function($topiks) {
                $topiks->where('title', 'like', '%'. request()->title . '%');
            })->oldest();
        })
        ->get();
        
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
        $topiks = Topik::when(request()->kelas_id, function ($topiks) {
            $topiks = $topiks->where('kelas_id', request()->kelas_id);
        })
        ->with('materis', function($materis){
            $materis->when(request()->title, function ($materis) {
                $materis->where('title', 'like', '%' . request()->title . '%')->latest();
            })->latest();
        })
        ->latest()->get();

        //return with Api Resource
        return new TopikResource(true, 'List Data topiks with Materi', $topiks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|unique:topiks',
            'kelas_id'  => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create Topik
        $Topik = Topik::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'kelas_id' => $request->kelas_id,
        ]);

        if($Topik) {
            //return success with Api Resource
            return new TopikResource(true, 'Data Topik Berhasil Disimpan!', $Topik);
        }

        //return failed with Api Resource
        return new TopikResource(false, 'Data Topik Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Topik = Topik::whereId($id)->first();
        
        if($Topik) {
            //return success with Api Resource
            return new TopikResource(true, 'Detail Data Topik!', $Topik);
        }

        //return failed with Api Resource
        return new TopikResource(false, 'Detail Data Topik Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topik $Topik)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|unique:topiks,title,'.$Topik->id,
            'kelas_id'  => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update Topik without image
        $Topik->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'kelas_id' => $request->kelas_id,
        ]);

        if($Topik) {
            //return success with Api Resource
            return new TopikResource(true, 'Data Topik Berhasil Diupdate!', $Topik);
        }

        //return failed with Api Resource
        return new TopikResource(false, 'Data Topik Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topik $Topik)
    {
        if($Topik->delete()) {
            //return success with Api Resource
            return new TopikResource(true, 'Data Topik Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new TopikResource(false, 'Data Topik Gagal Dihapus!', null);
    }
}