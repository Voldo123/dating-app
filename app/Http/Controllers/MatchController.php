<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMatch;

class MatchController extends Controller
{
    public function index()
    {
        $matches = Auth::user()->matches()->with(['user1', 'user2'])->get();
        
        return view('matches.index', compact('matches'));
    }
}