<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class ThreadController extends Controller
{
    public function index()
    {
        return inertia('Home', [
            'threads' => Thread::with('category', 'user')->filter(request(['category', 'tag', 'search']))->latest()->get()->map(function ($thread) {
                $thread->threadActionAuthorize = auth()->user()?->can('threadActionAuthorize', $thread);
                return $thread;
            })
        ]);
    }

    public function show(Thread $thread)
    {
        return inertia("threads/show", [
            'thread' => $thread->load('category', 'comments.user')
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
        return redirect('/');
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
        return redirect('/');
    }

    public function destroy(Thread $thread)
    {
        $thread->delete();
        return back();
    }
}
