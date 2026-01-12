@extends('layouts.app')

@section('scripts')
@endsection

@section('styles')
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">


        <div class="section text-center p-1 mt-3">Filmy</div>
        <div class="poster-gallery d-flex flex-wrap justify-content-center">
            @forelse($films as $data)
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

        <!-- Pages -->
        <div class="d-flex justify-content-center">
            {{ $films->appends(['search' => request()->query('search')])->links() }}
        </div>

    </div>
@endsection
