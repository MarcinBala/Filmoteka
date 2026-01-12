@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/film.js') }}" async></script>
@endsection

@section('styles')
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
    <style> @import url('https://fonts.googleapis.com/css2?family=Exo:ital,wght@1,900&display=swap'); </style>
@endsection

@section('content')

    <div class="d-flex justify-content-center mb-4">
        <div class="releases-menu border">
            <a href="/releases/1"><button class="releases-btn @if($month==1) hover @endif">{{ucfirst(\Carbon\Carbon::now()->monthName)}}</button></a>
            <a href="/releases/2"><button class="releases-btn @if($month==2) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(1)->monthName)}}</button></a>
            <a href="/releases/3"><button class="releases-btn @if($month==3) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(2)->monthName)}}</button></a>
            <a href="/releases/4"><button class="releases-btn @if($month==4) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(3)->monthName)}}</button></a>
            <a href="/releases/5"><button class="releases-btn @if($month==5) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(4)->monthName)}}</button></a>
            <a href="/releases/6"><button class="releases-btn @if($month==6) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(5)->monthName)}}</button></a>
            <a href="/releases/7"><button class="releases-btn @if($month==7) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(6)->monthName)}}</button></a>
            <a href="/releases/8"><button class="releases-btn @if($month==8) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(7)->monthName)}}</button></a>
            <a href="/releases/9"><button class="releases-btn @if($month==9) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(8)->monthName)}}</button></a>
            <a href="/releases/10"><button class="releases-btn @if($month==10) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(9)->monthName)}}</button></a>
            <a href="/releases/11"><button class="releases-btn @if($month==11) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(10)->monthName)}}</button></a>
            <a href="/releases/12"><button class="releases-btn @if($month==12) hover @endif">{{ucfirst(\Carbon\Carbon::now()->startOfMonth()->addMonths(11)->monthName)}}</button></a>
        </div>
    </div>

    <div class="container">

        <div class="row justify-content-center">
            @foreach($films as $film)
                <div class="col-md-8 d-flex flex-wrap border p-0 my-3">
                    <div class="col-4 col-sm-3 col-lg-2 p-0">
                        @if(!empty($film->poster))
                            <a href="/film/{{$film->id}}"><img class="poster" src="/storage/{{$film->poster}}" alt="{{$film->title}}"></a>
                        @else
                            <a href="/film/{{$film->id}}"><img class="poster" src="/img/Movie_Icon.png" alt="{{$film->title}}"></a>
                        @endif
                    </div>
                    <div class="col-8 col-sm-9 col-lg-10 p-0 d-flex flex-column justify-content-between">
                        <div class="p-2">
                            <div class="releases-film-title">{{$film->title}}</div>
                            @if($film->release < \Carbon\Carbon::now())
                                @if($film->reviews->first())
                                <div><span class="border border-dark px-1 mr-1 text-break">{{number_format($film->reviews->avg('rating'), 1)}}</span>na podstawie {{$film->reviews->count()}} ocen</div>
                                @else
                                <div><span class="border border-dark px-1 mr-1 text-break">-</span>Brak ocen</div>
                                @endif
                            @else
                                <div class="d-flex justify-content-start"><div class="film-svg-readonly eye px-1"></div><span class="px-1">{{$film->wantToSee->count()}} osób chce zobaczyć</span></div>
                            @endif
                        </div>
                        <div class="p-2">
                            @if($film->release < \Carbon\Carbon::now())
                                <div class="text-break"><span class="film-info pr-2">Premiera:</span>{{$film->release->diffForHumans()}}</div>
                            @else
                                <div class="text-break"><span class="film-info pr-2">Premiera:</span>{{$film->release->format('d-m-Y')}}</div>
                            @endif
                            <div class="text-break"><span class="max-lines-2 pr-2">{{$film->description}}</span></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
