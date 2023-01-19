<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScoreBoardResource;
use App\Models\StudentChallenge;
use App\Models\Student;
use Illuminate\Http\Request;

class ScoreBoardController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get scoreBoard
        $scoreBoard = 
            StudentChallenge::
            with('student')
            ->selectRaw('sum(score) as score, student_id')
            ->groupBy('student_id')
            ->orderByRaw('sum(score) desc')
            ->paginate(10);

        //return with Api Resource
        return new ScoreBoardResource(true, 'List Data ScoreBoard', $scoreBoard);
    }
}

