<?php

namespace App\Http\Controllers;

use App\Director;
use App\Film;
use App\Genre;
use App\Production;
use App\Review;
use App\User;
use App\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class FilmController extends Controller
{
    public function index()
    {
        $currentDate = \Carbon\Carbon::now();
        $agoDate = \Carbon\Carbon::now()->startOfDay()->subMonth();

        $recentReleases = Film::whereBetween('release', [$agoDate, $currentDate])->orderByDesc('release')->get();
        //$recentReleases = Film::orderByDesc('release')->limit(12);
        $popularReleases = Film::whereBetween('release', [$agoDate, $currentDate])->withCount('favourites')->orderByDesc('favourites_count')->get();

        $highestRated = DB::table('reviews')
            ->join('films', 'reviews.film_id', '=', 'films.id')
            ->select(DB::raw('avg(rating) as average, films.*'))
            ->groupBy('reviews.film_id')
            ->whereBetween('films.release', [$agoDate, $currentDate])
            ->orderBy('average', 'desc')
            ->limit(20)
            ->get();

        $featured = Film::whereBetween('release', [$agoDate, $currentDate])->withCount('favourites')->orderByDesc('favourites_count')->first();

        $futureDate = \Carbon\Carbon::now()->startOfDay()->addMonths(6);
        $awaitedReleases = Film::whereBetween('release', [$currentDate, $futureDate])->withCount('wantToSee')->orderByDesc('want_to_see_count')->limit(12)->get();

        $allReleases = Film::where('release', '>', $agoDate)->orderByDesc('release');

        $news = \App\News::orderByDesc('created_at')->limit(6)->get();

        return view('films\films', [
            'featured' => $featured,
            'popularReleases' => $popularReleases,
            'recentReleases' => $recentReleases,
            'awaitedReleases' => $awaitedReleases,
            'allReleases' => $allReleases,
            'highestRated' => $highestRated,
            'news' => $news
        ]);
    }

    public function create()
    {
        return view('films\create');
    }

    public function edit($film_id)
    {
        $film = Film::findOrFail($film_id);
        return view('films\edit', ['film' => $film]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:250', 'unique:films'],
            'original_title' => ['required', 'string', 'max:250'],
            'release' => ['required', 'date'],
            'image' => ['required', 'image', 'max:10000'],
            'poster' => ['nullable', 'image', 'max:5000'],
            'video' => ['nullable', 'mimes:mp4,mov,avi', 'max:100000'],
            'length' => ['nullable', 'integer', 'min:0','max:1000'],
            'description' => ['nullable', 'string', 'max:32000'],

            'genre' => ['nullable', 'array', 'max:5'],
            'genre.*' => ['nullable', 'string', 'max:100'],

            'director' => ['nullable', 'array', 'max:3'],
            'director.*' => ['nullable', 'string', 'max:300'],

            'writer' => ['nullable', 'array', 'max:3'],
            'writer.*' => ['nullable', 'string', 'max:300'],

            'production' => ['nullable', 'array', 'max:5'],
            'production.*' => ['nullable', 'string', 'max:100'],
        ]);

        $imagePath = null;
        if(!empty($data['image'])) {
            $imagePath = $request['image']->store('uploads', 'public');
        }
        else {
            $imagePath = 'uploads/Movie_Image.jpg';
        }
        $posterPath = null;
        if(!empty($data['poster'])) {
            $posterPath = $request['poster']->store('uploads', 'public');
        }
        $videoPath = null;
        if(!empty($data['video'])) {
            $videoPath = $request['video']->store('uploads', 'public');
        }

        if(empty($data['length'])) $data['length'] = NULL;
        if(empty($data['description'])) $data['description'] = NULL;
        if(empty($data['genre'])) $data['genre'] = NULL;
        if(empty($data['director'])) $data['director'] = NULL;
        if(empty($data['writer'])) $data['writer'] = NULL;
        if(empty($data['production'])) $data['production'] = NULL;

        $film = new Film();
        $film->title = $data['title'];
        $film->original_title = $data['original_title'];
        $film->release = $data['release'];
        $film->image = $imagePath;
        $film->poster = $posterPath;
        $film->video = $videoPath;
        $film->length = $data['length'];
        $film->description = $data['description'];

        $film->save();

        if(!empty($data['genre'])) {
            foreach($data['genre'] as $val) {
                if(!empty($val)) {
                    $obj = new Genre();
                    $obj->film_id = $film->id;
                    $obj->name =  $val;
                    $obj->save();
                }
            }
        }
        if(!empty($data['director'])) {
            foreach($data['director'] as $val) {
                if(!empty($val)) {
                    $obj = new Director();
                    $obj->film_id = $film->id;
                    $obj->name =  $val;
                    $obj->save();
                }
            }
        }
        if(!empty($data['writer'])) {
            foreach($data['writer'] as $val) {
                if(!empty($val)) {
                    $obj = new Writer();
                    $obj->film_id = $film->id;
                    $obj->name =  $val;
                    $obj->save();
                }
            }
        }
        if(!empty($data['production'])) {
            foreach($data['production'] as $val) {
                if(!empty($val)) {
                    $obj = new Production();
                    $obj->film_id = $film->id;
                    $obj->name =  $val;
                    $obj->save();
                }
            }
        }

        return redirect('/film/'. $film->id);
    }

    public function update(Request $request)
    {
        $film = Film::findOrFail($request['film_id']);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:250', Rule::unique('films')->ignore($film->id)],
            'original_title' => ['required', 'string', 'max:250'],
            'release' => ['required', 'date'],
            'image' => ['nullable', 'image', 'max:10000'],
            'poster' => ['nullable', 'image', 'max:5000'],
            'video' => ['nullable', 'mimes:mp4,mov,avi', 'max:100000'],
            'length' => ['nullable', 'integer', 'min:0','max:1000'],
            'description' => ['nullable', 'string', 'max:32000'],

            'genre' => ['nullable', 'array', 'max:5'],
            'genre.*' => ['nullable', 'string', 'max:100'],

            'director' => ['nullable', 'array', 'max:3'],
            'director.*' => ['nullable', 'string', 'max:300'],

            'writer' => ['nullable', 'array', 'max:3'],
            'writer.*' => ['nullable', 'string', 'max:300'],

            'production' => ['nullable', 'array', 'max:5'],
            'production.*' => ['nullable', 'string', 'max:100'],
        ]);

        $imagePath = $film->image;
        if(!empty($data['image'])) {
            $imagePath = $request['image']->store('uploads', 'public');
            if(!empty($film->image)) {
                //File::delete(public_path('/storage/'. $film->image));
                $film->image = null;
                $film->update();
            }
        }
        $posterPath = $film->poster;
        if(!empty($data['poster'])) {
            $posterPath = $request['poster']->store('uploads', 'public');
            if(!empty($film->poster)) {
                //File::delete(public_path('/storage/'. $film->poster));
                $film->poster = null;
                $film->update();
            }
        }
        $videoPath = $film->video;
        if(!empty($data['video'])) {
            $videoPath = $request['video']->store('uploads', 'public');
            if(!empty($film->video)) {
                //File::delete(public_path('/storage/'. $film->video));
                $film->video = null;
                $film->update();
            }
        }

        $film->title = $data['title'];
        $film->original_title = $data['original_title'];
        $film->release = $data['release'];
        $film->image = $imagePath;
        $film->poster = $posterPath;
        $film->video = $videoPath;
        $film->length = $data['length'];
        $film->description = $data['description'];

        $film->update();

        Genre::where('film_id', $film->id)->delete();
        foreach($data['genre'] as $val) {
            if(!empty($val)) {
                $obj = new Genre();
                $obj->film_id = $film->id;
                $obj->name =  $val;
                $obj->save();
            }
        }
        Director::where('film_id', $film->id)->delete();
        foreach($data['director'] as $val) {
            if(!empty($val)) {
                $obj = new Director();
                $obj->film_id = $film->id;
                $obj->name =  $val;
                $obj->save();
            }
        }
        Writer::where('film_id', $film->id)->delete();
        foreach($data['writer'] as $val) {
            if(!empty($val)) {
                $obj = new Writer();
                $obj->film_id = $film->id;
                $obj->name =  $val;
                $obj->save();
            }
        }
        Production::where('film_id', $film->id)->delete();
        foreach($data['production'] as $val) {
            if(!empty($val)) {
                $obj = new Production();
                $obj->film_id = $film->id;
                $obj->name =  $val;
                $obj->save();
            }
        }

        return redirect('/film/'. $film->id);
    }

    public function destroy(Request $request)
    {
        $film = Film::findOrFail($request['film_id']);
        if($film->delete()) {
            Session::flash('msg', 'Film został pomyślnie usunięty.');
        }
        else {
            Session::flash('error-msg', 'Wystąpił błąd.');
        }
        return redirect('/films');
    }

    public function show($film_id)
    {
        $film = Film::findOrFail($film_id);
        if(Auth::user()) {
            $user_review = Auth::user()->reviews->where('film_id', $film->id)->first();
        }
        else {
            $user_review = null;
        }

        $released = \Carbon\Carbon::now()->gt($film->release);

        $criticReviews = $film->reviews->whereNotNull('content')->where('user.user_type', 'critic')->sortByDesc('created_at');
        $userReviews = $film->reviews->whereNotNull('content')->where('user.user_type', '!=', 'critic')->sortByDesc('created_at');

        $criticRatings = $film->reviews->where('user.user_type', 'critic');
        $userRatings = $film->reviews->where('user.user_type', '!=', 'critic');

        if($criticRatings->count() == 0) { $criticScore = '-'; }
        else { $criticScore = number_format($criticRatings->avg('rating'), 1); }
        if($userRatings->count() == 0) { $userScore = '-'; }
        else { $userScore = number_format($userRatings->avg('rating'), 1); }

        $currentDate = \Carbon\Carbon::now();
        $agoDate = \Carbon\Carbon::now()->startOfDay()->subMonth();
        $recentRatings = $film->reviews->whereBetween('created_at', [$agoDate, $currentDate]);

        $chart = $this->chart($film, $recentRatings);

        $chartData = $chart[0];
        $chartLabels = $chart[1];

        return view('films\show', [
            'film' => $film,
            'released' => $released,
            'user_review' => $user_review,
            'criticReviews' => $criticReviews,
            'userReviews' => $userReviews,
            'criticRatings' => $criticRatings,
            'userRatings' => $userRatings,
            'criticScore' => $criticScore,
            'userScore' => $userScore,
            'recentRatings' => $recentRatings,
            'chartData' => $chartData,
            'chartLabels' => $chartLabels
        ]);
    }

    public function statistics($film_id)
    {
        $film = Film::findOrFail($film_id);

        $released = \Carbon\Carbon::now()->gt($film->release);
        if(!$released)
            return redirect('/film/'. $film_id);

        $criticRatings = $film->reviews->where('user.user_type', 'critic');
        $userRatings = $film->reviews->where('user.user_type', '!=', 'critic');

        if($criticRatings->count() == 0) { $criticScore = '-'; }
        else { $criticScore = number_format($criticRatings->avg('rating'), 1); }
        if($userRatings->count() == 0) { $userScore = '-'; }
        else { $userScore = number_format($userRatings->avg('rating'), 1); }

        $currentDate = \Carbon\Carbon::now();
        $agoDate = \Carbon\Carbon::now()->startOfDay()->subMonth();
        $recentRatings = $film->reviews->whereBetween('created_at', [$agoDate, $currentDate]);

        $chart = $this->chart($film, $recentRatings);
        $chart3Data = $chart[0];
        $chart3Labels = $chart[1];

        $chartAllData = $this->chartAllData($film, $userRatings, $criticRatings);
        $chartUserData = $chartAllData[0];
        $chartCriticData = $chartAllData[1];
        $chart2Data = $chartAllData[2];
        $chartLabels = $chartAllData[3];

        return view('films\statistics', [
            'film' => $film,
            'criticRatings' => $criticRatings,
            'userRatings' => $userRatings,
            'criticScore' => $criticScore,
            'userScore' => $userScore,
            'recentRatings' => $recentRatings,
            'chartUserData' => $chartUserData,
            'chartCriticData' => $chartCriticData,
            'chart2Data' => $chart2Data,
            'chartLabels' => $chartLabels,
            'chart3Data' => $chart3Data,
            'chart3Labels' => $chart3Labels
        ]);
    }

    public function chart($film, $recentRatings) {
        if($recentRatings->count() == 0) {
            return array([], []);
        }

        $chartData = [];
        $chartLabels = [];

        for($i = 0; $i < 31; $i++){
            $myDate = \Carbon\Carbon::now()->endOfDay()->subDays($i);
            $myAgoDate = \Carbon\Carbon::now()->startOfDay()->subDays($i);
            $data = $film->reviews->whereBetween('created_at', [$myAgoDate, $myDate]);

            array_unshift($chartLabels, ($myDate->isoFormat('D MMM')));

            if($data->count() != 0) {
                $score = number_format($data->avg('rating'), 1);
                array_unshift($chartData, (float)$score);
            }
            else {
                array_unshift($chartData, null);
            }
        }

        return array($chartData, $chartLabels);
    }

    public function chartAllData($film, $userRatings, $criticRatings) {
        if($film->reviews->count() == 0){
            return array([], []);
        }

        $chartUserData = [];
        $chartCriticData = [];
        $chartDataCount = [];
        $chartLabels = [];

        $currentDate = \Carbon\Carbon::now();
        $first_review = $film->reviews->sortBy('created_at')->first();
        $interval = $currentDate->diffInMonths($first_review->created_at);

        for($i = 0; $i < $interval; $i++){
            $myDate = \Carbon\Carbon::now()->endOFMonth()->subMonthsNoOverflow($i);
            $myAgoDate = \Carbon\Carbon::now()->startOfMonth()->subMonthsNoOverflow($i);

            $userData = $userRatings->whereBetween('created_at', [$myAgoDate, $myDate]);
            $criticData = $criticRatings->whereBetween('created_at', [$myAgoDate, $myDate]);

            array_unshift($chartLabels, ($myDate->isoFormat('MMM Y')));

            if($userData->count() != 0) {
                $score = number_format($userData->avg('rating'), 1);
                array_unshift($chartUserData, (float)$score);
                array_unshift($chartDataCount, $userData->count());
            }
            else {
                array_unshift($chartUserData, null);
                array_unshift($chartDataCount, 0);
            }

            if($criticData->count() != 0) {
                $score = number_format($criticData->avg('rating'), 1);
                array_unshift($chartCriticData, (float)$score);
                $chartDataCount[0] += $criticData->count();
            }
            else {
                array_unshift($chartCriticData, null);
            }
        }

        return array($chartUserData, $chartCriticData, $chartDataCount, $chartLabels);
    }

    public function favourite(Request $request) {
        $film_id = $request['film_id'];
        $film = Film::findOrFail($film_id);

        $user = Auth::user();
        $user_fav = $user->favourites->where('film_id', $film->id)->first();

        if($user_fav) {
            $user_fav->delete();
            $favouritesCount = $film->favourites->count();
            return ['store' => false, 'favouritesCount' => $favouritesCount];
        }
        else {
            $user_fav = new \App\Favourite();
            $user_fav->film_id = $film->id;
            $user_fav->user_id = $user->id;
            $user_fav->save();
            $favouritesCount = $film->favourites->count();
            return ['store' => true, 'favouritesCount' => $favouritesCount];
        }
    }

    public function wantToSee(Request $request) {
        $film_id = $request['film_id'];
        $film = Film::findOrFail($film_id);
        $user = Auth::user();
        $user_want = $user->wantToSee->where('film_id', $film->id)->first();

        if($user_want) {
            $user_want->delete();
            $wantToSeeCount = $film->wantToSee->count();
            return ['store' => false, 'wantToSeeCount' => $wantToSeeCount];
        }
        else {
            $user_want = new \App\WantToSee();
            $user_want->film_id = $film->id;
            $user_want->user_id = $user->id;
            $user_want->save();
            $wantToSeeCount = $film->wantToSee->count();
            return ['store' => true, 'wantToSeeCount' => $wantToSeeCount];
        }
    }
}
