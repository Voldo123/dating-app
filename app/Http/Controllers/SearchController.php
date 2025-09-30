<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function index() {
        return view('search.index');
    }

    public function results(Request $request) {
        $query = User::query();

        if ($request->gender) {
    $query->where('gender', $request->gender);
}

if ($request->city) {
    $query->where('city', $request->city);
}

if ($request->age_min && $request->age_max) {
    $query->whereBetween('age', [$request->age_min, $request->age_max]);
}

        $users = $query->get();

        return view('search.index', compact('users'));
    }
}
