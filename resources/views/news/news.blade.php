@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/modal.js') }}" async></script>
    <script src="{{ asset('js/news.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ asset('css/news.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modal.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @foreach($news as $data)
                <div class="col-12 col-md-6 col-lg-4 pb-5" onclick="showModal({{$data->id}})">
                    <div class="card card-hover h-100">
                        <div class="overflow-hidden">
                            <img src="/storage/{{ $data->image }}" class="card-img-top card-hover-scale h-200p" alt="{{ $data->title }}">
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <h3 class="card-title max-lines-3">{{$data->title}}</h3>
                            <p class="card-text mt-auto"><small class="text-muted">Dodano: {{ $data->created_at->format('d/m/Y') }}</small></p>
                        </div>
                    </div>
                </div>

                <div class='modal' id="modal{{$data->id}}">
                    <div class='modal-content-custom modal-scrollbar col-11 col-sm-9 col-md-8 col-lg-7 col-xl-5 d-flex flex-column'>
                        <div class="modal-header p-0">
                            <a href="news/{{ $data->id }}"><button class="modal-link px-2 text-muted">Link</button></a>

                            <!-- Likes -->
                            @if ( Auth::user() )
                                @if( Auth::user()->newsLikes()->where('news_id', $data->id)->first() && Auth::user()->newsLikes()->where('news_id', $data->id)->first()->like == 1 )
                                    <img class="ajax-news-like like news-vote mb-1" src="/svg/thumbsup.svg" id="newsLike{{$data->id}}" alt="˄" data-news_id="{{ $data->id }}">
                                @else
                                    <img class="ajax-news-like like news-vote mb-1" src="/svg/thumbsup_blank.svg" id="newsLike{{$data->id}}" alt="˄" data-news_id="{{ $data->id }}">
                                @endif
                            @else
                                <img class="news-vote mb-1" src="/svg/thumbsup_blank.svg" id="newsLike{{$data->id}}" alt="˄" data-news_id="{{ $data->id }}">
                            @endif

                            <div class="px-2 like-counter" id="news-like-counter{{$data->id}}">
                                {{ $data->likes()->count() - $data->dislikes()->count()}}
                            </div>

                            @if ( Auth::user() )
                                @if( Auth::user()->newsLikes()->where('news_id', $data->id)->first() && Auth::user()->newsLikes()->where('news_id', $data->id)->first()->like == 0 )
                                    <img class="ajax-news-like dislike news-vote mr-2" src="/svg/thumbsdown.svg" id="newsDislike{{$data->id}}" alt="˅" data-news_id="{{ $data->id }}">
                                @else
                                    <img class="ajax-news-like dislike news-vote mr-2" src="/svg/thumbsdown_blank.svg" id="newsDislike{{$data->id}}" alt="˅" data-news_id="{{ $data->id }}">
                                @endif
                            @else
                                <img class="news-vote mr-2" src="/svg/thumbsdown_blank.svg" id="newsDislike{{$data->id}}" alt="˅" data-news_id="{{ $data->id }}">
                            @endif
                            <!-- End Likes -->

                            <button type="button" class="close" onclick="hideModal({{$data->id}})">&times;</button>
                        </div>
                        <div class="modal-header">
                            <img src="/storage/{{ $data->image }}" class="modal-image" alt="{{ $data->title }}">
                        </div>
                        <div class="modal-body-custom text-center">
                            <div class="text-break pb-4 font-3">{{ $data->title }}</div>
                            <p class="text-break text-justify">{{ $data->content }}</p>
                        </div>
                        <div class="mt-auto text-center">
                            <small class="text-muted">Dodano: {{ $data->created_at->format('d/m/Y') }}</small>
                            <small class="mx-2">·</small>
                            <small class="text-muted">Autor: {{ $data->user->name }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $news->links() }}
        </div>
    </div>
@endsection
