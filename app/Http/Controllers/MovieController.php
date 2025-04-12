<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    public function index()
{
    $movies = \App\Models\Movie::all();

    return response()->json([
        'movies' => $movies
    ]);
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'poster' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    // Save the poster image
    $posterPath = $request->file('poster')->store('posters', 'public');

    // Create movie entry
    $movie = Movie::create([
        'title' => $request->title,
        'description' => $request->description,
        'poster' => $posterPath,
    ]);

    return response()->json([
        'message' => 'Movie created successfully',
        'movie' => $movie
    ], 201);
}
