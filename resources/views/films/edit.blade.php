@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/film.css') }}" rel="stylesheet">
    <style> @import url('https://fonts.googleapis.com/css2?family=Exo:ital,wght@1,900&display=swap'); </style>
    <style> @import url('https://fonts.googleapis.com/css2?family=Teko:wght@700&display=swap'); </style>
@endsection

@section('content')
    <div class="container">

        <div class="row position-relative d-flex align-items-end">
            <div class="film-top-title-container">
                <div class="film-top-title" data-film_id="{{$film->id}}">{{$film->title}}</div>
            </div>
            <img class="film-top-image" src="/storage/{{$film->image}}">
        </div>
        <fieldset class="border">
            <legend class="film-top-legend">{{$film->original_title}}</legend>
            <div class="row">
                <div class="film-info-container col-md-6 d-flex flex-wrap">
                    @if(!empty($film->poster))
                    <div class="col-lg-4">
                        <img class="poster" src="/storage/{{$film->poster}}">
                    </div>
                    @endif
                    <div class="col-md-8 mt-2">
                        <div class="text-break"><span class="film-info pr-2">Długość:</span>@if(!empty($film->length) && $film->length>=60){{floor($film->length/60)}} godz. @endif{{$film->length%60}} min.</div>
                        <div class="text-break"><span class="film-info pr-2">Gatunek:</span>@foreach($film->genres as $data){{$data->name}}@if(!$loop->last) · @endif @endforeach</div>
                        <div class="text-break"><span class="film-info pr-2">Premiera:</span>{{$film->release->format('Y-m-d')}}</div>
                        <div class="text-break"><span class="film-info pr-2">Reżyseria:</span>@foreach($film->directors as $data){{$data->name}}@if(!$loop->last) ·@endif @endforeach</div>
                        <div class="text-break"><span class="film-info pr-2">Scenarisz:</span>@foreach($film->writers as $data){{$data->name}}@if(!$loop->last) ·@endif @endforeach</div>
                        <div class="text-break"><span class="film-info pr-2">Produkcja:</span>@foreach($film->production as $data){{$data->name}}@if(!$loop->last) ·@endif @endforeach</div>
                    </div>
                </div>
                <div class="film-description text-break col-md-6">{{$film->description}}</div>
            </div>
        </fieldset>

        @if(!empty($film->video))
            <div class="row film-video-container d-flex justify-content-center my-4">
                <video controls class="col-lg-10 w-100 p-0 m-0"><source src="/storage/{{$film->video}}" type="video/mp4"></video>
            </div>
        @endif

        <form action="{{route('film.update')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12">

                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input id="title" name="title" type="text" class="form-control" required value="{{$film->title}}" autofocus>
                        @error('title')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="original_title">Oryginalny Tytuł</label>
                        <input id="original_title" name="original_title" type="text" class="form-control" required value="{{$film->original_title}}">
                        @error('original_title')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="release">Data Premiery</label>
                        <input id="release" name="release" type="date" class="form-control" required @if(!empty($film->release)) value="{{$film->release->format('Y-m-d')}}" @endif>
                        @error('release')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Główny Obraz</label>
                        <input id="image" name="image" type="file" class="form-control-file">
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
                        <input id="length" name="length" type="text" class="form-control" @if(!empty($film->length)) value="{{$film->length}}" @endif >
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
                        @foreach ($film->genres as $genre)
                            <input name="genre[]" type="text" class="form-control my-1" value="{{$genre->name}}">
                        @endforeach
                        @for ($i=0; $i<(5 - $film->genres->count()); $i++)
                            <input name="genre[]" type="text" class="form-control my-1">
                        @endfor
                    </div>

                    <div class="form-group">
                        <label>Reżyseria (opcjonalne)</label>
                        @error('director')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @foreach ($film->directors as $director)
                            <input name="director[]" type="text" class="form-control my-1" value="{{$director->name}}">
                        @endforeach
                        @for ($i=0; $i<(3 - $film->directors->count()); $i++)
                            <input name="director[]" type="text" class="form-control my-1">
                        @endfor
                    </div>

                    <div class="form-group">
                        <label>Scenariusz (opcjonalne)</label>
                        @error('writer')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @foreach ($film->writers as $writer)
                            <input name="writer[]" type="text" class="form-control my-1" value="{{$writer->name}}">
                        @endforeach
                        @for ($i=0; $i<(3 - $film->writers->count()); $i++)
                            <input name="writer[]" type="text" class="form-control my-1">
                        @endfor
                    </div>

                    <div class="form-group">
                        <label>Produkcja (opcjonalne)</label>
                        @error('production')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @foreach ($film->production as $production)
                            <input name="production[]" type="text" class="form-control my-1" value="{{$production->name}}">
                        @endforeach
                        @for ($i=0; $i<(3 - $film->production->count()); $i++)
                            <input name="production[]" type="text" class="form-control my-1">
                        @endfor
                    </div>

                    <div class="form-group">
                        <label for="description">Opis (opcjonalne)</label>
                        <textarea id="description" name="description" class="form-control" rows="5">{{$film->description}}</textarea>
                        @error('description')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <input type="hidden" name="film_id" value="{{$film->id}}">

                    <div class="pt-3">
                        <button type="submit" class="btn btn-primary">Edytuj Film</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
