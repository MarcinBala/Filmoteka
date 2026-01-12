<?php

namespace App\Http\Controllers;

use App\Film;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscoverController extends Controller
{
    public function index() {
        return view('discover\discover');
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        $filterResult = Film::select('title')->where('title', 'LIKE', '%'. $query. '%')->get();
        return response()->json($filterResult);
    }

    public function result(Request $request) {
        $title = $request['title'];
        $film = Film::where('title', $title)->first();

        if(!$film) {
            return redirect('/discover');
        }

        $arr = array();
        foreach($film->favourites as $ff) {
            $user = User::findOrFail($ff->user_id);
            foreach($user->favourites as $uf) {
                array_push($arr, $uf->film_id);
            }
        }

        $arr = array_count_values($arr);

        uasort($arr, function($a, $b) {
            return $b - $a;
        });

        unset($arr[$film->id]);

        $result = array();
        $i = 0;
        foreach($arr as $key=>$value)
        {
            $f = Film::findOrFail($key);
            array_push($result, array('film' => $f, 'count' => $value));
            if($i >= 29) break;
            $i++;
        }

        return view('discover\result', [
            'film' => $film,
            'result' => $result
        ]);
    }
}
