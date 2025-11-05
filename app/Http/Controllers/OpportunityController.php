<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index()
    {
        // Pour l'instant, retournons une vue simple
        return view('opportunities.index');
    }
}
