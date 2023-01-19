<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use App\Models\Materi;
use App\Models\Student;
use App\Models\Topik;
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
