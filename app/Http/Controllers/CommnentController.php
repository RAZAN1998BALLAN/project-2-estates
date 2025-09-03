<?php

namespace App\Http\Controllers;

use App\Http\Pipelines\Comment\CommentPipeline;
use App\Http\Requests\CommentIndexRequest;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\DeleteCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Estate;
use App\Notifications\FcmNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommnentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CommentIndexRequest $request)
    {
        $comments = CommentPipeline::make(Comment::query())->get();
        return $this->success(
            CommentResource::collection($comments),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCommentRequest $request)
    {
        $user = Estate::findOrFail($request->estate_id)->user;

        $notificationService = new FcmNotificationService($user,"new comment",$request->comment);
        $notificationService->send();

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        return $this->success(
            CommentResource::make(Comment::create($data)),
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $comment->load('user');
        return $this->success(
            CommentResource::make($comment),
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCommentRequest $request ,Comment $comment)
    {
        $comment->delete();
        return $this->success(null,204);
    }
}
