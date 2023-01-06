<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Challenge;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get question
        $challenge = Challenge::whereId(request()->challenge_id)->first();
        $questions = Question::with('options')
        ->with(['studentAnswers' => function ($studentAnswer){
            $studentAnswer->where('student_id', auth()->guard('api_student')->user()->id);
        }])->where('challenge_id', request()->challenge_id)
        ->latest()
        ->get()
        ;

        $questions = array_map(function ($questions) {
            unset($questions['answer_key']);
            return $questions;
        }, $questions->toArray());

        $challenge['questions'] = $questions;

        // dd($question);
        //return with Api Resource
        return new QuestionResource(true, 'List Data Question', $challenge);
    }
}
