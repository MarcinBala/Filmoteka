@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/statistics.js') }}" defer></script>
    <script src="{{ asset('js/slider.js') }}" async></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartUserData = @json($chartUserData);
        const chartCriticData = @json($chartCriticData);
        const chart2Data = @json($chart2Data);
        const chartLabels = @json($chartLabels);
        const chart3Data = @json($chart3Data);
        const chart3Labels = @json($chart3Labels);
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

        <div class="row">
            <div class="d-flex justify-content-around py-2 w-100 border border-bottom-0">
                <div class="d-flex flex-column align-items-center">
                    @if(!empty($film->poster))
                        <a href="/film/{{$film->id}}" class="d-flex"><img class="film-poster" src="/storage/{{$film->poster}}"></a>
                    @else
                        <a href="/film/{{$film->id}}" class="d-flex"><img class="film-poster" src="/img/Movie_Icon.png"></a>
                    @endif
                    <b class="mt-2">{{$film->title}}</b>
                </div>
                <div class="d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center py-3">
                        <div class="film-score
                        @if(is_numeric($criticScore) && ($criticRatings->count() > 5))
                        @if($criticScore < 5) red @elseif($criticScore < 7) yellow @else green @endif
                        @endif ">{{ $criticScore }}</div>
                        @if($criticRatings->count() < 5)<span class="ml-2">Mniej niż 5 ocen <b>recenzentów</b></span>
                        @else<span class="ml-2">{{$criticRatings->count()}} ocen <b>recenzentów</b></span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center py-3">
                        <div class="film-score
                        @if(is_numeric($userScore) && ($userRatings->count() > 5))
                        @if($userScore < 5) red @elseif($userScore < 7) yellow @else green @endif
                        @endif ">{{ $userScore }}</div>
                        @if($userRatings->count() < 5)<span class="ml-2">Mniej niż 5 ocen <b>użytkowników</b></span>
                        @else<span class="ml-2">{{$userRatings->count()}} ocen <b>użytkowników</b></span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center align-items-center py-3">
                        <div class="d-flex justify-content-center px-2"><div class="film-svg-readonly eye px-1"></div><span class="px-1">{{$film->wantToSee->count()}}</span></div>
                        <div class="d-flex justify-content-center px-2"><div class="film-svg-readonly heart px-1"></div><span class="px-1">{{$film->favourites->count()}}</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row border">
            <div class="film-info-container col-md-6">
                <div class="text-break"><span class="film-info pr-2">Długość:</span>@if($film->length>=60){{floor($film->length/60)}} godz. @endif{{$film->length%60}} min.</div>
                <div class="text-break"><span class="film-info pr-2">Gatunek:</span>@foreach($film->genres as $data){{$data->name}}@if(!$loop->last) · @endif @endforeach</div>
                <div class="text-break"><span class="film-info pr-2">Premiera:</span>{{$film->release->format('Y-m-d')}}</div>
                <div class="text-break"><span class="film-info pr-2">Reżyseria:</span>@foreach($film->directors as $data){{$data->name}}@if(!$loop->last) ·@endif @endforeach</div>
                <div class="text-break"><span class="film-info pr-2">Scenarisz:</span>@foreach($film->writers as $data){{$data->name}}@if(!$loop->last) ·@endif @endforeach</div>
                <div class="text-break"><span class="film-info pr-2">Produkcja:</span>@foreach($film->production as $data){{$data->name}}@if(!$loop->last) ·@endif @endforeach</div>
            </div>
            <div class="film-description text-break col-md-6">{{$film->description}}</div>
        </div>

        <div>
            <div class="section text-center mt-5 mb-2 p-1">Średnia Wartość Ocen Filmu {{$film->title}} · <span class="border border-dark px-1">{{number_format($film->reviews->avg('rating'), 1)}}</span></div>
            <canvas class="film-chart" id="chart"></canvas>
        </div>
        <div>
            <div class="section text-center mt-5 p-1">Ilość Ocen Filmu {{$film->title}} · {{$film->reviews->count()}}</div>
            <canvas class="film-chart" id="chart2"></canvas>
        </div>
        <div>
            <div class="section text-center mt-5 p-1">Oceny w Ostatnim Miesiącu · <span class="border border-dark px-1">{{number_format($recentRatings->avg('rating'), 1)}}</span></div>
            <canvas class="film-chart" id="chart3"></canvas>
        </div>

    </div>
@endsection
