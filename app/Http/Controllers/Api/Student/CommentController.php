<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Video;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_id'  => 'required|exists:videos,id',
            'title'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create Comment
        $Comment = Comment::create([
            'video_id'      => $request->video_id,
            'student_id'    => auth()->guard('api_student')->user()->id,
            'title'         => $request->title,
        ]);

        if($Comment) {
            $video = Video::whereId($request->video_id)
            ->with('comments', function($comments){
                $comments
                ->with('student')
                ->with('teacher')
                ->with('replyComments', function($replyComments){
                    $replyComments
                    ->with('student')
                    ->with('teacher')
                    ->oldest();
                })->latest();
            })->first();

            //return success with Api Resource
            return new CommentResource(true, 'Data Comment Berhasil Disimpan!', $video);
        }

        //return failed with Api Resource
        return new CommentResource(false, 'Data Comment Gagal Disimpan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $Comment)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if(auth()->guard('api_student')->user()->id != $Comment->student_id){
            return response()->json([
                'success' => false,
                'message' => 'Forbidden access to update Comment!'
            ], 403);
        }

        //update Comment
        $Comment->update([
            'title'         => $request->title,
        ]);

        if($Comment) {
            $video = Video::whereId($request->video_id)
            ->with('comments', function($comments){
                $comments
                ->with('student')
                ->with('teacher')
                ->with('replyComments', function($replyComments){
                    $replyComments
                    ->with('student')
                    ->with('teacher')
                    ->oldest();
                })->latest();
            })->first();

            //return success with Api Resource
            return new CommentResource(true, 'Data Comment Berhasil Diupdate!', $video);
        }

        //return failed with Api Resource
        return new CommentResource(false, 'Data Comment Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $Comment)
    {
        $video = Video::whereId($Comment->video_id)
            ->with('comments', function($comments){
                $comments
                ->with('student')
                ->with('teacher')
                ->with('replyComments', function($replyComments){
                    $replyComments
                    ->with('student')
                    ->with('teacher')
                    ->oldest();
                })->latest();
            })->first();

        if($Comment->delete()) {
            //return success with Api Resource
            return new CommentResource(true, 'Data Comment Berhasil Dihapus!', $video);
        }

        //return failed with Api Resource
        return new CommentResource(false, 'Data Comment Gagal Dihapus!', null);
    }
}
