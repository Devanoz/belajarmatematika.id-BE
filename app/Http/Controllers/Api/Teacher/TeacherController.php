<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->guard('api_teacher')->user()->role == 'teacher'){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        
        //get teacher
        $teacher = Teacher::where('role', 'teacher')->when(request()->name, function ($teacher) {
            $teacher->where('name', 'like', '%' . request()->name . "%");
        })->latest()->get();
        
        //return with Api Resource
        return new TeacherResource(true, 'List Data Teacher', $teacher);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->guard('api_teacher')->user()->role == 'teacher'){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students|unique:teachers',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create teacher
        $teacher = Teacher::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($teacher) {
            //return success with Api Resource
            return new TeacherResource(true, 'Data Teacher Berhasil Disimpan!', $teacher);
        }

        //return failed with Api Resource
        return new TeacherResource(false, 'Data Teacher Gagal Disimpan!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        if(auth()->guard('api_teacher')->user()->role == 'teacher'){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        //remove old image
        Storage::disk('local')->delete('public/teachers/'.basename($teacher->image));

        if($teacher->delete()) {
            //return success with Api Resource
            return new TeacherResource(true, 'Data Teacher Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new TeacherResource(false, 'Data Teacher Gagal Dihapus!', null);
    }
}
