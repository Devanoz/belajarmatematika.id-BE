<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use App\Models\Materi;
use App\Models\Student;
use Illuminate\Http\Request;

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
        $video = Materi::with('videos')->when(request()->title, function($query) {
            $query = $query->where('title', 'like', '%'. request()->title . '%');
        })->latest()->get();
        
        // $video = Video::when(request()->title, function($video) {
        //     $video = $video->where('title', 'like', '%'. request()->title . '%');
        // })->when(request()->materi_id, function($video) {
        //     $video = $video->where('materi_id', request()->materi_id);
        // })->latest()->get();
        
        //return with Api Resource
        return new VideoResource(true, 'List Data Video', $video);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $video = Video::whereId($id)
        ->with('comments', function($comments){
            $comments
            ->with('student')
            ->with('teacher')
            ->with('replyComments', function($replyComments){
                $replyComments
                ->with('student')
                ->with('teacher')
                ->oldest();
            })->oldest();
        })->first();
        
        if($video) {
            //return success with Api Resource
            return new VideoResource(true, 'Detail Data Video!', $video);
        }

        //return failed with Api Resource
        return new VideoResource(false, 'Detail Data Video Tidak DItemukan!', null);
    }
}
