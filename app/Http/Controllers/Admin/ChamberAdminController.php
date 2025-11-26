<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chamber;

class ChamberAdminController extends Controller
{
    public function index()
    {
        $chambers = Chamber::latest()->get();
        return view('admin.chambers.admins', compact('chambers'));
    }
}






