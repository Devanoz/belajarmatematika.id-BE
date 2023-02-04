<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->guard('api_teacher')->user()->role != 'admin'){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        
        //get student
        $student = Student::when(request()->name, function ($student) {
            $student->where('name', 'like', '%' . request()->name . "%");
        })->latest()->get();
        
        //return with Api Resource
        return new StudentResource(true, 'List Data Student', $student);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        if(auth()->guard('api_teacher')->user()->role != 'admin'){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        //remove old image
        Storage::disk('local')->delete('public/students/'.basename($student->image));

        if($student->delete()) {
            //return success with Api Resource
            return new StudentResource(true, 'Data Student Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new StudentResource(false, 'Data Student Gagal Dihapus!', null);
    }
}
