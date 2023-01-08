<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Video;
use App\Models\Comment;
use App\Models\ReplyComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyCommentResource;
use Illuminate\Support\Facades\Validator;

class ReplyCommentController extends Controller
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
            'comment_id'  => 'required|exists:comments,id',
            'title'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create ReplyComment
        $ReplyComment = ReplyComment::create([
            'comment_id'    => $request->comment_id,
            'teacher_id'    => auth()->guard('api_teacher')->user()->id,
            'title'         => $request->title,
        ]);

        if($ReplyComment) {
            $comment = Comment::whereId($request->comment_id)->first();
            $video = Video::whereId($comment->video_id)
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
            return new ReplyCommentResource(true, 'Data ReplyComment Berhasil Disimpan!', $video);
        }

        //return failed with Api Resource
        return new ReplyCommentResource(false, 'Data ReplyComment Gagal Disimpan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReplyComment $ReplyComment)
    {
        return response()->json([
                'success' => false,
                'message' => $ReplyComment
            ], 403);
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        

        if(auth()->guard('api_teacher')->user()->id != $ReplyComment->teacher_id){
            return response()->json([
                'success' => false,
                'message' => 'Forbidden access to update ReplyComment!'
            ], 403);
        }
        
        //update ReplyComment 
        $ReplyComment->update([
            'title'         => $request->title,
        ]);

        if($ReplyComment) {
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
            return new ReplyCommentResource(true, 'Data ReplyComment Berhasil Diupdate!', $video);
        }

        //return failed with Api Resource
        return new ReplyCommentResource(false, 'Data ReplyComment Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReplyComment $ReplyComment)
    {
        $video = Video::whereId($ReplyComment->video_id)
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

        if($ReplyComment->delete()) {
            //return success with Api Resource
            return new ReplyCommentResource(true, 'Data ReplyComment Berhasil Dihapus!', $video);
        }

        //return failed with Api Resource
        return new ReplyCommentResource(false, 'Data ReplyComment Gagal Dihapus!', null);
    }
}
