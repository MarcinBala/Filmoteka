@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/modal.js') }}" async></script>
    <script src="{{ asset('js/news.js') }}" defer></script>
    <script src="{{ asset('js/slider.js') }}" defer></script>
    <script src="{{ asset('js/post.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/news.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modal.css') }}" rel="stylesheet">
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/post.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center">

            <!-- News -->
            @foreach ( $news as $data )
                <div class='modal' id="modal{{ $data->id }}">
                    <div class='modal-content-custom modal-scrollbar col-11 col-sm-9 col-md-8 col-lg-7 col-xl-5 d-flex flex-column'>
                        <div class="modal-header p-0">
                            <a href="news/{{ $data->id }}"><button class="modal-link px-2 text-muted">Link</button></a>
                            <!-- Likes -->
                            @if ( Auth::user() )
                                @if( Auth::user()->newsLikes()->where('news_id', $data->id)->first() && Auth::user()->newsLikes()->where('news_id', $data->id)->first()->like == 1 )
                                    <img class="ajax-news-like like news-vote mb-1" src="/svg/thumbsup.svg" id="newsLike{{$data->id}}" alt="˄" data-news_id="{{ $data->id }}">
                                @else
                                    <img class="ajax-news-like like news-vote mb-1" src="/svg/thumbsup_blank.svg" id="newsLike{{$data->id}}" alt="˄" data-news_id="{{ $data->id }}">
                                @endif
                            @else
                                <img class="news-vote mb-1" src="/svg/thumbsup_blank.svg" id="newsLike{{$data->id}}" alt="˄" data-news_id="{{ $data->id }}">
                            @endif

                            <div class="px-2 like-counter" id="news-like-counter{{$data->id}}">
                                {{ $data->likes()->count() - $data->dislikes()->count()}}
                            </div>

                            @if ( Auth::user() )
                                @if( Auth::user()->newsLikes()->where('news_id', $data->id)->first() && Auth::user()->newsLikes()->where('news_id', $data->id)->first()->like == 0 )
                                    <img class="ajax-news-like dislike news-vote mr-2" src="/svg/thumbsdown.svg" id="newsDislike{{$data->id}}" alt="˅" data-news_id="{{ $data->id }}">
                                @else
                                    <img class="ajax-news-like dislike news-vote mr-2" src="/svg/thumbsdown_blank.svg" id="newsDislike{{$data->id}}" alt="˅" data-news_id="{{ $data->id }}">
                                @endif
                            @else
                                <img class="news-vote mr-2" src="/svg/thumbsdown_blank.svg" id="newsDislike{{$data->id}}" alt="˅" data-news_id="{{ $data->id }}">
                            @endif
                            <!-- End Likes -->
                            <button class="close" onclick="hideModal({{ $data->id }})">&times;</button>
                        </div>
                        <div class="modal-header">
                            <img src="/storage/{{ $data->image }}" class="modal-image" alt="{{ $data->title }}">
                        </div>
                        <div class="modal-body-custom text-center d-flex flex-column">
                            <div class="text-break pb-4 font-3">{{ $data->title }}</div>
                            <p class="text-break text-justify">{{ $data->content }}</p>
                        </div>
                        <div class="mt-auto text-center">
                            <small class="text-muted">Dodano: {{ $data->created_at->format('d/m/Y') }}</small>
                            <small class="mx-2">·</small>
                            <small class="text-muted">Autor: {{ $data->user->name }}</small>
                        </div>
                    </div>
                </div>
            @endforeach

            @if( $news->first() )
                @if( count($news) == 1 )
                <div class="col-md-12 p-1" onclick="showModal({{ $news->first()->id }})">
                @else
                <div class="col-md-6 p-1" onclick="showModal({{ $news->first()->id }})">
                @endif
                    <div class="card card-hover text-white">
                        <img src="/storage/{{ $news->first()->image }}" class="card-img" style="height:410px;" alt="{{ $news->first()->title }}">
                        <div class="card-img-overlay d-flex flex-column py-3 px-4">
                            <h5 class="card-text mt-auto font-3 max-lines-2">{{$news->first()->title}}</h5>
                        </div>
                    </div>
                </div>
            @endif

            @if ( count($news) > 1 )
                <div class="col-md-6">
                    <div class="row">
                        @foreach( $news as $data )
                            @if ( !$loop->first )
                                @if( $loop->index < 3 )
                                    @if( count($news) == 2 || count($news) == 3 )
                                    <div class="col-md-12 p-1" onclick="showModal({{ $data->id }})">
                                    @else
                                    <div class="col-md-12 col-lg-6 p-1" onclick="showModal({{ $data->id }})">
                                    @endif
                                        <div class="card card-hover text-white">
                                            @if( count($news) == 2 )
                                                <img src="/storage/{{ $data->image }}" class="card-img" style="height:410px;" alt="{{ $data->title }}">
                                                <div class="card-img-overlay d-flex flex-column py-3 px-4">
                                                    <h5 class="card-text mt-auto font-3 max-lines-2">{{$data->title}}</h5>
                                                </div>
                                            @else
                                                <img src="/storage/{{ $data->image }}" class="card-img" style="height:200px;" alt="{{ $data->title }}">
                                                <div class="card-img-overlay d-flex flex-column py-3 px-4">
                                                    <h5 class="card-text mt-auto font-2 max-lines-2">{{$data->title}}</h5>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    @if( count($news) == 4 )
                                    <div class="col-lg-12 d-none d-lg-block p-1" onclick="showModal({{ $data->id }})">
                                    @else
                                    <div class="col-lg-6 d-none d-lg-block p-1" onclick="showModal({{ $data->id }})">
                                    @endif
                                        <div class="card card-hover text-white">
                                            <img src="/storage/{{ $data->image }}" class="card-img" style="height:200px;" alt="{{ $data->title }}">
                                            <div class="card-img-overlay d-flex flex-column py-3 px-4">
                                                <h5 class="card-text mt-auto font-2 max-lines-2">{{$data->title}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

        </div>


        <div class="home-section">
            <div class="home-section-name">Nowości</div>
        </div>
        <div class="poster-gallery d-flex flex-wrap justify-content-center">
            @foreach($newFilms as $data)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="p-2">
                        <div class="h-100">
                            <div class="overflow-hidden">
                                @if(!empty($data->poster))
                                    <a href="/film/{{$data->id}}"><img class="poster hover" src="/storage/{{$data->poster}}" ></a>
                                @else
                                    <a href="/film/{{$data->id}}"><img class="poster hover" src="/img/Movie_Icon.png"></a>
                                @endif
                            </div>
                            <div class="text-break">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <div class="pt-1 text-center"><b>{{$data->title}}</b></div>
                                    <div class="d-flex align-items-center">
                                        <div class="film-svg-readonly heart px-1"></div>
                                        <span class="px-1">{{$data->favourites->count()}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="home-section">
            <div class="home-section-name">Najlepsze</div>
        </div>
        <div class="d-flex align-items-center">
            <img class="slider-arrow left" src="/svg/angle-left.svg" id="sliderLeft" type="button">
            <div class="slider" id="sliderContainer">
            @foreach($bestFilms as $data)
            @if($loop->first)
                <div class="slider-item pr-2">
            @elseif($loop->last)
                <div class="slider-item pl-2">
            @else
                <div class="slider-item px-2">
            @endif
                    <div class="poster-container">
                    @if(!empty($data->poster))
                        <a href="/film/{{$data->id}}"><img class="slider-img" src="/storage/{{$data->poster}}" ></a>
                    @else
                        <a href="/film/{{$data->id}}"><img class="slider-img" src="/img/Movie_Icon.png"></a>
                    @endif
                    </div>
                    <div class="slider-text text-break">
                        <div class="slider-item-title">{{$data->title}}</div>
                    </div>
                </div>
            @endforeach
            </div>
            <img class="slider-arrow right" src="/svg/angle-right.svg" id="sliderRight" type="button">
        </div>

        <div class="home-section">
            <div class="home-section-name">Forum</div>
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

        <div class="d-flex justify-content-center">
            <a href="/forum"><div class="section-btn mb-2">Zobacz Więcej Postów</div></a>
        </div>

    </div>
@endsection
