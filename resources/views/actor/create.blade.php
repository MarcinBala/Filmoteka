@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <form action="{{route('actor.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12">

                    <div class="form-group">
                        <label for="name">Imię i Nazwisko</label>
                        <input id="name" name="name" type="text" class="form-control" required>
                        @error('name')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Opis (opcjonalne)</label>
                        <textarea id="description" name="description" class="form-control" rows="5"></textarea>
                        @error('description')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="place_of_birth">Miejsce Urodzenia (opcjonalne)</label>
                        <input id="place_of_birth" name="place_of_birth" type="text" class="form-control">
                        @error('place_of_birth')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Data Urodzenia (opcjonalne)</label>
                        <input id="date_of_birth" name="date_of_birth" type="date" class="form-control">
                        @error('date_of_birth')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="photo">Zdjęcie (opcjonalne)</label>
                        <input id="photo" name="photo" type="file" class="form-control-file">
                        @error('photo')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row pt-3 pl-3">
                        <button class="btn btn-primary">Dodaj Aktora</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
