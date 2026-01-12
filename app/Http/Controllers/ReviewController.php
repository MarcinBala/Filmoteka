<?php

namespace App\Http\Controllers;

use App\Film;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($film_id)
    {
        $film = Film::findOrFail($film_id);
        $released = \Carbon\Carbon::now()->gt($film->release);
        if(!$released)
            return redirect('/film/'. $film_id);

        $user_review = Auth::user()->reviews->where('film_id', $film->id)->first();
        return view('reviews\create', ['film' => $film, 'user_review' => $user_review]);
    }

    public function store(Request $request) {
        $user = Auth::user();
        $film_id = $request['film_id'];
        $rating = $request['rating'];
        $ajax = $request['ajax'];
        $update = false;

        $film = Film::findOrFail($film_id);
        $released = \Carbon\Carbon::now()->gt($film->release);
        if(!$released)
            return redirect('/film/'. $film_id);

        if($request['content'] && !empty($request['content'])) {
            $content = $request['content'];
        }
        else {
            $content = null;
        }

        $user_review = $user->reviews->where('film_id', $film_id)->first();

        if($user_review) {
            if( empty($user_review->content) && $user_review->rating == $rating && $ajax) {
                $user_review->delete();
                return ['store' => false];
            }
            $update = true;
        }
        else {
            $user_review = new \App\Review();
        }

        $user_review->film_id = $film_id;
        $user_review->user_id = $user->id;
        $user_review->rating = $rating;
        $user_review->content = $content;

        if($update) {
            $user_review->update();
        }
        else {
            $user_review->save();
        }

        if($ajax) {
            return ['store' => true];
        }
        return redirect('/film/'. $film_id);
    }

    public function destroy($review_id)
    {
        $review = Review::findOrFail($review_id);
        if($review->user_id != Auth::id() && Auth::user()->user_type != 'admin') {
            return null;
        }
        $film_id = $review->film_id;
        $review->delete();
        return redirect('/film/' . $film_id);
    }
}
