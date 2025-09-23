<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show(User $user)
    {
        return inertia('Profile/show', [
            'user' => $user,
            'already_followed' => auth()->user()->alreadyFollowed($user)
        ]);
    }

    public function create()
    {
        return inertia('Admin/Users/UserForm');
    }

    public function edit(User $user)
    {
        return inertia('Admin/Users/UserForm', [
            'user' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['required', 'boolean'],
        ]);

        $user = User::create($validated);

        return redirect()->route('users.edit', $user)->with('success', 'User created.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['required', 'boolean'],
        ]);

        $user->update($validated);

        return redirect()->route('users.edit', $user)->with('success', 'User updated.');
    }
}
