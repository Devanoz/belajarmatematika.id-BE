<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Models\Video;
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
        $video = Video::when(request()->q, function($video) {
            $video = $video->where('title', 'like', '%'. request()->q . '%');
        })->latest()->get();
        
        //return with Api Resource
        return new VideoResource(true, 'List Data Video', $video);
    }
}
