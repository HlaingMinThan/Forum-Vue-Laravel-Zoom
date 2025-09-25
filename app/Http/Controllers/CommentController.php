<?php

namespace App\Http\Controllers;

use App\Utility\NotificationUtility;
use Exception;
use App\Models\Thread;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    use NotificationUtility;
    public function store(Thread $thread)
    {
        request()->validate([
            'body' => 'required'
        ]);

        DB::beginTransaction();
        try {
           $comment = $thread->comments()->create([
                'user_id' => auth()->id(),
                'body' => request('body'),
                // 'thread_id' => $thread->id
            ]);
            // send email and noti 
            $this->sendCommentNotification($thread, $comment);
            DB::commit();
            return back();
        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return back();
        }
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
