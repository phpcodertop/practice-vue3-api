<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagerController extends Controller
{

    public function index()
    {
        $users = User::latest()->paginate(10)->onEachSide(1);
        return response()->json($users, 200);
    }

    public function show(User $user)
    {
        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required:unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        return response()->json($user, 201);
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required:unique:users',
            'password' => 'sometimes|min:6'
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password') !== null
            && $request->input('password') !== 'undefined') {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return response()->json("You can't delete your self.", 401);
        }

        $user->destroy();
        return response()->json("User deleted successfully", 200);
    }
}
