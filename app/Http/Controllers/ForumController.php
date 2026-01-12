<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        return $this->hot($request);
    }

    public function readableCategory($category) {
        switch ($category) {
            case 'filmy': $return = 'Filmy'; break;
            case 'seriale': $return = 'Seriale'; break;
            case 'kino': $return = 'Kino'; break;
            case 'wydarzenia': $return = 'Wydarzenia'; break;
            case 'naluzie': $return = 'Na Luzie'; break;
            case 'portal': $return = 'Portal'; break;
            case 'pozostale': $return = 'Pozostałe'; break;
            default: $return = 'Wszystko'; break;
        }
        return $return;
    }

    public function hot(Request $request)
    {
        $category = $request->get('category', 'wszystko');
        $readableCategory = $this->readableCategory($category);
        $currentDate = \Carbon\Carbon::now();
        $agoDate = \Carbon\Carbon::now()->subWeek();

        if ( $category == 'wszystko' ) {
            $posts = \App\Post::whereBetween('created_at', [$agoDate, $currentDate])
                ->orderByDesc('score')
                ->orderByDesc('created_at')
                ->paginate(30);
        }
        else {
            $posts = \App\Post::where('category', $category)
                ->whereBetween('created_at', [$agoDate, $currentDate])
                ->orderByDesc('score')
                ->orderByDesc('created_at')
                ->paginate(30);
        }

        return view ('posts\forum', ['posts' => $posts, 'category' => $category, 'readableCategory' => $readableCategory]);
    }

    public function new(Request $request)
    {
        $category = $request->get('category', 'wszystko');
        $readableCategory = $this->readableCategory($category);

        if ( $category == 'wszystko' ) {
            $posts = \App\Post::orderByDesc('created_at')->paginate(30);
        }
        else {
            $posts = \App\Post::where('category', $category)->orderByDesc('created_at')->paginate(30);
        }

        return view ('posts\forum', ['posts' => $posts, 'category' => $category, 'readableCategory' => $readableCategory]);
    }

    public function best(Request $request)
    {
        $category = $request->get('category', 'wszystko');
        $readableCategory = $this->readableCategory($category);

        if ( $category == 'wszystko' ) {
            $posts = \App\Post::orderByDesc('score')
                ->orderByDesc('created_at')
                ->paginate(30);
        }
        else {
            $posts = \App\Post::where('category', $category)
                ->orderByDesc('score')
                ->orderByDesc('created_at')
                ->paginate(30);
        }

        return view ('posts\forum', ['posts' => $posts, 'category' => $category, 'readableCategory' => $readableCategory]);
    }
}
