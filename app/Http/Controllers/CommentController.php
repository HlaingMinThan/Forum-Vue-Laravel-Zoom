<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Thread $thread)
    {
        request()->validate([
            'body' => 'required'
        ]);
        //
        $thread->comments()->create([
            'user_id' => auth()->id(),
            'body' => request('body'),
            // 'thread_id' => $thread->id
        ]);

        return back();
    }
}
