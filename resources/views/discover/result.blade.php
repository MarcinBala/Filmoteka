@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/film.js') }}" async></script>
@endsection

@section('styles')
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">

        <div class="section text-center p-1">Użytkownicy, którzy lubią {{$film->title}}, polubili także:</div>

        <div class="poster-gallery row justify-content-center">
            @foreach($result as $data)
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex justify-content-center my-4 align-items-center border">
                        <div class="col-5 overflow-hidden p-0">
                            @if(!empty($data['film']->poster))
                                <a href="/film/{{$data['film']->id}}"><img class="poster hover h-100" src="/storage/{{$data['film']->poster}}" ></a>
                            @else
                                <a href="/film/{{$data['film']->id}}"><img class="poster hover h-100" src="/img/Movie_Icon.png"></a>
                            @endif
                        </div>
                        <div class="col-7 text-break p-2">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="text-center mx-2"><b>{{$data['film']->title}}</b></div>
                                <div class="d-flex justify-content-center mx-2" data-toggle="tooltip" data-placement="top"
                                     title="{{floor($data['count'] / $film->favourites->count() * 100)}}% użytkowników lubiących {{$film->title}}">
                                    <div class="film-svg-readonly heart px-1"></div>
                                    <span class="px-1 text-nowrap">{{$data['count']}}</span>
                                </div>
                            </div>
                            <div class="max-lines-6 text-center">{{$data['film']->description}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
