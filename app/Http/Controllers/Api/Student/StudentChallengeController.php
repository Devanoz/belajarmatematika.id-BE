<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Student;
use App\Models\StudentChallenge;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\StudentChallengeResource;
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
            'student_id'    => 'required',
            'challenge_id'  => 'required',
            'score'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $studentChallenge = StudentChallenge::where('student_id', request()->student_id)->where('challenge_id', request()->challenge_id)->first();

        if($studentChallenge){

            if($studentChallenge->score < request()->score){

                $studentChallenge->update([
                    'score' => request()->score,
                ]);
            }

        }else{

            $studentChallenge = StudentChallenge::create([
                'student_id'    => request()->student_id,
                'challenge_id'  => request()->challenge_id,
                'score'         => request()->score,
            ]);
        }

        if ($studentChallenge) {
            //return with Api Resource
            return new StudentChallengeResource(true, 'Simpan StudentChallenge Berhasil', $studentChallenge);
        }

        //return failed with Api Resource
        return new StudentChallengeResource(false, 'Simpan StudentChallenge Gagal!', null);
    }
}
