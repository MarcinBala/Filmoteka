@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/post.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ asset('css/post.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">

        <div class="forum-top mb-3 row d-flex justify-content-center">
            <div class="col-md-9 col-lg-7">
                <div class="border-bottom w-100 p-2 d-flex justify-content-between align-items-center">
                    <div>
                        <a href="/forum/hot?category={{ $category }}">
                            <button class="forum-sort-btn my-1 @if(last(request()->segments()) == 'hot' || last(request()->segments()) == 'forum' ) forum-sort-btn-hover @endif ">Popularne</button>
                        </a>
                        <a href="/forum/new?category={{ $category }}">
                            <button class="forum-sort-btn my-1 @if(last(request()->segments()) == 'new') forum-sort-btn-hover @endif ">Najnowsze</button>
                        </a>
                        <a href="/forum/best?category={{ $category }}">
                            <button class="forum-sort-btn my-1 @if(last(request()->segments()) == 'best') forum-sort-btn-hover @endif ">Najlepsze</button>
                        </a>
                    </div>
                    <div class="dropdown">
                        <button class="forum-category-select dropdown-toggle" data-toggle="dropdown">{{ $readableCategory }}</button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ last(request()->segments()) }}?category=wszystko">Wszystko</a>
                            <a class="dropdown-item" href="{{ last(request()->segments()) }}?category=filmy">Filmy</a>
                            <a class="dropdown-item" href="{{ last(request()->segments()) }}?category=seriale">Seriale</a>
                            <a class="dropdown-item" href="{{ last(request()->segments()) }}?category=kino">Kino</a>
                            <a class="dropdown-item" href="{{ last(request()->segments()) }}?category=wydarzenia">Wydarzenia</a>
                            <a class="dropdown-item" href="{{ last(request()->segments()) }}?category=naluzie">Na Luzie</a>
                            <a class="dropdown-item" href="{{ last(request()->segments()) }}?category=portal">Portal</a>
                            <a class="dropdown-item" href="{{ last(request()->segments()) }}?category=pozostale">Pozostałe</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex row justify-content-center mb-3">
            <div class="col-md-9 col-lg-7">
                @if( Auth::user() )
                <div class="border p-2 w-100 d-inline-flex">
                    @if ( !empty(Auth::user()->avatar) )
                        <img src="/storage/{{ Auth::user()->avatar }}" class="comment-avatar" alt="{{ Auth::user()->name }}">
                    @else
                        <img src="/img/User_Icon.png" class="comment-avatar" alt="{{ Auth::user()->name }}">
                    @endif
                    <div class="w-100 ml-2">
                        <a href="/p/create"><input class="forum-top-input text-muted d-block w-100 px-2" placeholder="Napisz coś..." readonly></a>
                    </div>
                </div>
                @endif
            </div>
        </div>

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
                                    {{ $post->score }}
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

        <!-- Pages -->
        <div class="d-flex justify-content-center">
            {{ $posts->withPath(url()->current() . '?category=' . $category) }}
        </div>
    </div>
@endsection
