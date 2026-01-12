@extends('layouts.app')

@section('scripts')
@endsection

@section('styles')
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row user-profile-container shadow">
            <div class="col-3 col-md-2 my-2">
                <div class="d-flex justify-content-center">
                    <div class="user-profile-avatar-container">
                        @if( !empty($user->avatar) )
                            <img src="/storage/{{ $user->avatar }}" class="img-fluid user-profile-avatar shadow my-2">
                        @else
                            <img src="/img/User_Icon.png" class="img-fluid user-profile-avatar shadow my-2">
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-column align-items-center">
                    @if( (Auth::check() && Auth::user()->id == $user->id) || (Auth::check() && Auth::user()->user_type == 'admin'))
                        <div>
                            <a href="/user/{{$user->username}}/edit_profile"><button class="user-menu-btn my-1">Edytuj</button></a>
                        </div>
                    @endif
                    @if( Auth::check() && Auth::user()->user_type == 'admin')
                        <div>
                            <form method="POST" action="{{ route('user.destroy', $user->id) }}">
                                @csrf
                                <input class="user-menu-red-btn my-1" type="submit" value="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-9 col-md-10">
                <div class="py-2">
                    <div class="d-flex justify-content-start align-items-center">
                        <h2 class="text-break text-nowrap pt-2">{{ $user->name }}</h2>
                        @if($user->user_type == 'admin')
                            <div class="user-type admin">Administrator</div>
                        @elseif($user->user_type == 'critic')
                            <div class="user-type critic">Krytyk</div>
                        @endif
                    </div>
                    <div class="">
                        <div class="mr-4 d-inline-block text-nowrap"><b>Dołączył/a: </b>{{ $user->created_at->format('Y-m-d') }}</div>
                        <div class="mr-4 d-inline-block text-nowrap"><b>Ulubione Filmy: </b>{{$user->favourites->count()}}</div>
                        <div class="mr-4 d-inline-block text-nowrap"><b>Do Obejrzenia: </b>{{$user->wantToSee->count()}}</div>
                        <div class="d-inline-block text-nowrap"><b>Posty: </b>{{$user->posts->count()}}</div>
                    </div>
                    <div class="text-break mt-3">
                        @if( !empty($user->description) )
                            <span>{{ $user->description }}</span>
                        @else
                            <span>Brak opisu</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($user->show_films || (Auth::user() && Auth::user()->id == $user->id))
            <div class="section-small text-center p-1 mt-4">Ulubione filmy</div>
            <div class="poster-gallery row d-flex justify-content-center">
                @foreach($favourites as $data)
                    @if($loop->index > 11)
                        <div class="col-12 text-center mb-2">
                            <a href="/user/{{$user->username}}/favourite_films"><button class="user-menu-btn">Zaobacz Wszystkie Ulubione Filmy</button></a>
                        </div>
                        @break
                    @endif
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

            <div class="section-small text-center p-1 mt-4">Filmy Do Obejrzenia</div>
            <div class="poster-gallery row d-flex justify-content-center">
                @foreach($wantToSee as $data)
                    @if($loop->index > 11)
                        <div class="col-12 text-center">
                            <a href="/user/{{$user->username}}/want_to_see"><button class="user-menu-btn">Zaobacz Wszystkie Filmy Do Obejrzenia</button></a>
                        </div>
                        @break
                    @endif
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
        @endif

        @if($user->show_posts || (Auth::user() && Auth::user()->id == $user->id))
            <div class="text-center mt-5 mb-3">
                <a href="/user/{{$user->username}}/posts"><button class="user-menu-btn">Zaobacz Posty</button></a>
            </div>
        @endif

    </div>
@endsection
