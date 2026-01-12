@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <form action="/p" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12">

                    <div class="form-group">
                        <label for="category">Kategoria</label>
                        <select id="category" name="category" class="form-control-range bg-transparent" required>
                            <option value="filmy">Filmy</option>
                            <option value="seriale">Seriale</option>
                            <option value="kino">Kino</option>
                            <option value="wydarzenia">Wydarzenia</option>
                            <option value="naluzie">Na luzie</option>
                            <option value="portal">Portal</option>
                            <option value="pozostale">Pozostałe</option>
                        </select>
                        @error('category')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input id="title" name="title" type="text" class="form-control" required>
                        @error('title')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Treść (opcjonalne)</label>
                        <textarea id="content" name="content" class="form-control" rows="5"></textarea>
                        @error('content')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Obraz/Gif (opcjonalne)</label>
                        <input id="image" name="image" type="file" class="form-control-file">
                        @error('image')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row pt-3 pl-3">
                        <button class="btn btn-primary">Dodaj Post</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
