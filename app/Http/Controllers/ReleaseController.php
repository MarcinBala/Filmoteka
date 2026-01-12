<?php

namespace App\Http\Controllers;

use App\Film;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReleaseController extends Controller
{
    public function index($month)
    {
        if($month < 1 || $month > 12)
            return redirect('/releases/1');

        $add = $month - 1;

        $firstDate = Carbon::now()->startOfMonth()->addMonths($add);
        $secondDate = Carbon::now()->endOfMonth()->addMonths($add);

        $films = Film::whereBetween('release', [$firstDate, $secondDate])->orderBy('release')->get();

        return view('releases', [
            'films' => $films,
            'month' => $month
        ]);
    }
}
