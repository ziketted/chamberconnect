<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $upcoming_events = Event::with('chamber')->where('status', 'upcoming')->orderBy('date', 'desc')->get();
        $past_events = Event::with('chamber')->where('status', 'past')->orderBy('date', 'desc')->get();

        $user_chambers = [];
        if (Auth::check()) {
            $user = Auth::user();
            /** @var \App\Models\User $user */
            $user_chambers = $user->chambers()->withCount(['approvedMembers as members_count' => function () {}])->get();
        }

        return view('events.index', compact('upcoming_events', 'past_events', 'user_chambers'));
    }
}
