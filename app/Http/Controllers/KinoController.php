<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KinoController extends Controller
{
    public function index()
    {
        return view('kino');
    }
    public function kontakt()
    {
        return view('kontakt');
    }
}
