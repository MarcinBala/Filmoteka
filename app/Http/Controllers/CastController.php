<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CastController extends Controller
{
    public function create($film_id)
    {
        $film = Film::findOrFail($film_id);
        $cast_list = $film->cast->sortBy('order');
        return view('cast\create', ['film' => $film, 'cast_list' => $cast_list]);
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        $filterResult = Actor::where('name', 'LIKE', '%'. $query. '%')->get();
        foreach ($filterResult as $data) {
            if(!empty($data->date_of_birth)) {
                $data->date = date('Y-m-d', strtotime($data->date_of_birth));
            }
            $data->place = $data->place_of_birth;
        }
        return response()->json($filterResult);
    }

    public function store(Request $request)
    {
        $film = \App\Film::findOrFail($request['film']);
        $actor = \App\Actor::findOrFail($request['id']);

        if($film->cast->where('actor_id', $actor->id)->first()) {
            Session::flash('error-msg', 'Ten aktor już jest w obsadzie tego filmu.');
            return redirect(route('cast.create', $film->id));
        }

        $data = $request->validate([
            'order' => ['required', 'integer', 'min:1','max:100'],
            'role' => ['required', 'string', 'max:500']
        ]);

        $cast = new \App\Cast();
        $cast->film_id = $film->id;
        $cast->actor_id = $actor->id;
        $cast->order = $data['order'];
        $cast->role = $data['role'];
        $cast->save();

        return redirect(route('cast.create', $film->id));
    }

    public function update(Request $request)
    {
        $cast = \App\Cast::findOrFail($request['cast_id']);
        $film = \App\Film::findOrFail($cast->film_id);

        $data = $request->validate([
            'order' => ['required', 'integer', 'min:1','max:100']
        ]);

        $cast->order = $data['order'];
        $cast->update();

        return redirect(route('cast.create', $film->id));
    }

    public function destroy(Request $request)
    {
        $cast = \App\Cast::findOrFail($request['cast_id']);
        $film = \App\Film::findOrFail($cast->film_id);
        if($cast->delete()) {
            Session::flash('msg', 'Aktor został pomyślnie usunięty z obsady.');
        }
        else {
            Session::flash('error-msg', 'Wystąpił błąd.');
        }
        return redirect(route('cast.create', $film->id));
    }
}
