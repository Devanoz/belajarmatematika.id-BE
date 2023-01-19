<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Video;
use App\Models\Materi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Models\Topik;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get video
        $video = Materi::when(request()->materi_id, function($materi) {
            $materi->where('id', request()->materi_id);
        })->when(request()->kelas_id, function($materi) {
            $materi->whereIn(
                'topik_id', Topik::where('kelas_id', request()->kelas_id)->pluck('id')->toArray()
            );
        })->with('videos', function($videos){
            $videos->when(request()->title, function($video) {
                $video->where('title', 'like', '%'. request()->title . '%');
            });
        })->latest()->get();
        
        //return with Api Resource
        return new VideoResource(true, 'List Data Video', $video);
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
            'title'     => 'required|unique:videos',
            'url'       => 'required|unique:videos',
            'materi_id' => 'required|exists:materis,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create Video
        $video = Video::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'url' => $request->url,
            'materi_id' => $request->materi_id,
        ]);

        if($video) {
            //return success with Api Resource
            return new VideoResource(true, 'Data Video Berhasil Disimpan!', $video);
        }

        //return failed with Api Resource
        return new VideoResource(false, 'Data Video Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::whereId($id)->first();
        
        if($video) {
            //return success with Api Resource
            return new VideoResource(true, 'Detail Data Video!', $video);
        }

        //return failed with Api Resource
        return new VideoResource(false, 'Detail Data Video Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|unique:videos,title,'.$video->id,
            'url'       => 'required|unique:videos,url,'.$video->id,
            'materi_id' => 'required|exists:materis,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update Video
        $video->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'url' => $request->url,
            'materi_id' => $request->materi_id,
        ]);

        if($video) {
            //return success with Api Resource
            return new VideoResource(true, 'Data Video Berhasil Diupdate!', $video);
        }

        //return failed with Api Resource
        return new VideoResource(false, 'Data Video Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        if($video->delete()) {
            //return success with Api Resource
            return new VideoResource(true, 'Data Video Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new VideoResource(false, 'Data Video Gagal Dihapus!', null);
    }
}
