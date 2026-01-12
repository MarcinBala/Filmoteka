@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/post.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ asset('css/post.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">

        <div class="section text-center p-1">Posty Użytkownika {{$user->name}}</div>

    @foreach($posts as $post)
        <!-- Post -->
            <div class="py-3 row justify-content-center">
                <div class="col-md-9 col-lg-7">
                    <div class="post post-hover">
                        <div class="post-header d-flex justify-content-between">
                            <!-- Post Author -->
                            <div class="post-header-left d-inline-flex">
                                <div class="post-avatar-container">
                                    @if ( !empty($post->user->avatar) )
                                        <a href="/user/{{ $post->user->username }}">
                                            <img src="/storage/{{ $post->user->avatar }}" class="post-avatar" alt="{{ $post->user->name }}">
                                        </a>
                                    @else
                                        <a href="/user/{{ $post->user->username }}">
                                            <img src="/img/User_Icon.png" class="post-avatar" alt="{{ $post->user->name }}">
                                        </a>
                                    @endif
                                </div>
                                <div class="post-user-container">
                                    <a href="/user/{{ $post->user->username }}">
                                        <div class="post-user">{{ \Illuminate\Support\Str::limit($post->user->name, 30, $end='...') }}</div>
                                    </a>
                                    <div class="post-date text-muted">
                                        <a href="{{ last(request()->segments()) }}?category={{ $post->category }}">
                                            @switch($post->category)
                                                @case('filmy') <span class="post-category">Filmy</span> @break
                                                @case('seriale') <span class="post-category">Seriale</span> @break
                                                @case('kino') <span class="post-category">Kino</span> @break
                                                @case('wydarzenia') <span class="post-category">Wydarzenia</span> @break
                                                @case('naluzie') <span class="post-category">Na luzie</span> @break
                                                @case('portal') <span class="post-category">Portal</span> @break
                                                @case('pozostale') <span class="post-category">Pozostałe</span> @break
                                                @default <span class="post-category">{{$post->category}}</span>
                                            @endswitch
                                        </a>
                                        · {{ $post->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <!-- Post Likes -->
                            <div class="post-header-right d-inline-flex align-items-center">
                                <span class="like-counter mr-1">{{ $post->comments->count() }}</span>
                                <a href="/p/{{ $post->id }}"><img class="post-comment-link p-1 mr-3" src="/svg/comment.svg" alt="Komentarze"></a>

                                @if ( Auth::user() )
                                    @if( Auth::user()->postLikes()->where('post_id', $post->id)->first() && Auth::user()->postLikes()->where('post_id', $post->id)->first()->like == 1 )
                                        <img class="ajax-post-like like post-vote mb-1" src="/svg/thumbsup.svg" id="postLike{{$post->id}}" alt="↑" data-post_id="{{ $post->id }}">
                                    @else
                                        <img class="ajax-post-like like post-vote mb-1" src="/svg/thumbsup_blank.svg" id="postLike{{$post->id}}" alt="↑" data-post_id="{{ $post->id }}">
                                    @endif
                                @else
                                    <img class="post-vote mb-1" src="/svg/thumbsup_blank.svg" id="postLike{{$post->id}}" alt="↑" data-post_id="{{ $post->id }}">
                                @endif

                                <div class="px-2 like-counter" id="post-like-counter{{$post->id}}">
                                    {{ $post->likes()->where('like', 1)->count() - $post->likes()->where('like', 0)->count()}}
                                </div>

                                @if ( Auth::user() )
                                    @if( Auth::user()->postLikes()->where('post_id', $post->id)->first() && Auth::user()->postLikes()->where('post_id', $post->id)->first()->like == 0 )
                                        <img class="ajax-post-like dislike post-vote mr-2" src="/svg/thumbsdown.svg" id="postDislike{{$post->id}}" alt="↓" data-post_id="{{ $post->id }}">
                                    @else
                                        <img class="ajax-post-like dislike post-vote mr-2" src="/svg/thumbsdown_blank.svg" id="postDislike{{$post->id}}" alt="↓" data-post_id="{{ $post->id }}">
                                    @endif
                                @else
                                    <img class="post-vote mr-2" src="/svg/thumbsdown_blank.svg" id="postDislike{{$post->id}}" alt="↓" data-post_id="{{ $post->id }}">
                                @endif

                                @if( Auth::user() && ( Auth::id()==$post->user->id || Auth::user()->user_type=='admin') )
                                    <div class="dropdown">
                                        <a href="#" id="imageDropdown" data-toggle="dropdown">
                                            <img src="/svg/three-dots.svg">
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="imageDropdown">
                                            <a href="/p/{{$post->id}}/edit"><button class="dropdown-item" type="button">Edytuj</button></a>
                                            <form method="POST" action="{{ route('post.destroy', $post->id) }}">
                                                @csrf
                                                <input class="dropdown-item" type="submit" value="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć ten post?');">
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <!-- Post Text -->
                        <div class="post-text px-3">
                            <div class="post-title py-2 max-lines-6">{{ $post->title }}</div>
                            @if ( !empty($post->content) )
                                <div class="py-2 max-lines-12">{{$post->content}}</div>
                            @endif
                        </div>

                        <!-- Post Image -->
                        @if ( !empty($post->image) )
                            <div class="post-media">
                                <img src="/storage/{{ $post->image }}" class="post-img" id="postImg{{ $post->id }}" alt="Obraz">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    @endforeach

@endsection
