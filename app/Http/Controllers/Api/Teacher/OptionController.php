<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OptionResource;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get option
        $option = Option::when(request()->question_id, function($option) {
            $option = $option->where('question_id', request()->question_id);
        })->latest()->get();
        
        //return with Api Resource
        return new OptionResource(true, 'List Data Option', $option);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'A'       => 'required',
            'B'       => 'required',
            'C'       => 'required',
            'D'       => 'required',
            'question_id'   => 'required|exists:questions,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create Option
        $option = Option::create([
            'A'       => $request->title_1,
            'B'       => $request->title_2,
            'C'       => $request->title_3,
            'D'       => $request->title_4,
            'question_id'   => $request->question_id,
        ]);

        if($option) {
            //return success with Api Resource
            return new OptionResource(true, 'Data Option Berhasil Disimpan!', $option);
        }

        //return failed with Api Resource
        return new OptionResource(false, 'Data Option Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $option = Option::whereId($id)->first();
        
        if($option) {
            //return success with Api Resource
            return new OptionResource(true, 'Detail Data Option!', $option);
        }

        //return failed with Api Resource
        return new OptionResource(false, 'Detail Data Option Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
        $validator = Validator::make($request->all(), [
            'A'       => 'required',
            'B'       => 'required',
            'C'       => 'required',
            'D'       => 'required',
            'question_id'   => 'required|exists:questions,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create Option
        $option = Option::create([
            'A'       => $request->title_1,
            'B'       => $request->title_2,
            'C'       => $request->title_3,
            'D'       => $request->title_4,
            'question_id'   => $request->question_id,
        ]);

        if($option) {
            //return success with Api Resource
            return new OptionResource(true, 'Data Option Berhasil Diupdate!', $option);
        }

        //return failed with Api Resource
        return new OptionResource(false, 'Data Option Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        if($option->delete()) {
            //return success with Api Resource
            return new OptionResource(true, 'Data Option Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new OptionResource(false, 'Data Option Gagal Dihapus!', null);
    }
}
