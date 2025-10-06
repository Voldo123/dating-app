<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        $cities = User::whereNotNull('city')->distinct()->pluck('city');
        
        return view('search.index', compact('tags', 'cities'));
    }

    public function results(Request $request)
    {
        $query = User::where('id', '!=', Auth::id());

        // Фильтр по полу
        if ($request->has('gender') && $request->gender) {
            $query->where('gender', $request->gender);
        }

        // Фильтр по возрасту
        if ($request->has('age_from') && $request->age_from) {
            $query->where('age', '>=', $request->age_from);
        }
        if ($request->has('age_to') && $request->age_to) {
            $query->where('age', '<=', $request->age_to);
        }

        // Фильтр по городу
        if ($request->has('city') && $request->city) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Фильтр по тегам
        if ($request->has('tags') && !empty($request->tags)) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->whereIn('tags.id', $request->tags);
            });
        }

        $users = $query->with('tags')->get();
        $resultsCount = $users->count();

        return view('search.results', compact('users', 'resultsCount'));
    }
}