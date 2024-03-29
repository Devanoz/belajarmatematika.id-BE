<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\StudentChallenge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentChallengeResource;
use App\Models\Challenge;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentChallengeController extends Controller
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
            'challenge_id'  => 'required|exists:challenges,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $student_id = auth()->guard('api_student')->user()->id;

        if(StudentChallenge::where('student_id', $student_id)->where('challenge_id', request()->challenge_id)->first()){
            return response()->json([
                'success' => false,
                'message' => 'Challenge sudah Dikerjakan'
            ], 403);
        }

        $challenge = DB::select(
            "SELECT 
            COUNT(IF(answer IS NOT NULL, 1, NULL)) AS 'done', 
            COUNT(q.id) AS 'questions',
            COUNT(IF(q.answer_key = sa.answer, 1, NULL)) AS'correct'
            FROM challenges c LEFT JOIN questions q ON(c.id = q.challenge_id) LEFT JOIN student_answers sa ON(q.id = sa.question_id)
            WHERE c.id = " . $request->challenge_id . " AND (sa.student_id IS NULL OR sa.student_id = " . $student_id . ")"
        );

        if($challenge[0]->done < $challenge[0]->questions){
            return response()->json([
                'success' => false,
                'message' => 'Soal Belum Dikerjakan Semua'
            ], 403);
        }

        $studentChallenge = StudentChallenge::create([
                'student_id'        => $student_id,
                'challenge_id'      => request()->challenge_id,
                'score'             => 100 * ($challenge[0]->correct / $challenge[0]->questions),
                'correct_answer'    => $challenge[0]->correct,
                'total_question'    => $challenge[0]->questions,
        ]);

        $challenge = Challenge::whereId($request->challenge_id)->with('materi')->first();
        $questions = Question::with('options')
        ->with(['studentAnswers' => function ($studentAnswer){
            $studentAnswer->where('student_id', auth()->guard('api_student')->user()->id);
        }])->where('challenge_id', $request->challenge_id)
        ->oldest();

        // $studentChallenge = StudentChallenge::where('student_id', auth()->guard('api_student')->user()->id)->where('challenge_id', request()->challenge_id)->first();

        if ($studentChallenge) {
            $challenge['done'] = true;
            $challenge['score'] = $studentChallenge->score;
            $challenge['correct_answer'] = $studentChallenge->correct_answer;
            $challenge['total_question'] = $studentChallenge->total_question;
            $challenge['questions'] = $questions->get();
            //return with Api Resource
            return new StudentChallengeResource(true, 'Submit StudentChallenge Berhasil', $challenge);
        }

        //return failed with Api Resource
        return new StudentChallengeResource(false, 'Submit StudentChallenge Gagal!', null);
    }
}

