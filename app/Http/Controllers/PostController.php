<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Handle Creating a Post
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            // Save to storage/app/public/uploads
            $path = $request->file('image')->store('uploads', 'public');
            $path = '/storage/' . $path; // Web accessible path
        }

        Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'image'   => $path,
        ]);

        return back()->with('success', 'Post created!');
    }

    // Handle Deleting a Post
    public function destroy(Post $post)
    {
        // Ensure user owns the post
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        $post->delete();
        return back()->with('success', 'Post deleted.');
    }

    // Show Edit Form
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        return view('posts.edit', compact('post'));
    }

    // Update Post
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) abort(403);

        $request->validate(['content' => 'required']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $post->image = '/storage/' . $path;
        }

        $post->content = $request->content;
        $post->save();

        return redirect()->route('dashboard');
    }
}