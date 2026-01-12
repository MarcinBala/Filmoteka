@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/news.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ asset('css/news.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 pb-5 card-center">

            <div class="border py-2 mb-2 d-flex align-items-center">
                <div class="d-flex justify-content-center w-100">
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
                </div>

                @if( Auth::check() && Auth::user()->user_type=='admin' )
                    <div class="dropdown">
                        <a href="#" id="imageDropdown" data-toggle="dropdown">
                            <img src="/svg/three-dots.svg">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="imageDropdown">
                            <a href="/news/{{$data->id}}/edit"><button class="dropdown-item" type="button">Edytuj</button></a>
                            <form method="POST" action="{{ route('news.destroy', $data->id) }}">
                                @csrf
                                <input class="dropdown-item" type="submit" value="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć ten news?');">
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        <div class="card h-100">
            <img src="/storage/{{ $data->image }}" class="card-img-top h-300p" alt="{{ $data->title }}">
            <div class="card-body text-center">
                <h3 class="card-title pb-3">{{ $data->title }}</h3>
                <p class="card-text text-justify">{{ $data->content }}</p>
                <div>
                    <small class="text-muted">Dodano: {{ $data->created_at->format('d/m/Y') }}</small>
                    <small class="mx-2">·</small>
                    <small class="text-muted">Autor: {{ $user->name }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection
