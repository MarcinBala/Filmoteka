@extends('layouts.app')

@section('scripts')
@endsection

@section('styles')
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="section text-center p-1">Ulubione filmy {{$user->name}}</div>
        <div class="poster-gallery row d-flex justify-content-center">
            @foreach($films as $data)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 my-4">
                    <div class="p-2 h-100">
                        <div>
                            @if(!empty($data->film->poster))
                                <a href="/film/{{$data->film->id}}"><img class="poster" src="/storage/{{$data->film->poster}}" data-title="{{$data->film->title}}"></a>
                            @else
                                <a href="/film/{{$data->film->id}}"><img class="poster" src="/img/Movie_Icon.png" data-title="{{$data->film->title}}"></a>
                            @endif
                        </div>
                        <div class="text-break text-center">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <div class="pt-1"><b>{{$data->film->title}}</b></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
