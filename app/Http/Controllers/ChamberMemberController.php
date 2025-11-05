<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Models\User;
use Illuminate\Http\Request;

class ChamberMemberController extends Controller
{
    public function create(Chamber $chamber)
    {
        return view('chambers.members.create', compact('chamber'));
    }

    public function store(Request $request, Chamber $chamber)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'role' => ['required', 'in:member,manager'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found']);
        }

        $chamber->members()->syncWithoutDetaching([$user->id => ['role' => $data['role']]]);

        return redirect()->route('chamber.show', $chamber)->with('status', 'Member added');
    }

    public function join(Request $request, Chamber $chamber)
    {
        $userId = $request->user()->id;
        $exists = $chamber->members()->where('user_id', $userId)->exists();
        if (!$exists) {
            $chamber->members()->attach($userId, ['role' => 'member', 'status' => 'pending']);
        }
        return back()->with('status', 'Demande d\'adhésion envoyée');
    }

    public function approve(Request $request, Chamber $chamber, User $user)
    {
        // Only managers (middleware) or admins (via managesChamber check fail but admin can be included via policy; accept here through admin flag)
        if (!$request->user()->is_admin && !$request->user()->managesChamber($chamber)) {
            abort(403);
        }
        $chamber->members()->updateExistingPivot($user->id, ['status' => 'approved']);
        return back()->with('status', 'Adhésion approuvée');
    }

    public function pending(Chamber $chamber)
    {
        $pending = $chamber->members()->wherePivot('status', 'pending')->get();
        return view('chambers.members.pending', compact('chamber', 'pending'));
    }
}
