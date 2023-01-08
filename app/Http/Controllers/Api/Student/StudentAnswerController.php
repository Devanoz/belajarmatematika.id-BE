<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentAnswerResource;
use App\Models\Question;
use App\Models\Challenge;
use App\Models\StudentChallenge;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentAnswerController extends Controller
{
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id'   => 'required|exists:questions,id',
            'answer'        => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $challenge_id = Question::where('id', $request->question_id)->first()->challenge_id;

        if(StudentChallenge::where('student_id', auth()->guard('api_student')->user()->id)->where('challenge_id', $challenge_id)->first()){
            return response()->json([
                'success' => false,
                'message' => 'Challenge sudah Dikerjakan'
            ], 403);
        }

        $student_id = auth()->guard('api_student')->user()->id;

        $student_answer = StudentAnswer::where('question_id', $request->question_id)
            ->where('student_id', $student_id)->first();

        if($student_answer){
            $new_student_answer = $student_answer->update([
                'answer' => $request->answer
            ]);
        }else{
            $new_student_answer = StudentAnswer::create([
                'question_id' => $request->question_id,
                'student_id' => $student_id,
                'answer' => $request->answer,
            ]);
        }

        if($new_student_answer){
            //get challenge
            $challenge = Challenge::whereId($challenge_id)->first();

            //get question
            $questions = Question::with('options')->with('studentAnswers', function ($studentAnswer){
                $studentAnswer->where('student_id', auth()->guard('api_student')->user()->id);
            })->where('challenge_id', $challenge_id)->latest()->paginate(1);

            $questions->items()[0]->answer_key = null;

            $challenge['done'] = false;
            $challenge['questions'] = $questions;

            //return with Api Resource
            return new StudentAnswerResource(true, 'Simpan StudentAnswer Berhasil!', $challenge);
        }

        //return failed with Api Resource
        return new StudentAnswerResource(false, 'Simpan StudentAnswer Gagal!', $new_student_answer);
    }
}
