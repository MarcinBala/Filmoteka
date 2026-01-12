@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/slider.js') }}" async></script>
@endsection

@section('styles')
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slider.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">


        <div class="section text-center p-1 mt-3">Filmy</div>
        <div class="poster-gallery d-flex flex-wrap justify-content-center">
            @forelse($films as $data)
                @if($loop->index == 12)
                    @break
                @endif
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center">Brak wyników dla zapytania.</div>
            @endforelse
        </div>

        @if($films->count() > 12)
        <div class="d-flex justify-content-center">
            <a href="/search/films?search={{$search}}"><div class="section-btn mb-2 mt-2">Zobacz Więcej Filmów</div></a>
        </div>
        @endif

        <div class="section text-center p-1 mt-3">Aktorzy</div>
        <div class="poster-gallery d-flex flex-wrap justify-content-center">
            @forelse($actors as $data)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="p-2">
                        <div class="h-100">
                            <div class="overflow-hidden">
                                @if(!empty($data->photo))
                                    <a href="/actor/{{$data->id}}"><img class="poster hover" src="/storage/{{$data->photo}}" ></a>
                                @else
                                    <a href="/actor/{{$data->id}}"><img class="poster hover" src="/img/Person.jpg"></a>
                                @endif
                            </div>
                            <div class="text-break">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <div class="pt-1 text-center"><b>{{$data->name}}</b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center">Brak wyników dla zapytania.</div>
            @endforelse
        </div>

        <div class="section text-center p-1 mt-5">Użytkownicy</div>
        @if($users->count() > 0)
        <div class="d-flex align-items-center py-2">
            <img class="slider-arrow" src="/svg/angle-left.svg" id="sliderLeft" type="button">
            <div class="slider" id="sliderContainer">
            @foreach($users as $user)
            @if($loop->first)
                <div class="slider-item pr-2">
            @elseif($loop->last)
                <div class="slider-item pl-2">
            @else
                <div class="slider-item px-2">
            @endif
            @if(!empty($user->avatar))
                <a href="/user/{{$user->username}}"><img class="slider-square-img" src="/storage/{{$user->avatar}}"></a>
            @else
                <a href="/user/{{$user->username}}"><img class="slider-square-img" src="/img/User_Icon.png"></a>
            @endif
                <div class="slider-wide-text text-break">
                    <div class="slider-item-title">{{$user->name}}</div>
                    <div class="slider-item-caption text-muted small">({{$user->username}})</div>
                </div>
            </div>
            @endforeach
            </div>
            <img class="slider-arrow" src="/svg/angle-right.svg" id="sliderRight" type="button">
        </div>
        @else
            <div class="text-center">Brak wyników dla zapytania.</div>
        @endif
    </div>
@endsection
