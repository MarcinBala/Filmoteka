@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <div class=" col-md-6 offset-md-3 d-flex flex-column align-items-center">
            <img style="width:100%;max-height:500px;object-fit:cover" src="/storage/{{$news->image}}">
            <div>Aktualny Obraz</div>
        </div>

        <form action="{{route('news.update', $news->id)}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12">

                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input id="title" name="title" type="text" class="form-control" required autofocus value="{{$news->title}}">
                        @error('title')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Treść</label>
                        <textarea id="content" name="content" class="form-control" rows="15" required>{{$news->content}}</textarea>
                        @error('content')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Nowy Obraz</label>
                        <input id="image" name="image" type="file" class="form-control-file">
                        @error('image')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="btn btn-primary">Edytuj News</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
