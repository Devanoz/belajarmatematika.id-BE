<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OptionResource;
use App\Http\Resources\QuestionResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get question
        $question = Question::with('options')->when(request()->challenge_id, function($question) {
            $question = $question->where('challenge_id', request()->challenge_id);
        })->oldest()->get();
        
        //return with Api Resource
        return new QuestionResource(true, 'List Data Question', $question);
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
            'title'             => 'required',
            'image'             => 'image|mimes:jpeg,jpg,png|max:2000',
            'answer_key'        => 'required',
            'is_pilihan_ganda'  => 'required|boolean',
            'challenge_id'      => 'required|exists:challenges,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check image store
        if ($request->file('image')) {
        
            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/questions', $image->hashName());

            //create Question
            $question = Question::create([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'image'             => $image->hashName(),
                'answer_key'        => $request->answer_key,
                'is_pilihan_ganda'  => $request->is_pilihan_ganda,
                'challenge_id'      => $request->challenge_id,
            ]);
            
        }else{
            
            //create Question
            $question = Question::create([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'answer_key'        => $request->answer_key,
                'is_pilihan_ganda'  => $request->is_pilihan_ganda,
                'challenge_id'      => $request->challenge_id,
            ]);
        }

        $option = [];

        if($request->is_pilihan_ganda){
            $validator = Validator::make($request->all(), [
                'A'       => 'required',
                'B'       => 'required',
                'C'       => 'required',
                'D'       => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            //create Option
            $option = Option::create([
                'A'       => $request->A,
                'B'       => $request->B,
                'C'       => $request->C,
                'D'       => $request->D,
                'question_id'   => $question->id,
            ]);

            if(! $option) {
                //return failed with Api Resource
                return new OptionResource(false, 'Data Option Berhasil Disimpan!', null);
            }
        }

        $question->options = $option;
        
        if($question) {
            //return success with Api Resource
            return new QuestionResource(true, 'Data Question Berhasil Disimpan!', $question);
        }

        //return failed with Api Resource
        return new QuestionResource(false, 'Data Question Gagal Disimpan!', null);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::with('options')->whereId($id)->first();
        
        if($question) {
            //return success with Api Resource
            return new QuestionResource(true, 'Detail Data Question!', $question);
        }

        //return failed with Api Resource
        return new QuestionResource(false, 'Detail Data Question Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required',
            'image'             => 'image|mimes:jpeg,jpg,png|max:2000',
            'answer_key'        => 'required',
            'is_pilihan_ganda'  => 'required|boolean',
            'challenge_id'      => 'required|exists:challenges,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        //check image store
        if ($request->file('image')) {
        
            //remove old image
            Storage::disk('local')->delete('public/questions/'.basename($question->image));
            
            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/questions', $image->hashName());
            
            //update Question
            $question->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'image'             => $image->hashName(),
                'answer_key'        => $request->answer_key,
                'is_pilihan_ganda'  => $request->is_pilihan_ganda,
                'challenge_id'      => $request->challenge_id,
            ]);
            
        }else{
            
            //update Question
            $question->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'answer_key'        => $request->answer_key,
                'is_pilihan_ganda'  => $request->is_pilihan_ganda,
                'challenge_id'      => $request->challenge_id,
            ]);
        }
        
        if($request->is_pilihan_ganda){
            $validator = Validator::make($request->all(), [
                'A'       => 'required',
                'B'       => 'required',
                'C'       => 'required',
                'D'       => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            //check Option
            $option = Option::where('question_id', $question->id)->first();
            if($option){
                //update Option
                $option = $option->update([
                    'A'       => $request->A,
                    'B'       => $request->B,
                    'C'       => $request->C,
                    'D'       => $request->D,
                    'question_id'   => $question->id,
                ]);
            }else{
                //create Option
                $option = Option::create([
                    'A'       => $request->A,
                    'B'       => $request->B,
                    'C'       => $request->C,
                    'D'       => $request->D,
                    'question_id'   => $question->id,
                ]);
            }

            if(! $option) {
                //return failed with Api Resource
                return new OptionResource(false, 'Data Option Gagal Diupdate!', null);
            }

            $question->options = $option;
        }else{
            $option = Option::where('question_id', $question->id)->delete();
            $option = [];
            $question->options = $option;
        }

        if($question) {
            //return success with Api Resource
            return new QuestionResource(true, 'Data Question Berhasil Diupdate!', $question);
        }

        //return failed with Api Resource
        return new QuestionResource(false, 'Data Question Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //remove image
        Storage::disk('local')->delete('public/questions/'.basename($question->image));

        if(Option::where('question_id', $question->id)->delete() && $question->delete()) {
            //return success with Api Resource
            return new QuestionResource(true, 'Data Question Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new QuestionResource(false, 'Data Question Gagal Dihapus!', null);
    }
}
