<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students|unique:teachers',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //create student
        $student = Student::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($student) {
            //return with Api Resource
            return new StudentResource(
                true,
                'Register Student Berhasil',
                $student
            );
        }

        //return failed with Api Resource
        return new StudentResource(false, 'Register Student Gagal!', null);
    }
}
