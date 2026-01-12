@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <form action="{{route('film.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12">

                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input id="title" name="title" type="text" class="form-control" required autofocus>
                        @error('title')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="original_title">Oryginalny Tytuł</label>
                        <input id="original_title" name="original_title" type="text" class="form-control" required>
                        @error('original_title')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="release">Data Premiery</label>
                        <input id="release" name="release" type="date" class="form-control" required>
                        @error('release')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Główny Obraz</label>
                        <input id="image" name="image" type="file" class="form-control-file" required>
                        @error('image')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="poster">Plakat (opcjonalne)</label>
                        <input id="poster" name="poster" type="file" class="form-control-file">
                        @error('poster')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="video">Wideo (opcjonalne)</label>
                        <input id="video" name="video" type="file" class="form-control-file">
                        @error('video')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="length">Długość w minutach (opcjonalne)</label>
                        <input id="length" name="length" type="text" class="form-control">
                        @error('length')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Gatunek (opcjonalne)</label>
                        @error('genre')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input name="genre[]" type="text" class="form-control my-1">
                        <input name="genre[]" type="text" class="form-control my-1">
                        <input name="genre[]" type="text" class="form-control my-1">
                        <input name="genre[]" type="text" class="form-control my-1">
                        <input name="genre[]" type="text" class="form-control my-1">
                    </div>

                    <div class="form-group">
                        <label>Reżyseria (opcjonalne)</label>
                        @error('director')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input name="director[]" type="text" class="form-control my-1">
                        <input name="director[]" type="text" class="form-control my-1">
                        <input name="director[]" type="text" class="form-control my-1">
                    </div>

                    <div class="form-group">
                        <label>Scenariusz (opcjonalne)</label>
                        @error('writer')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input name="writer[]" type="text" class="form-control my-1">
                        <input name="writer[]" type="text" class="form-control my-1">
                        <input name="writer[]" type="text" class="form-control my-1">
                    </div>

                    <div class="form-group">
                        <label>Produkcja (opcjonalne)</label>
                        @error('production')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input name="production[]" type="text" class="form-control my-1">
                        <input name="production[]" type="text" class="form-control my-1">
                        <input name="production[]" type="text" class="form-control my-1">
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

                    <div class="pt-3">
                        <button type="submit" class="btn btn-primary">Dodaj Film</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
