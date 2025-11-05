<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Models\Event;
use Illuminate\Http\Request;

class ChamberEventController extends Controller
{
    public function create(Chamber $chamber)
    {
        return view('chambers.events.create', compact('chamber'));
    }

    public function store(Request $request, Chamber $chamber)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['nullable', 'date'],
            'time' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'cover' => ['nullable', 'image'],
        ]);

        $event = new Event($data);
        $event->chamber_id = $chamber->id;
        $event->created_by = $request->user()->id;
        if ($request->hasFile('cover')) {
            $event->cover_image_path = $request->file('cover')->store('events/covers', 'public');
        }
        $event->save();

        return redirect()->route('chamber.show', $chamber)->with('status', 'Event created');
    }
}


