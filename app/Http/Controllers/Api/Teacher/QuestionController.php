<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        })->latest()->paginate(10);
        
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
            'title'         => 'required',
            'image'         => 'image|mimes:jpeg,jpg,png|max:2000',
            'answer_key'    => 'required',
            'challenge_id'  => 'required',
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
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'image'         => $image->hashName(),
                'answer_key'    => $request->answer_key,
                'challenge_id'  => $request->challenge_id,
            ]);

        }else{
            
            //create Question
            $question = Question::create([
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'answer_key'    => $request->answer_key,
                'challenge_id'  => $request->challenge_id,
            ]);
        }

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
            'title'         => 'required',
            'image'         => 'image|mimes:jpeg,jpg,png|max:2000',
            'answer_key'    => 'required',
            'challenge_id'  => 'required',
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
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'image'         => $image->hashName(),
                'answer_key'    => $request->answer_key,
                'challenge_id'  => $request->challenge_id,
            ]);

        }else{

            //update Question
            $question->update([
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'answer_key'    => $request->answer_key,
                'challenge_id'  => $request->challenge_id,
            ]);
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

        if($question->delete()) {
            //return success with Api Resource
            return new QuestionResource(true, 'Data Question Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new QuestionResource(false, 'Data Question Gagal Dihapus!', null);
    }
}
