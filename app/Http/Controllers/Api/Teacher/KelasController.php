<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Kelas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KelasResource;
use Illuminate\Support\Facades\Validator;

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
        $kelas = Kelas::when(request()->title, function($kelas) {
            $kelas = $kelas->where('title', 'like', '%'. request()->title . '%');
        })->latest()->paginate(10);
        
        //return with Api Resource
        return new KelasResource(true, 'List Data Kelas', $kelas);
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
            'title'     => 'required|unique:kelas',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create Kelas
        $kelas = Kelas::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
        ]);

        if($kelas) {
            //return success with Api Resource
            return new KelasResource(true, 'Data Kelas Berhasil Disimpan!', $kelas);
        }

        //return failed with Api Resource
        return new KelasResource(false, 'Data Kelas Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = Kelas::whereId($id)->first();
        
        if($kelas) {
            //return success with Api Resource
            return new KelasResource(true, 'Detail Data Kelas!', $kelas);
        }

        //return failed with Api Resource
        return new KelasResource(false, 'Detail Data Kelas Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kela)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|unique:kelas,title,'.$kela->id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update Kelas
        $kela->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
        ]);

        if($kela) {
            //return success with Api Resource
            return new KelasResource(true, 'Data Kelas Berhasil Diupdate!', $kela);
        }

        //return failed with Api Resource
        return new KelasResource(false, 'Data Kelas Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kela)
    {
        if($kela->delete()) {
            //return success with Api Resource
            return new KelasResource(true, 'Data Kelas Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new KelasResource(false, 'Data Kelas Gagal Dihapus!', null);
    }
}
