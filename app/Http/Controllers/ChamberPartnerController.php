<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Models\Partner;
use Illuminate\Http\Request;

class ChamberPartnerController extends Controller
{
    public function create(Chamber $chamber)
    {
        return view('chambers.partners.create', compact('chamber'));
    }

    public function store(Request $request, Chamber $chamber)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'initials' => ['nullable', 'string', 'max:8'],
            'website' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image'],
        ]);

        $partner = new Partner($data);
        $partner->chamber_id = $chamber->id;
        if ($request->hasFile('logo')) {
            $partner->logo_path = $request->file('logo')->store('partners/logos', 'public');
        }
        $partner->save();

        return redirect()->route('chamber.show', $chamber)->with('status', 'Partner added');
    }
}


