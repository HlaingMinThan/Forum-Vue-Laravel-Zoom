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

    // Render the admin user edit form with the selected user
    public function edit(User $user)
    {
        return inertia('Admin/Users/UserForm', [
            'user' => $user,
        ]);
    }

    // Handle creation of a new user from the admin form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['required', 'boolean'],
        ]);

        $user = User::create($validated);

        return redirect()->route('users.index', $user)->with('success', 'User created.');
    }

    // Handle updating an existing user from the admin form
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['required', 'boolean'],
        ]);

        $user->update($validated);

        return redirect()->route('users.index', $user)->with('success', 'User updated.');
    }
}
