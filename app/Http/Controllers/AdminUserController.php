<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('threads')
            ->orderByDesc('created_at')
            ->get();
        return inertia('Admin/Users/Index', ['users'=>$users]);
    }
}
