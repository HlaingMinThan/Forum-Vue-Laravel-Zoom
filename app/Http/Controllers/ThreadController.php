<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Container\Attributes\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
        // dd(Thread::with('category', 'user')->filter(request(['category', 'tag', 'search']))->latest()->get()->map(function ($thread) {
        //     $thread->threadActionAuthorize = auth()->user()?->can('threadActionAuthorize', $thread);
        //     return $thread;
        // }));
        return inertia('Home', [
            'threads' => Inertia::deepMerge(
                Thread::with('category', 'user')
                    ->filter(request(['category', 'tag', 'search', 'popular', 'followed']))
                    ->latest()
                    ->paginate(5)
                    ->through(function ($thread) {
                        $thread->threadActionAuthorize = auth()->user()?->can('threadActionAuthorize', $thread);
                        return $thread;
                    }),
            ),
            'my_filter' => request('filter'),
        ]);
    }

    public function show(Thread $thread)
    {
        return inertia("threads/show", [
            'thread' => function () use ($thread) {
                return $thread->load(['category', 'user']);
            },
            'comments' => fn() => $thread->comments()->with('user')->latest()->get()->map(function ($comment) {
                $comment->commentActionAuthorize = auth()->user()?->can('commentActionAuthorize', $comment);
                return $comment;
            })
        ]);
    }

    public function create()
    {
        return inertia('threads/ThreadForm', []);
    }
    public function edit(Thread $thread)
    {
        return inertia('threads/ThreadForm', [
            'thread' => $thread->load('tags')
        ]);
    }

    public function update(Thread $thread)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|numeric',
        ], [
            'category_id.required' => 'Please select a category.'
        ]);

        $thread->title = request('title');
        $thread->body = request('body');
        $thread->category_id = request('category_id');
        $thread->user_id = auth()->id();
        $thread->save();

        $thread->tags()->detach(); //delete all thread's tags in pivot table first
        $thread->tags()->attach(request('tag_ids')); // and add all user selected tags
        return redirect(request('redirect_to', '/'));
    }
    public function store()
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|numeric',
        ], [
            'category_id.required' => 'Please select a category.'
        ]);
        $thread = new Thread();
        $thread->title = request('title');
        $thread->body = request('body');
        $thread->category_id = request('category_id');
        $thread->user_id = auth()->id();
        $thread->save();
        $thread->tags()->attach(request('tag_ids'));
        return redirect(request('redirect_to', '/'));
    }

    public function destroy(Thread $thread)
    {
        $thread->delete();
        return back();
    }

    public function adminIndex(){
        return inertia('Admin/Threads/Index', [
            'threads' => Thread::with('user', 'category')->latest()->get(),
        ]);
    }

    public function adminShow(Thread $thread){
        $thread->load(['user', 'category', 'tags']);
        return inertia('Admin/Threads/Show', [
            'thread' => $thread,
        ]);
    }

    public function AdminDestroy(Thread $thread){
        $thread->delete();
        return back();
    }

    //for like function    
public function like(Thread $thread)
    {
        $thread->likeBy()->syncWithoutDetaching([Auth::id()]);

        return back();
    }

    public function unlike(Thread $thread)
    {
        $thread->likeBy()->detach(Auth::id());

        return back();
    }
}
