<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function show($post_id)
    {
        $post = \App\Post::findOrFail($post_id);
        return view('posts\show', ['post' => $post]);
    }

    public function create()
    {
        return view('posts\create');
    }

    public function store()
    {
        $data = request()->validate([
            'title' => ['required', 'string', 'max:250'],
            'content' => ['nullable', 'string', 'max: 32000'],
            'image' => ['nullable', 'image', 'max:10240'],
            'category' => ['required', 'string', 'max:250'],
        ]);

        if ( !empty($data['image']) ) {
            $imagePath = request('image')->store('uploads', 'public');
        }
        else {
            $imagePath = NULL;
        }

        $post = auth()->user()->posts()->create([
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => $imagePath,
            'category' => $data['category'],
        ]);

        return redirect('/p/'.$post->id);
    }

    public function edit($post_id)
    {
        $post = Post::findOrFail($post_id);

        if(Auth::user() && (Auth::id() == $post->user_id || Auth::user()->user_type == 'admin')) {
            return view('posts\edit_post', ['post' => $post]);
        }

        return redirect('/p/' . $post_id);
    }

    public function update(Request $request)
    {
        $post_id = $request['post'];
        $post = Post::findOrFail($post_id);

        if(Auth::user() && (Auth::id() == $post->user_id || Auth::user()->user_type == 'admin')) {
        }
        else {
            return redirect('/');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:250'],
            'content' => ['nullable', 'string', 'max: 32000'],
            'image' => ['nullable', 'image', 'max:10240'],
            'category' => ['required', 'string', 'max:250'],
        ]);

        $delete_image = $request['delete_image'] ? true : false;

        if($delete_image && !empty($post->image)) {
            File::delete(public_path('/storage/'. $post->image));
            $post->image = null;
        }

        if ( !empty($data['image']) ) {
            $imagePath = $request['image']->store('uploads', 'public');
            if(!empty($post->image)) {
                File::delete(public_path('/storage/'. $post->image));
            }
            $post->image = $imagePath;
        }

        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->category = $data['category'];

        $post->update();

        return redirect('/p/'.$post->id);
    }

    public function destroy($post_id)
    {
        $post = Post::findOrFail($post_id);

        if(Auth::user() && (Auth::id() == $post->user_id || Auth::user()->user_type == 'admin')) {
            if(!empty($post->image)) {
                File::delete(public_path('/storage/'. $post->image));
            }
            $post->delete();
        }

        return redirect('/forum');
    }


    public function like(Request $request)
    {
        $post_id = $request['post_id'];
        $like = $request['like'];
        $update = false;
        $post = \App\Post::findorFail($post_id);
        $user = Auth::user();
        $db_like = $user->postLikes()->where('post_id', $post_id)->first();

        if ($db_like) {
            if ($db_like->like == $like) {
                $db_like->delete();
                $score = $post->likes()->count() - $post->dislikes()->count();
                $post->score = $score;
                $post->update();
                return ['score' => $score];
            }
            $update = true;
        }
        else {
            $db_like = new \App\PostLike();
        }

        $db_like->like = $like;
        $db_like->user_id = $user->id;
        $db_like->post_id = $post->id;

        if($update) {
            $db_like->update();
        }
        else {
            $db_like->save();
        }

        $score = $post->likes()->count() - $post->dislikes()->count();
        $post->score = $score;
        $post->update();
        return ['score' => $score];
    }
}
