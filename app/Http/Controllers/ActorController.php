<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ActorController extends Controller
{
    public function show($actor_id)
    {
        $actor = \App\Actor::findOrFail($actor_id);
        return view('actor\show', ['actor' => $actor]);
    }

    public function create()
    {
        return view('actor\create');
    }

    public function edit($actor_id)
    {
        $actor = \App\Actor::findOrFail($actor_id);
        return view('actor\edit', ['actor' => $actor]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:300'],
            'photo' => ['nullable', 'image'],
            'date_of_birth' => ['nullable', 'date'],
            'place_of_birth' => ['nullable', 'string', 'max:300'],
            'description' => ['nullable', 'string', 'max:32000'],
        ]);

        $imagePath = null;
        if(!empty($data['photo'])) {
            $imagePath = $request['photo']->store('uploads', 'public');
        }

        $actor = new Actor();
        $actor->name = $data['name'];
        $actor->photo = $imagePath;
        $actor->date_of_birth = $data['date_of_birth'];
        $actor->place_of_birth = $data['place_of_birth'];
        $actor->description = $data['description'];

        $actor->save();

        return redirect('/actor/'.$actor->id);
    }

    public function update(Request $request)
    {
        $actor = \App\Actor::findOrFail($request['actor']);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:300'],
            'photo' => ['nullable', 'image'],
            'date_of_birth' => ['nullable', 'date'],
            'place_of_birth' => ['nullable', 'string', 'max:300'],
            'description' => ['nullable', 'string', 'max:32000'],
        ]);

        $delete_photo = $request['delete_photo'] ? true : false;
        if($delete_photo) {
            File::delete(public_path('/storage/'. $actor->photo));
            $actor->photo = null;
        }

        $imagePath = $actor->photo;
        if(!empty($data['photo'])) {
            $imagePath = $request['photo']->store('uploads', 'public');
            if(!empty($actor->photo)) {
                File::delete(public_path('/storage/'. $actor->photo));
                $actor->photo = null;
            }
        }

        $actor->name = $data['name'];
        $actor->photo = $imagePath;
        $actor->date_of_birth = $data['date_of_birth'];
        $actor->place_of_birth = $data['place_of_birth'];
        $actor->description = $data['description'];

        $actor->update();

        return redirect('/actor/'. $actor->id);
    }

    public function destroy($actor_id)
    {
        $actor = Actor::findOrFail($actor_id);
        if($actor->delete()) {
            Session::flash('msg', 'Aktor został pomyślnie usunięty.');
        }
        return redirect('/');
    }


}
