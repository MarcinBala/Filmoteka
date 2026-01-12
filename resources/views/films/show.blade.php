@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/film.js') }}" defer></script>
    <script src="{{ asset('js/slider.js') }}" async></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const reviews = {!! json_encode($recentRatings) !!};
        const chartData = @json($chartData);
        const chartLabels = @json($chartLabels);
    </script>
@endsection

@section('styles')
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slider.css') }}" rel="stylesheet">
    <style> @import url('https://fonts.googleapis.com/css2?family=Exo:ital,wght@1,900&display=swap'); </style>
    <style> @import url('https://fonts.googleapis.com/css2?family=Teko:wght@700&display=swap'); </style>
@endsection

@section('content')
    <div class="container">

        <div class="row position-relative d-flex align-items-end">
            <div class="film-top-title-container">
                <div class="film-top-title text-break" data-film_id="{{$film->id}}">{{$film->title}}</div>
            </div>
            <img class="film-top-image" src="/storage/{{$film->image}}">
            @if( Auth::check() && Auth::user()->user_type=='admin' )
                <div class="dropdown position-absolute" style="top:0;right:0;">
                    <a href="#" id="imageDropdown" data-toggle="dropdown">
                        <img src="/svg/three-dots.svg" class="bg-light" style="border-radius:50%;">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="imageDropdown">
                        <a href="{{ route('cast.create', $film->id) }}"><button class="dropdown-item" type="button">Edytuj Obsadę</button></a>
                        <a href="{{ route('film.edit', $film->id) }}"><button class="dropdown-item" type="button">Edytuj Film</button></a>
                        <form method="POST" action="{{ route('film.destroy') }}">
                            @csrf
                            <input class="dropdown-item" type="submit" value="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć ten film?');">
                            <input type="hidden" name="film_id" value="{{$film->id}}">
                            {{ method_field('DELETE') }}
                        </form>
                    </div>
                </div>
            @endif
        </div>
        <fieldset class="border">
            <legend class="film-top-legend">{{$film->original_title}}</legend>
            <div class="d-flex flex-wrap border-bottom">
                @if($released)
                    <div class="film-score-left-container col-sm-6">
                        <div class="film-score mx-2
                        @if(is_numeric($criticScore) && ($criticRatings->count() > 4))
                        @if($criticScore < 5) red @elseif($criticScore < 7) yellow @else green @endif
                        @endif ">{{ $criticScore }}</div>
                        @if($criticRatings->count() < 5)<span class="mr-2">Mniej niż 5 ocen <b>recenzentów</b></span>
                        @else<span class="mr-2">{{$criticRatings->count()}} ocen <b>recenzentów</b></span>
                        @endif
                    </div>
                    <div class="film-score-right-container col-sm-6">
                        <div class="film-score mx-2
                        @if(is_numeric($userScore) && ($userRatings->count() > 4))
                        @if($userScore < 5) red @elseif($userScore < 7) yellow @else green @endif
                        @endif ">{{ $userScore }}</div>
                        @if($userRatings->count() < 5)<span class="mr-2">Mniej niż 5 ocen <b>użytkowników</b></span>
                        @else<span class="mr-2">{{$userRatings->count()}} ocen <b>użytkowników</b></span>
                        @endif
                    </div>
                @else
                    <div class="text-center w-100 py-3">Premiera filmu odbędzie się <b>{{$film->release->diffForHumans()}}</b>.</div>
                @endif
            </div>
            <div class="row">
                <div class="film-info-container col-md-6">
                    <div class="text-break"><span class="film-info pr-2">Długość:</span>@if(!empty($film->length) && $film->length>=60){{floor($film->length/60)}} godz. @endif{{$film->length%60}} min.</div>
                    <div class="text-break"><span class="film-info pr-2">Gatunek:</span>@foreach($film->genres as $data){{$data->name}}@if(!$loop->last) · @endif @endforeach</div>
                    <div class="text-break"><span class="film-info pr-2">Premiera:</span>{{$film->release->format('Y-m-d')}}</div>
                    <div class="text-break"><span class="film-info pr-2">Reżyseria:</span>@foreach($film->directors as $data){{$data->name}}@if(!$loop->last) ·@endif @endforeach</div>
                    <div class="text-break"><span class="film-info pr-2">Scenarisz:</span>@foreach($film->writers as $data){{$data->name}}@if(!$loop->last) ·@endif @endforeach</div>
                    <div class="text-break"><span class="film-info pr-2">Produkcja:</span>@foreach($film->production as $data){{$data->name}}@if(!$loop->last) ·@endif @endforeach</div>
                </div>
                <div class="film-description text-break col-md-6">{{$film->description}}</div>
            </div>
        </fieldset>


        <div class="d-flex justify-content-center pt-3">
            <div class="film-svg-container border">
                @if(Auth::user())
                <div class="d-flex align-items-center px-3">
                    <div class="px-1" id="wantToSeeCount">{{$film->wantToSee->count()}}</div>
                @if(Auth::user()->wantToSee->where('film_id', $film->id)->first())
                    <div id="svgEyeButton"><div class="film-svg eye" id="svg-eye" data-toggle="tooltip" data-placement="top" title="Już nie chcę obejrzeć"></div></div>
                @else
                    <div id="svgEyeButton"><div class="film-svg eye-blank" id="svg-eye" data-toggle="tooltip" data-placement="top" title="Chcę obejrzeć"></div></div>
                @endif
                </div>
                <div class="d-flex align-items-center px-3">
                    <div class="px-1" id="favouritesCount">{{$film->favourites->count()}}</div>
                    @if(Auth::user()->favourites->where('film_id', $film->id)->first())
                        <div id="svgHeartButton"><div class="film-svg heart" id="svg-heart" data-toggle="tooltip" data-placement="top" title="Usuń z ulubionych"></div></div>
                    @else
                        <div id="svgHeartButton"><div class="film-svg heart-blank" id="svg-heart" data-toggle="tooltip" data-placement="top" title="Dodaj do ulubionych"></div></div>
                    @endif
                </div>
                @else
                    <div class="d-flex align-items-center px-3">
                        <div class="px-1">{{$film->wantToSee->count()}}</div>
                        <div class="film-svg eye-blank" id="svg-eye" data-toggle="tooltip" data-placement="top" title="Zaloguj się, aby dodać film do listy do obejrzenia"></div>
                    </div>
                    <div class="d-flex align-items-center px-3">
                        <div class="px-1">{{$film->favourites->count()}}</div>
                        <div class="film-svg heart-blank" id="svg-heart" data-toggle="tooltip" data-placement="top" title="Zaloguj się, aby dodać film do ulubionych"></div>
                    </div>
                @endif
            </div>
        </div>


        @if(!empty($film->video))
            <div class="section text-center p-1 mt-3">Zobacz Wideo</div>
            <div class="row film-video-container d-flex justify-content-center">
                <video controls class="col-lg-10 w-100 p-0 m-0"><source src="/storage/{{$film->video}}" type="video/mp4"></video>
            </div>
        @endif

        @if(!empty($film->cast))
            <div class="section text-center p-1 mt-5">Obsada filmu {{$film->title}} · {{$film->cast->count()}}</div>
            <div class="d-flex align-items-center">
                <img class="slider-arrow" src="/svg/angle-left.svg" id="sliderLeft" type="button">
                <div class="slider" id="sliderContainer">
                @foreach($film->cast as $data)
                    @if($loop->first)
                        <div class="slider-item pr-2">
                            @elseif($loop->last)
                            <div class="slider-item pl-2">
                            @else
                            <div class="slider-item px-2">
                            @endif
                            @if(!empty($data->actor->photo))
                                <a href="/actor/{{$data->actor->id}}"><img class="slider-img" src="/storage/{{$data->actor->photo}}"></a>
                            @else
                                <a href="/actor/{{$data->actor->id}}"><img class="slider-img" src="/img/Person.jpg"></a>
                            @endif
                            <div class="slider-text text-break">
                                <div class="slider-item-title">{{$data->actor->name}}</div>
                                <div class="slider-item-caption">{{$data->role}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <img class="slider-arrow" src="/svg/angle-right.svg" id="sliderRight" type="button">
            </div>
        @endif

        @if($released)

        @if( Auth::user() && (($user_review && empty($user_review->content)) || !$user_review) )
            @php($user_review = Auth::user()->reviews->where('film_id', $film->id)->first())
            <div class="d-flex flex-wrap">
                <div class="col-sm-6">
                    @if($user_review) <div class="section-small text-center p-1 mt-5" id="rateFilmSection">Twoja Ocena</div>
                    @else <div class="section-small text-center p-1 mt-5" id="rateFilmSection">Oceń Film</div>
                    @endif
                    <div class="film-vote-container">
                        <div class="film-vote-group">
                            <button class="film-vote-btn vote vote-red @if($user_review && $user_review->rating == 0) hover @endif" data-vote="0">0</button>
                            <button class="film-vote-btn vote vote-red @if($user_review && $user_review->rating == 1) hover @endif" data-vote="1">1</button>
                            <button class="film-vote-btn vote vote-red @if($user_review && $user_review->rating == 2) hover @endif" data-vote="2">2</button>
                            <button class="film-vote-btn vote vote-red @if($user_review && $user_review->rating == 3) hover @endif" data-vote="3">3</button>
                        </div>
                        <div class="film-vote-group">
                            <button class="film-vote-btn vote vote-yellow @if($user_review && $user_review->rating == 4) hover @endif" data-vote="4">4</button>
                            <button class="film-vote-btn vote vote-yellow @if($user_review && $user_review->rating == 5) hover @endif" data-vote="5">5</button>
                            <button class="film-vote-btn vote vote-yellow @if($user_review && $user_review->rating == 6) hover @endif" data-vote="6">6</button>
                        </div>
                        <div class="film-vote-group">
                            <button class="film-vote-btn vote vote-green @if($user_review && $user_review->rating == 7) hover @endif" data-vote="7">7</button>
                            <button class="film-vote-btn vote vote-green @if($user_review && $user_review->rating == 8) hover @endif" data-vote="8">8</button>
                            <button class="film-vote-btn vote vote-green @if($user_review && $user_review->rating == 9) hover @endif" data-vote="9">9</button>
                            <button class="film-vote-btn vote vote-green @if($user_review && $user_review->rating == 10) hover @endif" data-vote="10">10</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="section-small text-center p-1 mt-5 mb-2">Napisz recenzję</div>
                    <div class="border px-1 py-2 d-flex justify-content-start w-100">
                        @if ( !empty(Auth::user()->avatar) )
                            <img src="/storage/{{ Auth::user()->avatar }}" class="review-avatar mr-1" alt="{{ Auth::user()->name }}">
                        @else
                            <img src="/img/User_Icon.png" class="review-avatar mr-1" alt="{{ Auth::user()->name }}">
                        @endif
                        <div class="w-100">
                            <a href="/film/{{$film->id}}/review"><input class="film-create-review text-muted d-block w-100 px-2" placeholder="Napisz recenzję..." readonly></a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif( Auth::user() && $user_review && !empty($user_review->content) )
            @php($user_review = Auth::user()->reviews->where('film_id', $film->id)->first())
            <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                <div class="section-small text-center p-1 mt-5">Twoja Recenzja ·
                    <a href="/film/{{$film->id}}/review"><button class="review-edit-btn">Edytuj</button></a> ·
                    <form method="POST" action="{{ route('review.destroy', $user_review->id) }}" class="d-inline-block">
                        @csrf
                        <input type="submit" value="Usuń" class="review-delete-btn" onclick="return confirm('Czy na pewno chcesz usunąć tą recenzję?');">
                        {{ method_field('DELETE') }}
                    </form>
                </div>
                <div class="border my-3">
                    <!-- Review Top -->
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <div class="d-inline-flex align-items-center">
                                @if( !empty(Auth::user()->avatar) )
                                    <img src="/storage/{{ Auth::user()->avatar }}" class="review-avatar mr-2" alt="{{ Auth::user()->name }}">
                                @else
                                    <img src="/img/User_Icon.png" class="review-avatar mr-2" alt="{{ Auth::user()->name }}">
                                @endif
                                <b class="text-break">{{ \Illuminate\Support\Str::limit(Auth::user()->name, 30, $end='...') }}</b>
                            <span class="text-muted text-nowrap pr-1">
                                <span class="px-1">·</span>
                                <small>{{ $user_review->created_at->diffForHumans() }}</small>
                            </span>
                        </div>
                        <div>
                            <button class="film-vote-btn hover ml-2
                                    @if($user_review->rating <= 4) vote-red
                                    @elseif($user_review->rating >= 5 && $user_review->rating <= 7) vote-yellow
                                    @else vote-green
                                    @endif ">{{ $user_review->rating }}</button>
                        </div>
                    </div>
                    <!-- Review Bottom -->
                    <div class="text-break p-2">{{ $user_review->content }}</div>
                </div>
            </div>
        @else
            <div class="text-center p-1 mt-5">Zaloguj się aby ocenić film.</div>
        @endif

        @if($recentRatings)
            <div class="section text-center p-1 mt-5">Oceny w Ostatnim Miesiącu · <span class="border border-dark px-1">{{number_format($recentRatings->avg('rating'), 1)}}</span></div>
            <canvas class="film-chart" id="myChart"></canvas>
        @else
            <div class="section text-center p-1 mt-5">Brak Ocen w Ostatnim Miesiącu</div>
        @endif

        <div class="d-flex justify-content-center">
            <a href="/film/{{$film->id}}/statistics"><div class="section-btn mt-3">Zobacz Więcej Statystyk</div></a>
        </div>

        <!-- Reviews -->
        <div class="d-flex flex-wrap mt-5">
            <div class="col-md-6">
                <div class="section-small text-center pb-3">Recenzje Krytyków<span class="px-1">·</span>{{$criticReviews->count()}}</div>
                @if($criticReviews->count() == 0) <div class="text-center">Brak recenzji krytyków.</div> @endif
                @foreach ($criticReviews as $review)
                    <div class="border my-3">
                        <!-- Review Top -->
                        <div class="d-flex justify-content-between align-items-center p-2">
                            <div class="d-inline-flex align-items-center">
                                <a href="/user/{{ $review->user->username }}">
                                    @if( !empty($review->user->avatar) )
                                        <img src="/storage/{{ $review->user->avatar }}" class="review-avatar mr-2" alt="{{ $review->user->name }}">
                                    @else
                                        <img src="/img/User_Icon.png" class="review-avatar mr-2" alt="{{ $review->user->name }}">
                                    @endif
                                </a>
                                <a href="/user/{{ $review->user->username }}">
                                    <b class="review-user-name text-break">{{ \Illuminate\Support\Str::limit($review->user->name, 30, $end='...') }}</b>
                                </a>
                                <span class="text-muted text-nowrap pr-1">
                                <span class="px-1">·</span><small>{{ $review->created_at->diffForHumans() }}</small>
                            </span>
                            </div>
                            <div>
                                <button class="film-vote-btn hover ml-2
                                    @if($review->rating <= 4) vote-red
                                    @elseif($review->rating >= 5 && $review->rating <= 7) vote-yellow
                                    @else vote-green
                                    @endif ">{{ $review->rating }}</button>
                            </div>
                        </div>
                        <!-- Review Bottom -->
                        <div class="text-break p-2">{{ $review->content }}</div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-6">
                <div class="section-small text-center pb-3">Recenzje Użytkowników<span class="px-1">·</span>{{$userReviews->count()}}</div>
                @if($userReviews->count() == 0) <div class="text-center">Brak recenzji użytkowników.</div> @endif
                @foreach ($userReviews as $review)
                    <div class="border my-3">
                        <!-- Review Top -->
                        <div class="d-flex justify-content-between align-items-center p-2">
                            <div class="d-inline-flex align-items-center">
                                <a href="/user/{{ $review->user->username }}">
                                    @if( !empty($review->user->avatar) )
                                        <img src="/storage/{{ $review->user->avatar }}" class="review-avatar mr-2" alt="{{ $review->user->name }}">
                                    @else
                                        <img src="/img/User_Icon.png" class="review-avatar mr-2" alt="{{ $review->user->name }}">
                                    @endif
                                </a>
                                <a href="/user/{{ $review->user->username }}">
                                    <b class="review-user-name text-break">{{ \Illuminate\Support\Str::limit($review->user->name, 30, $end='...') }}</b>
                                </a>
                                <span class="text-muted text-nowrap pr-1">
                                <span class="px-1">·</span><small>{{ $review->created_at->diffForHumans() }}</small>
                            </span>
                            </div>
                            <div>
                                <button class="film-vote-btn hover ml-2
                                    @if($review->rating <= 4) vote-red
                                    @elseif($review->rating >= 5 && $review->rating <= 7) vote-yellow
                                    @else vote-green
                                    @endif ">{{ $review->rating }}</button>
                            </div>
                        </div>
                        <!-- Review Bottom -->
                        <div class="text-break p-2">{{ $review->content }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        @else
            <div class="text-center p-1 mt-5">Ocenianie tego filmu będzie dostępne <b>po premierze.</b></div>
        @endif

    </div>
@endsection
