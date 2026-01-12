<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function like(Request $request)
    {
        $comment_id = $request['comment_id'];
        $like = $request['like'];
        $update = false;
        $comment = \App\Comment::findorFail($comment_id);
        $user = Auth::user();
        $db_like = $user->commentLikes()->where('comment_id', $comment_id)->first();

        if ($db_like) {
            if ($db_like->like == $like) {
                $db_like->delete();
                $score = $comment->likes()->count() - $comment->dislikes()->count();
                return ['score' => $score];
            }
            $update = true;
        }
        else {
            $db_like = new \App\CommentLike();
        }

        $db_like->like = $like;
        $db_like->user_id = $user->id;
        $db_like->comment_id = $comment->id;

        if($update) {
            $db_like->update();
        }
        else {
            $db_like->save();
        }

        $score = $comment->likes()->count() - $comment->dislikes()->count();
        return ['score' => $score];
    }

    public function view(Request $request) {
        $post_id = $request['post_id'];
        $list = [];

        $comments = Comment::where('post_id', $post_id)->get();
        $comments = $comments->sortByDesc(function($comm){
            return $comm->score;
        });
        //$comments = \App\Comment::where('post_id', $post_id)->orderByDesc('created_at')->get();

        foreach ($comments as $comment) {
            $html = view('comments-template')
                ->with('c', $comment)
                ->render();
            $list[] = $html;
        }

        return $list;
    }

    public function store(Request $request)
    {
        $post_id = $request['post_id'];
        $reply_to_id = $request['reply_to_id'];

        $data = $request->validate([
            'content' => ['required', 'string', 'max:8000']
        ]);

        $post = \App\Post::findorFail($post_id);
        $user = Auth::user();

        $comment = new \App\Comment();
        $comment->post_id = $post->id;
        $comment->user_id = $user->id;
        $comment->reply_to_id = $reply_to_id;
        $comment->content = $data['content'];

        $comment->save();

        $request = new Request();
        $request['post_id'] = $post_id;
        $view = $this->view($request);

        return response()->json($view);
    }

    public function edit(Request $request)
    {
        $comment_id = $request['comment_id'];

        $data = $request->validate([
            'content' => ['required', 'string', 'max:8000']
        ]);

        $comment = \App\Comment::findOrFail($comment_id);
        $post = \App\Post::findorFail($comment->post_id);

        if(Auth::user() && (Auth::id() == $comment->user_id || Auth::user()->user_type == 'admin')) {
            $comment->content = $data['content'];
            $comment->update();
        }

        $request = new Request();
        $request['post_id'] = $post->id;

        $view = $this->view($request);
        return response()->json($view);
    }

    public function destroy(Request $request)
    {
        $comment_id = $request['comment_id'];

        $comment = \App\Comment::findOrFail($comment_id);
        $post = \App\Post::findorFail($comment->post_id);

        if(Auth::user() && (Auth::id() == $comment->user_id || Auth::user()->user_type == 'admin')) {
            \App\Comment::where('reply_to_id', $comment->id)->delete();
            $comment->delete();
        }

        $request = new Request();
        $request['post_id'] = $post->id;

        $view = $this->view($request);
        return response()->json($view);
    }
}
