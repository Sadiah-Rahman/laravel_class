<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'posts');
        $results = [];

        if ($query) {
            if ($type === 'users') {
                $results = User::where('name', 'like', "%{$query}%")->get();
            } else {
                $results = Post::where('content', 'like', "%{$query}%")
                    ->with('user')
                    ->latest()
                    ->get();
            }
        }

        return view('search.results', compact('results', 'query', 'type'));
    }
}