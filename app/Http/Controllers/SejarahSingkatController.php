<?php

namespace App\Http\Controllers;

use App\Models\SejarahSingkat;
use Illuminate\Http\Request;

class SejarahSingkatController extends Controller
{
    public function index()
    {
        $sejarahSingkats = SejarahSingkat::orderBy('tahun', 'asc')->get();
        
        return view('sejarah-singkat', compact('sejarahSingkats'));
    }
}
