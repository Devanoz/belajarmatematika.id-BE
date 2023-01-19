<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
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
        $teacher = Teacher::findOrFail(auth()->guard('api_teacher')->user()->id);

        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email|unique:students|unique:admins|unique:teachers,email,'. $teacher->id,
            'image' => 'image|mimes:jpeg,jpg,png|max:2000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //check image update
        if ($request->file('image')) {

            //remove old image
            Storage::disk('local')->delete('public/teachers/'.basename($teacher->image));
        
            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/teachers', $image->hashName());

            //update teacher with new image
            $teacher->update([
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

            //update teacher with new password
            $teacher->update([
                'password'  => Hash::make($request->password),
            ]);
        }

        $teacher->update([
                'name'      => $request->name,
                'slug'      => Str::slug($request->name, '-'),
                'email'     => $request->email,
            ]);

        if($teacher) {
            //return with Api Resource
            return new TeacherResource(true, 'Update Profile Teacher Berhasil', $teacher);
        }

        //return failed with Api Resource
        return new TeacherResource(false, 'Update Profile Teacher Gagal!', null);
    }
}
