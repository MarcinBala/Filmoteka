<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Film;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $search = request()->query('search');
        if(empty($search))
            return redirect('/');

        $films = Film::where('title', 'LIKE', '%'.$search.'%')->get();
        $actors = Actor::where('name', 'LIKE', '%'.$search.'%')->get()->take(12);
        $users = User::where('name', 'LIKE', '%'.$search.'%')->orWhere('username', 'LIKE', '%'.$search.'%')->get()->take(30);

        return view('search\index', ['search' => $search, 'films' => $films, 'actors' => $actors, 'users' => $users,]);
    }

    public function films()
    {
        $search = request()->query('search');
        if(empty($search))
            return redirect('/');

        $films = Film::where('title', 'LIKE', '%'.$search.'%')->paginate(30);

        return view('search\films', ['films' => $films]);
    }
}
