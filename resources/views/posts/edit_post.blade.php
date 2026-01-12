@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="container">

        @if(!empty($post->image))
        <div class=" col-md-6 offset-md-3 d-flex flex-column align-items-center">
            <img style="width:100%;max-height:500px;object-fit:contain" src="/storage/{{$post->image}}">
            <div>Twój obraz</div>
        </div>
        @endif

        <form action="/p/{{$post->id}}/update" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12">

                    <div class="form-group">
                        <label for="category">Kategoria</label>
                        <select id="category" name="category" class="form-control-range bg-transparent">
                            <option value="filmy" @if($post->category=='filmy') selected @endif>Filmy</option>
                            <option value="seriale" @if($post->category=='seriale') selected @endif>Seriale</option>
                            <option value="kino" @if($post->category=='kino') selected @endif>Kino</option>
                            <option value="wydarzenia" @if($post->category=='wydarzenia') selected @endif>Wydarzenia</option>
                            <option value="naluzie" @if($post->category=='naluzie') selected @endif>Na luzie</option>
                            <option value="portal" @if($post->category=='portal') selected @endif>Portal</option>
                            <option value="pozostale" @if($post->category=='pozostale') selected @endif>Pozostałe</option>
                        </select>
                        @error('category')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input id="title" name="title" type="text" class="form-control" value="{{$post->title}}">
                        @error('title')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Treść (opcjonalne)</label>
                        <textarea id="content" name="content" class="form-control" rows="5">{{$post->content}}</textarea>
                        @error('content')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">
                            @if(!empty($post->image))
                                <span>Nowy Obraz/Gif (opcjonalne)</span>
                            @else
                                <span>Obraz/Gif (opcjonalne)</span>
                            @endif
                        </label>
                        <input id="image" name="image" type="file" class="form-control-file">
                        @error('image')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    @if(!empty($post->image))
                    <div class="form-group">
                        <div>
                            <label for="delete_image">Usuń Obecny Obraz/Gif</label>
                            <input type="checkbox" id="delete_image" name="delete_image" class="mx-2">
                        </div>
                    </div>
                    @endif

                    <div class="row pt-3 pl-3">
                        <button class="btn btn-primary">Edytuj Post</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
