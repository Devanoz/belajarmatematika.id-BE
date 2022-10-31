<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Challenge;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChallengeResource;
use Illuminate\Support\Facades\Validator;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get challenge
        $challenge = Challenge::when(request()->q, function($challenge) {
            $challenge = $challenge->where('title', 'like', '%'. request()->q . '%');
        })->latest()->paginate(5);
        
        //return with Api Resource
        return new ChallengeResource(true, 'List Data Challenge', $challenge);
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
            'title'     => 'required|unique:challenges',
            'url'       => 'required|unique:challenges',
            'materi_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create Challenge
        $challenge = Challenge::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'url' => $request->url,
            'materi_id' => $request->materi_id,
        ]);

        if($challenge) {
            //return success with Api Resource
            return new ChallengeResource(true, 'Data Challenge Berhasil Disimpan!', $challenge);
        }

        //return failed with Api Resource
        return new ChallengeResource(false, 'Data Challenge Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $challenge = Challenge::whereId($id)->first();
        
        if($challenge) {
            //return success with Api Resource
            return new ChallengeResource(true, 'Detail Data Challenge!', $challenge);
        }

        //return failed with Api Resource
        return new ChallengeResource(false, 'Detail Data Challenge Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Challenge $challenge)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|unique:challenges,title,'.$challenge->id,
            'url'       => 'required|unique:challenges,url,'.$challenge->id,
            'materi_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update Challenge
        $challenge->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'url' => $request->url,
            'materi_id' => $request->materi_id,
        ]);

        if($challenge) {
            //return success with Api Resource
            return new ChallengeResource(true, 'Data Challenge Berhasil Diupdate!', $challenge);
        }

        //return failed with Api Resource
        return new ChallengeResource(false, 'Data Challenge Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge)
    {
        if($challenge->delete()) {
            //return success with Api Resource
            return new ChallengeResource(true, 'Data Challenge Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new ChallengeResource(false, 'Data Challenge Gagal Dihapus!', null);
    }
}
