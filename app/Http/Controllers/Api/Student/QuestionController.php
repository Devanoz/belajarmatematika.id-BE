<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

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
        $question = Question::with('options')
        ->with(['studentAnswers' => function ($studentAnswer){
            $studentAnswer->where('student_id', auth()->guard('api_student')->user()->id);
        }])->where('challenge_id', request()->challenge_id)
        ->latest()
        ->get();

        
            
        //return with Api Resource
        return new QuestionResource(true, 'List Data Question', $question);
    }
}
