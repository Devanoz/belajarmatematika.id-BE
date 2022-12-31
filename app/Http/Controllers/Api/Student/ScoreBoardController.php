<?php

namespace App\Http\Controllers\Api\Student;

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
            ->get()
            ->take(10);

        // $scoreBoard = [
        //     'score' => $scoreBoard->data->score,
        //     'name'  => $scoreBoard->data->student->name,
        //     'image' => $scoreBoard->data->student->image_url,
        // ];

        //return with Api Resource
        return new ScoreBoardResource(true, 'List Data ScoreBoard', $scoreBoard);
    }
}
