<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index($username)
    {
        $user = \App\User::where('username', $username)->firstOrFail();
        $favourites = $user->favourites->sortByDesc('created_at');
        $wantToSee = $user->wantToSee->sortByDesc('created_at');
        return view('user\user', ['user' => $user, 'favourites' => $favourites, 'wantToSee' => $wantToSee]);
    }

    public function edit($username)
    {
        $user = \App\User::where('username', $username)->firstOrFail();

        if(Auth::user() && (Auth::id() == $user->id || Auth::user()->user_type == 'admin')) {
            return view('user\edit_profile', ['user' => $user]);
        }
        else {
            return redirect('/user/'. $user->username);
        }
    }

    public function update(Request $request)
    {
        $user = \App\User::where('username', $request['user'])->firstOrFail();

        if(Auth::user() && (Auth::id() == $user->id || Auth::user()->user_type == 'admin')) {
        }
        else {
            return redirect('/user/'. $user->id);
        }

        $data = $request->validate([
            'avatar' => ['nullable', 'image', 'max:2000', 'dimensions:max_width=600,max_height=600,ratio=1/1'],
            'name' => ['required', 'string', 'max:30'],
            'description' => ['nullable', 'string', 'max:1000'],
            'user_type' => ['nullable', 'string', 'max:30'],
        ]);

        $show_films = $request['show_films'] ? true : false;
        $show_posts = $request['show_posts'] ? true : false;

        if(!empty($data['user_type']) && ($data['user_type']=='admin' || $data['user_type']=='critic' || $data['user_type']=='user') && Auth::check() && Auth::user()->user_type=='admin') {
            $user->user_type = $data['user_type'];
        }

        $delete_avatar = false;
        if ( !empty($data['avatar']) ) {
            $delete_avatar = $user->avatar;
            $imagePath = $request['avatar']->store('uploads', 'public');
        }
        elseif ( !empty(Auth::user()->avatar) ) {
            $imagePath = Auth::user()->avatar;
        }
        else {
            $imagePath = NULL;
        }

        $user->avatar = $imagePath;
        $user->name = $data['name'];
        $user->description = $data['description'];
        $user->show_films = $show_films;
        $user->show_posts = $show_posts;

        if($user->update() && $delete_avatar) {
            File::delete(public_path('/storage/'. $delete_avatar));
        }

        return redirect('user/' . $user->username);
    }

    public function posts($username)
    {
        $user = \App\User::where('username', $username)->firstOrFail();

        if(!$user->show_posts && Auth::id() != $user->id)
            return redirect('/user/'. $user->id);

        $posts = $user->posts->sortByDesc('created_at');

        return view('user\posts', ['user' => $user, 'posts' => $posts]);
    }

    public function favourites($username)
    {
        $user = \App\User::where('username', $username)->firstOrFail();

        if(!$user->show_films && Auth::id() != $user->id)
            return redirect('/user/'. $user->id);

        $films = $user->favourites->sortByDesc('created_at');

        return view('user\favourites', ['user' => $user, 'films' => $films]);
    }

    public function wantToSee($username)
    {
        $user = \App\User::where('username', $username)->firstOrFail();

        if(!$user->show_posts && Auth::id() != $user->id)
            return redirect('/user/'. $user->id);

        $films = $user->wantToSee->sortByDesc('created_at');

        return view('user\want_to_see', ['user' => $user, 'films' => $films]);
    }

    public function destroy(Request $request)
    {
        $user_id = $request['user'];
        $user = \App\User::findOrFail($user_id);


        if(Auth::check() && Auth::user()->user_type == 'admin') {
            if($user->delete()) {
                Session::flash('msg', 'Użytkownik został pomyślnie usunięty.');
            }
        }

        return redirect('/');
    }
}
