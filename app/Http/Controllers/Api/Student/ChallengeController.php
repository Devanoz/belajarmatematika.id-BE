<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChallengeResource;
use App\Models\Challenge;
use App\Models\Materi;
use App\Models\Topik;
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
        // $challenge = Challenge::when(request()->title, function ($challenge) {
        //     $challenge->where('title', 'like', '%' . request()->title . '%');
        // })->when(request()->materi_id, function ($challenge) {
        //     $challenge->where('materi_id', request()->materi_id);
        // })
        // ->withCount('questions')
        // ->whereHas('questions')
        // ->when(request()->done == true, function($challenge){
        //     $challenge->whereHas('studentChallenges', function ($challenge){
        //         $challenge->where('student_id', auth()->guard('api_student')->user()->id);
        //     })
        //     ->with('studentChallenges', function ($challenge){
        //         $challenge->where('student_id', auth()->guard('api_student')->user()->id);
        //     });
        // })
        // ->when(! request()->done == true, function($challenge){
        //     $challenge->whereDoesntHave('studentChallenges', function($challenge){
        //         $challenge->where('student_id', auth()->guard('api_student')->user()->id);
        //     });
        // })
        // ->latest()->get();

        $challenge = Materi::when(request()->materi_id, function($challenge) {
            $challenge->where('id', request()->materi_id);
        })->when(request()->kelas_id, function($materi) {
            $materi->whereIn(
                'topik_id', Topik::where('kelas_id', request()->kelas_id)->pluck('id')->toArray()
            );
        })->whereHas('challenges')
        ->with('challenges', function($challenge){
            $challenge->when(request()->title, function($challenge) {
                $challenge->where('title', 'like', '%' . request()->title . '%');
            })
            ->withCount('questions')
            ->whereHas('questions')
            ->when(request()->done == true, function($challenge){
                $challenge->whereHas('studentChallenges', function ($challenge){
                    $challenge->where('student_id', auth()->guard('api_student')->user()->id);
                })
                ->with('studentChallenges', function ($challenge){
                    $challenge->where('student_id', auth()->guard('api_student')->user()->id);
                });
            })
            ->when(! request()->done == true, function($challenge){
                $challenge->whereDoesntHave('studentChallenges', function($challenge){
                    $challenge->where('student_id', auth()->guard('api_student')->user()->id);
                });
            })
            ->oldest();
        })->oldest()->get();

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
