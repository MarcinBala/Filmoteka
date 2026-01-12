@extends('layouts.app')

@section('scripts')
    <script>var route = "{{ route('discover.autocomplete') }}";</script>
    <script src="{{ asset('js/bootstrap3-typeahead.js') }}" defer></script>
    <script src="{{ asset('js/discover.js') }}"></script>
@endsection

@section('styles')
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">

        <form action="{{ route('discover.result') }}" method="POST" autocomplete="off">
            @csrf
            <div class="form-group">
                <div class="row align-items-center">
                    <div class="col-sm-2 d-flex justify-content-center justify-content-sm-end">
                        <label for="title"><b class="text-nowrap">Tytuł Filmu</b></label>
                    </div>
                    <div class="col-sm-10 pb-2">
                        <input id="title" name="title" type="text" class="form-control d-inline" required>
                        @error('title')
                        <span class="invalid-feedback d-inline" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center mt-4">
                    <span class="mx-2 text-center"><b>Wyszukaj</b> tytuł lub <b>wybierz</b> z listy film, który Ci się podoba, a następnie</span>
                    <button type="submit" class="btn btn-primary mx-2 text-nowrap">Odkryj Filmy</button>
                </div>

            </div>
        </form>

        @if(Auth::user())
            <div class="section-small text-center p-1">Twoje ulubione filmy</div>

            <div class="poster-gallery row d-flex justify-content-center">
                @foreach(Auth::user()->favourites as $data)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 my-4">
                        <div class="h-100">
                            <div class="overflow-hidden">
                                @if(!empty($data->film->poster))
                                    <img class="poster hover get-title" src="/storage/{{$data->film->poster}}" data-title="{{$data->film->title}}" style="cursor:pointer">
                                @else
                                    <img class="poster hover get-title" src="/img/Movie_Icon.png" data-title="{{$data->film->title}}" style="cursor:pointer">
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
        @else
            <div class="text-center m-5">Zaloguj się, aby zobaczyć swoje ulubione filmy.</div>
        @endif

    </div>
@endsection
