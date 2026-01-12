@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/post.js') }}" defer></script>
    <script src="{{ asset('js/comments.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ asset('css/post.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row p-2">
            <div class="col-md-10 col-lg-8 offset-md-1 offset-lg-2">

                <!-- Post -->
                <div class="post" id="post" data-post_id="{{ $post->id }}">
                    <div class="post-header d-flex justify-content-between">
                        <div class="post-header-left d-inline-flex">
                            <div class="post-avatar-container">
                                @if ( !empty($post->user->avatar) )
                                    <a href="/user/{{ $post->user->username }}">
                                        <img src="/storage/{{ $post->user->avatar }}" class="post-avatar" alt="{{ $post->user->username }}">
                                    </a>
                                @else
                                    <a href="/user/{{ $post->user->username }}">
                                        <img src="/img/User_Icon.png" class="post-avatar" alt="{{ $post->user->username }}">
                                    </a>
                                @endif
                            </div>
                            <div class="post-user-container">
                                <a href="/user/{{ $post->user->username }}">
                                    <div class="post-user">{{ \Illuminate\Support\Str::limit($post->user->name, 30, $end='...') }}</div>
                                </a>
                                <div class="post-date text-muted">
                                    <a href="/forum/hot?category={{ $post->category }}">
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
                        <div class="post-header-right d-inline-flex align-items-center">
                            <span class="like-counter mr-1">{{ $post->comments->count() }}</span>
                            <a href="/p/{{ $post->id }}"><img class="post-comment-link p-1 mr-3" src="/svg/comment.svg" alt="Komentarze"></a>

                            @if ( Auth::user() )
                                @if( Auth::user()->postLikes()->where('post_id', $post->id)->first() && Auth::user()->postLikes()->where('post_id', $post->id)->first()->like == 1 )
                                    <img class="ajax-post-like like post-vote mb-1" src="/svg/thumbsup.svg" id="postLike{{$post->id}}" alt="˄" data-post_id="{{ $post->id }}">
                                @else
                                    <img class="ajax-post-like like post-vote mb-1" src="/svg/thumbsup_blank.svg" id="postLike{{$post->id}}" alt="˄" data-post_id="{{ $post->id }}">
                                @endif
                            @else
                                <img class="post-vote mb-1" src="/svg/thumbsup_blank.svg" id="postLike{{$post->id}}" alt="˄" data-post_id="{{ $post->id }}">
                            @endif

                            <div class="px-2 like-counter" id="post-like-counter{{$post->id}}">
                                {{ $post->score }}
                            </div>

                            @if ( Auth::user() )
                                @if( Auth::user()->postLikes()->where('post_id', $post->id)->first() && Auth::user()->postLikes()->where('post_id', $post->id)->first()->like == 0 )
                                    <img class="ajax-post-like dislike post-vote mr-2" src="/svg/thumbsdown.svg" id="postDislike{{$post->id}}" alt="˅" data-post_id="{{ $post->id }}">
                                @else
                                    <img class="ajax-post-like dislike post-vote mr-2" src="/svg/thumbsdown_blank.svg" id="postDislike{{$post->id}}" alt="˅" data-post_id="{{ $post->id }}">
                                @endif
                            @else
                                <img class="post-vote mr-2" src="/svg/thumbsdown_blank.svg" id="postDislike{{$post->id}}" alt="˅" data-post_id="{{ $post->id }}">
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

                    <div class="post-text px-3">
                        <div class="post-title py-2">{{ $post->title }}</div>
                        @if ( !empty($post->content) )
                            <div class="py-2">{{ $post->content }}</div>
                        @endif
                    </div>

                    @if ( !empty($post->image) )
                        <div class="post-media">
                            <img src="/storage/{{ $post->image }}" class="post-img-large" id="postImg{{ $post->id }}" alt="Obraz">
                        </div>
                    @endif
                </div>


                <!-- Comment Form -->
                @if ( Auth::user() )
                    <div class="py-3">
                        <div class="comment-header d-flex flex-start align-items-center">
                            @if( !empty(Auth::user()->avatar) )
                                <img src="/storage/{{ Auth::user()->avatar }}" class="post-avatar comment-avatar-border" alt="{{ Auth::user()->name }}">
                            @else
                                <img src="/img/User_Icon.png" class="post-avatar comment-avatar-border" alt="{{ Auth::user()->name }}">
                            @endif
                            <button class="comment-btn ajax-comment ml-3" id="postCommentBtn" data-post_id="{{ $post->id }}" disabled>Skomentuj</button>
                        </div>
                        <textarea class="comment-textarea" id="postCommentTextarea" rows="3"></textarea>
                    </div>
                @else
                    <div class="py-3">Zaloguj się aby skomentować.</div>
                @endif

                <div class="">
                    <div class="comments">Komentarze</div>
                </div>

                <!-- Comments -->
                <div class="w-100" id="commentSection"></div>

            </div>
        </div>

    </div>
@endsection
