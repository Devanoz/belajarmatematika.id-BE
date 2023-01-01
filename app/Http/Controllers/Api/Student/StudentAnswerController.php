<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentAnswerResource;
use App\Models\Question;
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

        $challenge_id = Question::where('id', $request->question_id)->first()->challenge_id;

        if($new_student_answer){
            //get question
            $question = Question::with('options')->with('studentAnswers', function ($studentAnswer){
                $studentAnswer->where('student_id', auth()->guard('api_student')->user()->id);
            })->where('challenge_id', $challenge_id)->latest()->get();

            $question = array_map(function ($question) {
                unset($question['answer_key']);
                return $question;
            }, $question->toArray());

            //return with Api Resource
            return new StudentAnswerResource(true, 'Simpan StudentAnswer Berhasil!', $question);
        }

        //return failed with Api Resource
        return new StudentAnswerResource(false, 'Simpan StudentAnswer Gagal!', $new_student_answer);
    }
}
