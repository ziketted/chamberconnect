<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Models\Forum;
use Illuminate\Http\Request;

class ChamberForumController extends Controller
{
    public function create(Chamber $chamber)
    {
        return view('chambers.forums.create', compact('chamber'));
    }

    public function store(Request $request, Chamber $chamber)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $forum = new Forum($data);
        $forum->chamber_id = $chamber->id;
        $forum->save();

        return redirect()->route('chamber.show', $chamber)->with('status', 'Forum created');
    }
}







