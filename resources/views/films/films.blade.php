@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/slider.js') }}" async></script>
    <script src="{{ asset('js/modal.js') }}" async></script>
    <script src="{{ asset('js/news.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/news.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modal.css') }}" rel="stylesheet">
    <style> @import url('https://fonts.googleapis.com/css2?family=Exo:ital,wght@1,900&display=swap'); </style>
    <style> @import url('https://fonts.googleapis.com/css2?family=Teko:wght@700&display=swap'); </style>
@endsection

@section('content')
    <div class="container">
        @if(!empty($featured))
        <a href="/film/{{$featured->id}}">
        <div class="row position-relative d-flex align-items-end">
            <div class="film-top-title-container">
                <div class="film-top-title" data-film_id="{{$featured->id}}">{{$featured->title}}</div>
            </div>
            <img class="film-top-image" src="/storage/{{$featured->image}}">
        </div>
        </a>
        <div class="text-center">
            {{$featured->release->diffForHumans()}} · @if($featured->length>=60){{floor($featured->length/60)}} godz. @endif{{$featured->length%60}} min. ·
            <span class="border border-dark px-1">{{number_format($featured->reviews->avg('rating'), 1)}}</span>
            <div class="d-flex justify-content-center px-2"><div class="film-svg-readonly heart px-1"></div><span class="px-1">{{$featured->favourites->count()}}</span></div>
        </div>
        @endif

        @if(!empty($popularReleases))
        <div class="mt-5">
            <div class="section text-center p-2">Popularne</div>
            <div class="d-flex align-items-center">
                <img class="slider-arrow left" src="/svg/angle-left.svg" id="sliderLeft" type="button">
                <div class="slider" id="sliderContainer">
                    @foreach($popularReleases as $data)
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
        </div>
        @endif


        @if(!empty($awaitedReleases))
            <div class="section text-center p-1 mt-5">Najbardziej Oczekiwane</div>
                <div class="poster-gallery d-flex flex-wrap">
                    @foreach($awaitedReleases as $data)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 my-4">
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
                                                <div class="film-svg-readonly eye px-1"></div>
                                                <span class="px-1">{{$data->wantToSee->count()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        @endif

        <div class="section text-center p-2 mt-4">Newsy</div>
        <div class="row">
            @foreach($news as $data)
                <div class="col-12 col-md-6 col-lg-4 pb-5" onclick="showModal({{$data->id}})">
                    <div class="card card-hover h-100">
                        <div class="overflow-hidden">
                            <img src="/storage/{{ $data->image }}" class="card-img-top card-hover-scale h-200p" alt="{{ $data->title }}">
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <h3 class="card-title max-lines-3">{{$data->title}}</h3>
                            <p class="card-text mt-auto"><small class="text-muted">Dodano: {{ $data->created_at->format('d/m/Y') }}</small></p>
                        </div>
                    </div>
                </div>

                <div class='modal' id="modal{{$data->id}}">
                    <div class='modal-content-custom modal-scrollbar col-11 col-sm-9 col-md-8 col-lg-7 col-xl-5 d-flex flex-column'>
                        <div class="modal-header p-0">
                            <a href="news/{{ $data->id }}"><button class="modal-link px-2 text-muted">Link</button></a>

                            <!-- Likes -->
                            @if ( Auth::user() )
                                @if( Auth::user()->newsLikes()->where('news_id', $data->id)->first() && Auth::user()->newsLikes()->where('news_id', $data->id)->first()->like == 1 )
                                    <img class="ajax-news-like like news-vote mb-1" src="/svg/thumbsup.svg" id="newsLike{{$data->id}}" alt="˄" data-news_id="{{ $data->id }}">
                                @else
                                    <img class="ajax-news-like like news-vote mb-1" src="/svg/thumbsup_blank.svg"id="newsLike{{$data->id}}" alt="˄" data-news_id="{{ $data->id }}">
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

                            <button type="button" class="close" onclick="hideModal({{$data->id}})">&times;</button>
                        </div>
                        <div class="modal-header">
                            <img src="/storage/{{ $data->image }}" class="modal-image" alt="{{ $data->title }}">
                        </div>
                        <div class="modal-body-custom text-center">
                            <div class="text-break pb-4 font-3">{{ $data->title }}</div>
                            <p class="text-break text-justify">{{ $data->content }}</p>
                        </div>
                        <div class="mt-auto text-center"><small class="text-muted">Dodano: {{ $data->created_at->format('d/m/Y') }}</small></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            <a href="/news"><div class="section-btn mb-2">Zobacz Więcej Newsów</div></a>
        </div>

    </div>
@endsection
