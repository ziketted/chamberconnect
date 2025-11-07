<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Chamber;

class ChamberController extends Controller
{
    public function create()
    {
        return view('chambers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'verified' => ['nullable', 'boolean'],
            'social_links' => ['nullable', 'array'],
            'logo' => ['nullable', 'image'],
            'cover' => ['nullable', 'image'],
        ]);

        $slug = Str::slug($data['name']);
        if (Chamber::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(6);
        }

        $chamber = new Chamber();
        $chamber->fill(array_merge($data, ['slug' => $slug]));

        if ($request->hasFile('logo')) {
            $chamber->logo_path = $request->file('logo')->store('chambers/logos', 'public');
        }
        if ($request->hasFile('cover')) {
            $chamber->cover_image_path = $request->file('cover')->store('chambers/covers', 'public');
        }

        $chamber->save();

        // assign creator as manager
        $user = $request->user();
        $chamber->members()->attach($user->id, ['role' => 'manager', 'status' => 'approved']);

        return redirect()->route('chamber.show', $chamber)->with('status', 'Chamber created');
    }

    public function show(Chamber $chamber)
    {
        // Route model binding by slug
        $chamber = $chamber->load(['partners', 'events' => function ($q) {
            $q->latest()->take(5);
        }]);

        return view('chamber', compact('chamber'));
    }

    public function edit(Chamber $chamber)
    {
        return view('chambers.edit', compact('chamber'));
    }

    public function update(Request $request, Chamber $chamber)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'verified' => ['nullable', 'boolean'],
            'social_links' => ['nullable', 'array'],
            'logo' => ['nullable', 'image'],
            'cover' => ['nullable', 'image'],
        ]);

        $chamber->fill($data);
        if ($request->hasFile('logo')) {
            $chamber->logo_path = $request->file('logo')->store('chambers/logos', 'public');
        }
        if ($request->hasFile('cover')) {
            $chamber->cover_image_path = $request->file('cover')->store('chambers/covers', 'public');
        }
        $chamber->save();

        return redirect()->route('chamber.show', $chamber)->with('status', 'Chamber updated');
    }
}
