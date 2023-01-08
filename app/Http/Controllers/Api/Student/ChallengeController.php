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
        })->withCount('questions')
        ->with('studentChallenges', function ($challenge){
            $challenge = $challenge->where('student_id', auth()->guard('api_student')->user()->id);
        })->latest()->get();

        //return with Api Resource
        return new ChallengeResource(true, 'List Data Challenge', $challenge);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexWithMateri()
    {
        //get challenge
        $challenge = Challenge::with('materi')->latest()->get();

        //return with Api Resource
        return new ChallengeResource(true, 'List Data Challenge With Materi', $challenge);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $challenge = Challenge::whereId($id)
        ->with('studentChallenges', function($studentChallenge){
            $studentChallenge->where('student_id', auth()->guard('api_student')->user()->id);
        })->first();
        
        if($challenge) {
            //return success with Api Resource
            return new ChallengeResource(true, 'Detail Data Challenge!', $challenge);
        }

        //return failed with Api Resource
        return new ChallengeResource(false, 'Detail Data Challenge Tidak DItemukan!', null);
    }
}
