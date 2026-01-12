@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/film.js') }}" async></script>
@endsection

@section('styles')
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">


        <div class="w-100 d-flex justify-content-center">
            <div class="d-flex align-items-center justify-content-center border" style="width:fit-content">
                <div class="d-flex">
                    @if(!empty($actor->photo))
                        <img class="actor-img border-right" src="/storage/{{$actor->photo}}" >
                    @else
                        <img class="actor-img border-right" src="/img/Person.jpg" >
                    @endif
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center px-5 text-break">
                    <span>Imię i Nazwisko: <b>{{$actor->name}}</b></span>
                    @if(!empty($actor->date_of_birth)) <span>Data Urodzenia: <b>{{$actor->date_of_birth->format('Y-m-d')}}</b></span> @endif
                    @if(!empty($actor->place_of_birth)) <span>Miejsce Urodzenia: <b>{{$actor->place_of_birth}}</b></span> @endif
                    @if(!empty($actor->description)) <span class="mt-3">{{$actor->description}}</span> @endif
                </div>
            </div>
            <div>
                @if( Auth::check() && Auth::user()->user_type=='admin' )
                    <div class="dropdown">
                        <a href="#" id="imageDropdown" data-toggle="dropdown">
                            <img src="/svg/three-dots.svg">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="imageDropdown">
                            <a href="{{ route('actor.edit', $actor->id) }}"><button class="dropdown-item" type="button">Edytuj</button></a>
                            <form method="POST" action="{{ route('actor.destroy', $actor->id) }}">
                                @csrf
                                <input class="dropdown-item" type="submit" value="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć tego Aktora?');">
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="section text-center p-3 mt-3">
            <span>Filmografia</span>
        </div>

        <div class="poster-gallery row justify-content-center">
            @foreach($actor->roles as $role)
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex justify-content-center my-4 align-items-center border">
                        <div class="col-5 overflow-hidden p-0">
                            @if(!empty($role->film->poster))
                                <a href="/film/{{$role->film->id}}"><img class="poster hover h-100" src="/storage/{{$role->film->poster}}" ></a>
                            @else
                                <a href="/film/{{$role->film->id}}"><img class="poster hover h-100" src="/img/Movie_Icon.png"></a>
                            @endif
                        </div>
                        <div class="col-7 text-break p-2">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="text-center mx-2"><b>{{$role->film->title}}</b></div>
                            </div>
                            <div class="max-lines-6 text-center">{{$role->film->description}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@endsection
