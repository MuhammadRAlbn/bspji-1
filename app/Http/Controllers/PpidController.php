<?php

namespace App\Http\Controllers;

use App\Models\Ppid;
use Illuminate\Contracts\View\View;

class PpidController extends Controller
{
    public function index(): View
    {
        $ppid = Ppid::first();

        return view('ppid', compact('ppid'));
    }
}
