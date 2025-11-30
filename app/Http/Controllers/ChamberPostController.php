<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Models\Post;
use Illuminate\Http\Request;

class ChamberPostController extends Controller
{
    public function create(Chamber $chamber)
    {
        return view('chambers.posts.create', compact('chamber'));
    }

    public function store(Request $request, Chamber $chamber)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'cover' => ['nullable', 'image'],
        ]);

        $post = new Post([
            'title' => $data['title'],
            'body' => $data['body'],
        ]);
        $post->chamber_id = $chamber->id;
        $post->user_id = $request->user()->id;
        if ($request->hasFile('cover')) {
            $post->cover_image_path = $request->file('cover')->store('posts/covers', 'public');
        }
        $post->save();

        return redirect()->route('chamber.show', $chamber)->with('status', 'Content published');
    }
}







