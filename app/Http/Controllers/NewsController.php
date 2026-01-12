<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = \App\News::orderByDesc('created_at')->paginate(15);
        return view ('news\news', ['news' => $news]);
    }

    public function show($news)
    {
        $news = \App\News::findOrFail($news);
        $user = \App\User::findOrFail($news->user_id);
        return view('news\show', ['data' => $news, 'user' => $user]);
    }

    public function create()
    {
        return view('news\create');
    }

    public function edit($news_id)
    {
        $news = \App\News::findOrFail($news_id);
        return view('news\edit', ['news' => $news]);
    }

    public function store()
    {
        $data = request()->validate([
            'title' => ['required', 'string', 'max:250'],
            'content' => ['required', 'string', 'max:64000'],
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $news = auth()->user()->news()->create([
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => $imagePath,
        ]);

        return redirect('/news/'.$news->id);
    }

    public function update(Request $request)
    {
        $news = \App\News::findOrFail($request['news']);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:250'],
            'content' => ['required', 'string', 'max:64000'],
            'image' => ['nullable', 'image'],
        ]);

        $news->title = $data['title'];
        $news->content = $data['content'];

        if(!empty($data['image'])) {
            $imagePath = request('image')->store('uploads', 'public');
            File::delete(public_path('/storage/'. $news->image));
            $news->image = $imagePath;
        }

        $news->update();

        return redirect('/news/'.$news->id);
    }

    public function destroy($news_id)
    {
        $news = \App\News::findOrFail($news_id);
        if($news->delete()) {
            Session::flash('msg', 'News został pomyślnie usunięty.');
        }
        return redirect('/news');
    }

    public function like(Request $request)
    {
        $news_id = $request['news_id'];
        $like = $request['like'];
        $update = false;
        $news = \App\News::findorFail($news_id);
        $user = Auth::user();
        $db_like = $user->newsLikes()->where('news_id', $news_id)->first();

        if ($db_like) {
            if ($db_like->like == $like) {
                $db_like->delete();
                $score = $news->likes()->count() - $news->dislikes()->count();
                return ['score' => $score];
            }
            $update = true;
        }
        else {
            $db_like = new \App\NewsLike();
        }

        $db_like->like = $like;
        $db_like->user_id = $user->id;
        $db_like->news_id = $news->id;

        if($update) {
            $db_like->update();
        }
        else {
            $db_like->save();
        }

        $score = $news->likes()->count() - $news->dislikes()->count();
        return ['score' => $score];
    }
}
