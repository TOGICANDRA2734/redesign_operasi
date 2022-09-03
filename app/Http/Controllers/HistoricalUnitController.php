<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoricalUnitController extends Controller
{
    public function index()
    {
        return view('historical-unit.index');
    }
}
