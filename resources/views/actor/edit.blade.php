@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="container">

        @if(!empty($actor->photo))
            <div class=" col-md-6 offset-md-3 d-flex flex-column align-items-center">
                <img style="width:100%;max-height:500px;object-fit:contain" src="/storage/{{$actor->photo}}">
                <div>Zdjęcie Aktora</div>
            </div>
        @endif

        <form action="{{route('actor.update', $actor->id)}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12">

                    <div class="form-group">
                        <label for="name">Imię i Nazwisko</label>
                        <input id="name" name="name" type="text" class="form-control" value="{{$actor->name}}" required>
                        @error('name')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Opis (opcjonalne)</label>
                        <textarea id="description" name="description" class="form-control" rows="5">{{$actor->description}}</textarea>
                        @error('description')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="place_of_birth">Miejsce Urodzenia (opcjonalne)</label>
                        <input id="place_of_birth" name="place_of_birth" type="text" class="form-control" value="{{$actor->place_of_birth}}">
                        @error('place_of_birth')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Data Urodzenia (opcjonalne)</label>
                        <input id="date_of_birth" name="date_of_birth" type="date" class="form-control" @if(!empty($actor->date_of_birth)) value="{{$actor->date_of_birth->format('Y-m-d')}}" @endif>
                        @error('date_of_birth')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="photo">
                            @if(!empty($actor->photo))
                                <span>Nowe Zdjęcie (opcjonalne)</span>
                            @else
                                <span>Zdjęcie (opcjonalne)</span>
                            @endif
                        </label>
                        <input id="photo" name="photo" type="file" class="form-control-file">
                        @error('photo')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    @if(!empty($actor->photo))
                        <div class="form-group">
                            <div>
                                <label for="delete_photo">Usuń Obecne Zdjęcie</label>
                                <input type="checkbox" id="delete_photo" name="delete_photo" class="mx-2">
                            </div>
                        </div>
                    @endif

                    <div class="row pt-3 pl-3">
                        <button class="btn btn-primary">Edytuj Aktora</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
