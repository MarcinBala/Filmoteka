@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <form action="{{route('news.store')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
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
                        <label for="content">Treść</label>
                        <textarea id="content" name="content" class="form-control" rows="15" required></textarea>
                        @error('content')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Obraz</label>
                        <input id="image" name="image" type="file" class="form-control-file" required>
                        @error('image')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="btn btn-primary">Dodaj News</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
