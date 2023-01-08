<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\Challenge;
use App\Models\StudentChallenge;
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
        $challenge = Challenge::whereId(request()->challenge_id)->first();
        $questions = Question::with('options')
        ->with(['studentAnswers' => function ($studentAnswer){
            $studentAnswer->where('student_id', auth()->guard('api_student')->user()->id);
        }])->where('challenge_id', request()->challenge_id)
        ->latest();

        $studentChallenge = StudentChallenge::where('student_id', auth()->guard('api_student')->user()->id)->where('challenge_id', request()->challenge_id)->first();

        if($studentChallenge){
            $challenge['done'] = true;
            $challenge['score'] = $studentChallenge->score;
            $challenge['correct_answer'] = $studentChallenge->correct_answer;
            $challenge['total_question'] = $studentChallenge->total_question;
            $challenge['questions'] = $questions->get();
        }else{
            $questions = $questions->get();
            $challenge['done'] = false;
            if(isset($questions->answer_key)){
                $questions->items()[0]->answer_key = null;
            }
            $challenge['questions'] = $questions;
        }

        // $data = $questions->items()[0]->answer_key = null;
        // $data = array_map(function ($data) {
        //     unset($data['answer_key']);
        //     return $data;
        // }, $data->toArray());
        // $questions->items()[0] = $data;

        // $questions = array_map(function ($questions) {
        //     unset($questions['answer_key']);
        //     return $questions;
        // }, $questions->toArray());

        //return with Api Resource
        return new QuestionResource(true, 'List Data Question', $challenge);
    }
}
