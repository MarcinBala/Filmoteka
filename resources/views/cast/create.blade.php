@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script>var route = "{{ route('cast.autocomplete') }}";</script>
    <script src="{{ asset('js/bootstrap3-typeahead.js') }}" defer></script>
    <script src="{{ asset('js/cast-autocomplete.js') }}" async></script>
@endsection

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-4">
                <form action="{{route('cast.store', $film->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-12">

                            <div classs="form-group">
                                <label for="name">Imię i Nazwisko</label>
                                <input type="text" id="name" placeholder="Wyszukaj..." class="form-control" />
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id">ID</label>
                        <input id="id" name="id" type="text" class="form-control" readonly required>
                        @error('id')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">Rola w Filmie</label>
                        <input id="role" name="role" type="text" class="form-control" required>
                        @error('role')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="order">Kolejność Wyświetlania (1-100)</label>
                        <input id="order" name="order" type="text" class="form-control" value="100" required>
                        @error('order')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row py-3 pl-3">
                        <button class="btn btn-primary">Dodaj Do Obsady</button>
                    </div>

                </form>
            </div>

            <div class="col-md-8">
                <div class="d-flex justify-content-center border w-100 mt-4" style="width:fit-content">
                    <div class="d-flex">
                        <a href="#" id="actorLink"><img class="actor-img border-right" id="actorPhoto" src="/img/Person.jpg"></a>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center px-5 text-break w-100">
                        <span class="text-center">Imię i Nazwisko: <b id="actorName"></b></span>
                        <span class="text-center">Data Urodzenia: <b id="actorDateOfBirth"></b></span>
                        <span class="text-center">Miejsce Urodzenia: <b id="actorPlaceOfBirth"></b></span>
                        <span class="text-center mt-3" id="actorDescription"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="section text-center p-3 mt-3">
            <a href="/film/{{$film->id}}"><span>Obsada Filmu {{$film->title}}</span></a>
        </div>

        <div class="row">
            @foreach($cast_list as $cast)
                <div class="col-lg-6 p-3 d-flex justify-content-center">
                    <div class="d-flex justify-content-center border text-break" style="width:fit-content">
                        <div class="d-flex">
                            @if(!empty($cast->actor->photo))
                                <img class="cast-img" src="/storage/{{$cast->actor->photo}}" >
                            @else
                                <img class="cast-img" src="/img/Person.jpg" >
                            @endif
                        </div>
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div class="py-3 px-4 d-flex flex-column align-items-center justify-content-center text-break">
                                <div class="text-center">Rola: <b>{{$cast->role}}</b></div>
                                <div class="text-center">Imię i Nazwisko: <b>{{$cast->actor->name}}</b></div>
                                @if(!empty($cast->actor->date_of_birth)) <div class="text-center">Data Urodzenia: {{$cast->actor->date_of_birth->format('Y-m-d')}}</div> @endif
                                @if(!empty($cast->actor->place_of_birth)) <div class="text-center">Miejsce Urodzenia: {{$cast->actor->place_of_birth}}</div> @endif
                            </div>

                            <form method="POST" action="{{ route('cast.update') }}" class="d-flex flex-column align-items-center px-2">
                                @csrf
                                <div class="text-center">
                                    <label class="pr-2">Kolejność</label>
                                    <input name="order" type="number" min="1" max="100" style="width:min-content" value="{{$cast->order}}">
                                </div>
                                <input name="cast_id" type="hidden" value="{{$cast->id}}">
                                <button type="submit" class="btn btn-primary mt-2 py-1" style="width:fit-content">Zmień Kolejność</button>
                            </form>
                            <form method="POST" action="{{ route('cast.destroy') }}" class="my-2">
                                @csrf
                                <input class="btn btn-danger py-1" type="submit" value="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć tego aktora z obsady?');">
                                <input type="hidden" name="cast_id" value="{{$cast->id}}">
                                {{ method_field('DELETE') }}
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
