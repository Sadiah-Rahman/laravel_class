<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::withCount('followers')->findOrFail($id);
        $posts = $user->posts; 
        $isFollowing = Auth::check() ? Auth::user()->isFollowing($user) : false;

        return view('profile.show', compact('user', 'posts', 'isFollowing'));
    }

    public function follow(Request $request)
    {
        $userToFollow = User::findOrFail($request->id);
        if ($userToFollow->id !== Auth::id()) {
            Auth::user()->following()->syncWithoutDetaching($userToFollow->id);
        }
        return back();
    }

    public function unfollow(Request $request)
    {
        $userToUnfollow = User::findOrFail($request->id);
        Auth::user()->following()->detach($userToUnfollow->id);
        return back();
    }
}