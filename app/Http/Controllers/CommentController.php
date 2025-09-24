<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
        public function index()
        {
        $comments = Comment::with(['user', 'thread'])->latest()->get();
        return inertia('Admin/Comments/Index', [
            'comments' => $comments->map(function($comment) {
                return [
                    'id' => $comment->id,
                    'author_name' => $comment->user ? $comment->user->name : 'Unknown',
                    'thread_title' => $comment->thread ? $comment->thread->title : 'N/A',
                    'content' => $comment->body,
                    'created_at' => $comment->created_at,
                ];
            })
        ]);
        }
    public function store(Thread $thread)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $thread->comments()->create([
            'user_id' => auth()->id(),
            'body' => request('body'),
            // 'thread_id' => $thread->id
        ]);

        return back();
    }
    public function update(Comment $comment)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $comment->body = request('body');
        $comment->save();

        return back();
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back();
    }
}
