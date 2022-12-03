<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChallengeResource;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get challenge
        $challenge = Challenge::when(request()->title, function ($challenge) {
            $challenge = $challenge->where('title', 'like', '%' . request()->title . '%');
        })->when(request()->materi_id, function ($challenge) {
            $challenge = $challenge->where('materi_id', request()->materi_id);
        })->with('studentChallenges', function ($challenge){
            $challenge = $challenge->where('student_id', auth()->guard('api_student')->user()->id);
        })->latest()->get();

        //return with Api Resource
        return new ChallengeResource(true, 'List Data Challenge', $challenge);
    }
}
