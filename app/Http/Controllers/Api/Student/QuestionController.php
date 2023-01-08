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
        ->latest()
        ;

        if(StudentChallenge::where('student_id', auth()->guard('api_student')->user()->id)->where('challenge_id', request()->challenge_id)->first()){
            $studentChallenge = DB::select(
                "SELECT 
                COUNT(IF(answer IS NOT NULL, 1, NULL)) AS 'done', 
                COUNT(q.id) AS 'questions',
                COUNT(IF(q.answer_key = sa.answer, 1, NULL)) AS'correct'
                FROM challenges c LEFT JOIN questions q ON(c.id = q.challenge_id) LEFT JOIN student_answers sa ON(q.id = sa.question_id)
                WHERE c.id = " . request()->challenge_id . " AND (sa.student_id IS NULL OR sa.student_id = " . auth()->guard('api_student')->user()->id . ")"
            );

            $challenge['done'] = true;
            $challenge['score'] = 100 * ($studentChallenge[0]->correct / $studentChallenge[0]->questions);
            $challenge['correct_answer'] = $studentChallenge[0]->correct;
            $challenge['total_question'] = $studentChallenge[0]->questions;
            $challenge['questions'] = $questions->get();
        }else{
            $questions = $questions->paginate(1);
            $challenge['done'] = false;
            $questions->items()[0]->answer_key = null;
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
