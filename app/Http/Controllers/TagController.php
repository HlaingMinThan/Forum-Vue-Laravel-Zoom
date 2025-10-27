<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::latest()->get();
        return Inertia::render('Admin/Tags/Index',[
            'tags' => $tags,
        ]);
    }

    public function store(){
        request()->validate([
            'name'=>['required'],
        ]);
        $tag = new Tag();
        $tag->name = request('name');
        $tag->slug = Str::slug(request('name'),'_');
        $tag->save();
        return redirect(route('admin.tags'));
    }

    public function update(Tag $tag){
        request()->validate([
            'name'=>['required'],
        ]);
        $tag->name = request('name');
        $tag->slug = Str::slug(request('name'),'_');
        $tag->save();
        return redirect(route('admin.tags'));
    }

    public function delete(Tag $tag){
        $tag->delete();
        return back();
    }
}
