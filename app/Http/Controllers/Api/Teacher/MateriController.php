<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Materi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MateriResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {//get materi
        $materi = Materi::when(request()->title, function($materi) {
            $materi = $materi->where('title', 'like', '%'. request()->title . '%');
        })->when(request()->topik_id, function($materi) {
            $materi = $materi->where('topik_id', request()->topik_id);
        })->latest()->paginate(10);
        
        
        //return with Api Resource
        return new MateriResource(true, 'List Data Materi', $materi);
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
            'title'     => 'required|unique:materis',
            'content'   => 'required|file|mimes:pdf|max:5000',
            'topik_id'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload new content
        $content = $request->file('content');
        $content->storeAs('public/materis', $content->hashName());

        //create materi
        $materi = Materi::create([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title, '-'),
            'content'   => $content->hashName(),
            'topik_id'  => $request->topik_id,
        ]);

        if($materi) {
            //return success with Api Resource
            return new MateriResource(true, 'Data Materi Berhasil Disimpan!', $materi);
        }

        //return failed with Api Resource
        return new MateriResource(false, 'Data Materi Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $materi = Materi::whereId($id)->first();
        
        if($materi) {
            //return success with Api Resource
            return new MateriResource(true, 'Detail Data Materi!', $materi);
        }

        //return failed with Api Resource
        return new MateriResource(false, 'Detail Data Materi Tidak Ditemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, materi $materi)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|unique:materis,title,'.$materi->id,
            'content'   => 'file|mimes:pdf|max:5000',
            'topik_id'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check content store
        if ($request->file('content')) {

            //remove old content
            Storage::disk('local')->delete('public/materis/'.basename($materi->content));

            //upload new content
            $content = $request->file('content');
            $content->storeAs('public/materis', $content->hashName());

            //update materi
            $materi->update([
                'title'     => $request->title,
                'slug'      => Str::slug($request->title, '-'),
                'content'   => $content->hashName(),
                'topik_id'  => $request->topik_id,
            ]);
            
        }else{

            //update materi
            $materi->update([
                'title'     => $request->title,
                'slug'      => Str::slug($request->title, '-'),
                'topik_id'  => $request->topik_id,
            ]);
        }

        if($materi) {
            //return success with Api Resource
            return new MateriResource(true, 'Data Materi Berhasil Diupdate!', $materi);
        }

        //return failed with Api Resource
        return new MateriResource(false, 'Data Materi Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(materi $materi)
    {
        //remove old content
        Storage::disk('local')->delete('public/materis/'.basename($materi->content));

        if($materi->delete()) {
            //return success with Api Resource
            return new MateriResource(true, 'Data Materi Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new MateriResource(false, 'Data Materi Gagal Dihapus!', null);
    }
}