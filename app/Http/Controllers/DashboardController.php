<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chamber;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer toutes les chambres avec le nombre de membres
        $chambers = Chamber::withCount('members')->get();

        // Chambres populaires pour la sidebar
        $popular_chambers = $chambers->take(3);

        return view('dashboard', compact('chambers', 'popular_chambers'));
    }
}
