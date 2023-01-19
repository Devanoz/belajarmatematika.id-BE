<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller

{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $student = Student::findOrFail(auth()->guard('api_student')->user()->id);

        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email|unique:teachers|unique:students,email,'. $student->id,
            'image' => 'image|mimes:jpeg,jpg,png|max:2000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //check image update
        if ($request->file('image')) {

            //remove old image
            Storage::disk('local')->delete('public/students/'.basename($student->image));
        
            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/students', $image->hashName());

            //update student with new image
            $student->update([
                'image'     => $image->hashName(),
            ]);
        }

        //check password update
        if ($request->password) {

            //check password and password_confirmation
            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            //update student with new password
            $student->update([
                'password'  => Hash::make($request->password),
            ]);
        }

        $student->update([
                'name'      => $request->name,
                'slug'      => Str::slug($request->name, '-'),
                'email'     => $request->email,
            ]);

        if($student) {
            //return with Api Resource
            return new StudentResource(true, 'Update Profile Student Berhasil', $student);
        }

        //return failed with Api Resource
        return new StudentResource(false, 'Update Profile Student Gagal!', null);
    }
}
