<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class ThreadController extends Controller
{
    public function index()
    {
        return inertia('Home', [
            'threads' => Thread::with('category')->filter(request('category'))->latest()->get(),
        ]);
    }

    public function show(Thread $thread)
    {
        return inertia("threads/show", [
            'thread' => $thread->load('category')
        ]);
    }

    public function create()
    {
        return inertia('NewThread', []);
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
        return redirect('/');
    }
}
