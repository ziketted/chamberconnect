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
            'description' => ['nullable', 'string'],
            'initials' => ['nullable', 'string', 'max:8'],
            'website' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $partner = new Partner($data);
        $partner->chamber_id = $chamber->id;
        if ($request->hasFile('logo')) {
            $partner->logo_path = $request->file('logo')->store('partners/logos', 'public');
        }
        $partner->save();

        return redirect()->back()->with('success', 'Partenaire ajouté avec succès');
    }

    public function update(Request $request, Chamber $chamber, Partner $partner)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'initials' => ['nullable', 'string', 'max:8'],
            'website' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('partners/logos', 'public');
        }

        $partner->update($data);

        return redirect()->back()->with('success', 'Partenaire mis à jour avec succès');
    }

    public function destroy(Chamber $chamber, Partner $partner)
    {
        $partner->delete();
        return redirect()->back()->with('success', 'Partenaire supprimé avec succès');
    }
}







