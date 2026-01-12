<?php

namespace App\Http\Controllers;

use App\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentDate = \Carbon\Carbon::now();

        $bestFilms = Film::has('reviews', '>', 24)
            ->where('release', '<', $currentDate)
            ->withCount(['reviews as average_rating' => function($query) { $query->select(DB::raw('coalesce(avg(rating),0)')); }])
            ->orderByDesc('average_rating')
            ->take(30)
            ->get();

        $newFilms = Film::where('release', '<', $currentDate)->orderByDesc('release')->get()->take(12);

        $news = \App\News::all()->sortByDesc("created_at")->skip(0)->take(5);

        $currentDate = \Carbon\Carbon::now();
        $agoDate = \Carbon\Carbon::now()->subMonth();

        $posts = \App\Post::whereBetween('created_at', [$agoDate, $currentDate])
            ->withCount('likes', 'dislikes')
            ->orderByDesc('likes_count', '-', 'dislikes_count')
            ->orderByDesc('created_at')
            ->get()
            ->take(3);

        return view('home', ['news' => $news, 'bestFilms' => $bestFilms, 'newFilms' => $newFilms, 'posts' => $posts]);
    }
}
