@extends('layouts.app')

@section('scripts')
@endsection

@section('styles')
@endsection

@section('content')
    <div class="container">

        <form action="/user/{{$user->username}}/update" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="row align-items-center">
                    <div class="col-sm-2 d-flex justify-content-start justify-content-sm-end">
                        <label for="avatar">Nowy Avatar</label>
                    </div>
                    <div class="col-sm-10 pb-2">
                        <input id="avatar" name="avatar" type="file" class="form-control-file">
                        @error('avatar')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row align-items-center">
                    <div class="col-sm-2 d-flex justify-content-start justify-content-sm-end">
                        <label for="name">Nazwa</label>
                    </div>
                    <div class="col-sm-10 pb-2">
                        <input id="name" name="name" type="text" class="form-control d-inline" value="{{$user->name}}" required>
                        @error('name')
                        <span class="invalid-feedback d-inline" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row align-items-center">
                    <div class="col-sm-2 d-flex justify-content-start justify-content-sm-end">
                        <label for="description">Opis</label>
                    </div>
                    <div class="col-sm-10 pb-2">
                        <textarea id="description" name="description" class="form-control" rows="15">{{$user->description}}</textarea>
                        @error('description')
                        <span class="invalid-feedback d-inline" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row align-items-center">
                    <div class="col-sm-2 d-flex justify-content-start justify-content-sm-end">
                        <label for="description">Prywatność</label>
                    </div>
                    <div class="col-sm-10 pb-2">
                        <div>
                            <input type="checkbox" id="show_films" name="show_films" @if($user->show_films) checked @endif>
                            <label for="scales">Pozwól na wyświetlanie innym swoich ulubionych filmów oraz filmów do obejrzenia</label>
                        </div>
                        <div>
                            <input type="checkbox" id="show_posts" name="show_posts" @if($user->show_posts) checked @endif>
                            <label for="scales">Pozwól na wyświetlanie innym listy swoich wszystkich postów</label>
                        </div>
                    </div>
                </div>
            </div>

            @if( Auth::check() && Auth::user()->user_type=='admin' )
                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="col-sm-2 d-flex justify-content-start justify-content-sm-end">
                            <label for="user_type">Typ Konta</label>
                        </div>
                        <div class="col-sm-10 pb-2">
                            <select id="user_type" name="user_type" required>
                                <option value="user" @if($user->user_type == 'user') selected @endif >Użytkownik</option>
                                <option value="critic" @if($user->user_type == 'critic') selected @endif >Krytyk</option>
                                <option value="admin" @if($user->user_type == 'admin') selected @endif >Administrator</option>
                            </select>
                            @error('user_type')
                            <span class="invalid-feedback d-inline" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            <button type="submit" class="btn btn-primary offset-sm-2">Edytuj</button>

        </form>

    </div>
@endsection
