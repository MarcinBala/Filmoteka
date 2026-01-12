@if( $c && empty($c->reply_to_id) )
<div class="row py-3">
    <div class="col-12">

        <div class="w-100">
            <!-- User -->
            <div class="d-flex align-items-top justify-content-between">
                <div class="d-flex align-items-center">
                    @if( !empty($c->user->avatar) )
                        <img src="/storage/{{ $c->user->avatar }}" class="comment-avatar" alt="{{ $c->user->name }}">
                    @else
                        <img src="/img/User_Icon.png" class="comment-avatar" alt="{{ $c->user->username }}">
                    @endif
                    <div class="ml-1">
                        <a href="/user/{{ $c->user->username }}">
                            <span class="comment-user-name">{{ \Illuminate\Support\Str::limit($c->user->name, 30, $end='...') }}</span>
                        </a>
                        <span class="comment-time text-muted">· {{ $c->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @if( Auth::user() && ( Auth::id()==$c->user->id || Auth::user()->user_type=='admin') )
                    <div class="dropdown">
                        <a href="#" id="imageDropdown" data-toggle="dropdown">
                            <img src="/svg/three-dots.svg">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="imageDropdown">
                            <button class="comment-edit-dropdown dropdown-item" type="button" data-comment_id="{{ $c->id }}">Edytuj</button>
                            <button class="comment-delete-dropdown dropdown-item" type="button" data-comment_id="{{ $c->id }}">Usuń</button>
                        </div>
                    </div>
                @endif
            </div>
            <!-- Content -->
            <div class="comment-text" data-comment_id="{{ $c->id }}">{{ $c->content }}</div>
            <div class="content-toggle text-muted" data-comment_id="{{ $c->id }}">Pokaż więcej</div>
            <div class="comment-edit" data-comment_id="{{ $c->id }}">
                <textarea class="comment-edit-textarea" rows="3" data-comment_id="{{$c->id}}">{{$c->content}}</textarea>
                <div class="d-flex justify-content-end">
                    <button class="comment-edit-btn ajax-edit-comment ml-3" data-comment_id="{{ $c->id }}">Edytuj</button>
                    <button class="comment-edit-cancel-btn" data-comment_id="{{ $c->id }}">Anuluj</button>
                </div>
            </div>

            <!-- Likes -->
            <div class="pt-2 d-inline-flex align-items-center">
                @if ( Auth::user() )
                    @if( Auth::user()->commentLikes()->where('comment_id', $c->id)->first() && Auth::user()->commentLikes()->where('comment_id', $c->id)->first()->like == 1 )
                        <img class="ajax-comment-like like post-vote mb-1" src="/svg/thumbsup.svg" id="commentLike{{$c->id}}" alt="˄" data-comment_id="{{ $c->id }}">
                    @else
                        <img class="ajax-comment-like like post-vote mb-1" src="/svg/thumbsup_blank.svg" id="commentLike{{$c->id}}" alt="˄" data-comment_id="{{ $c->id }}">
                    @endif
                @else
                    <img class="post-vote mb-1" src="/svg/thumbsup_blank.svg" id="commentLike{{$c->id}}" alt="˄" data-comment_id="{{ $c->id }}">
                @endif

                <div class="px-2 like-counter" id="comment-like-counter{{$c->id}}">
                    {{ $c->score }}
                </div>

                @if ( Auth::user() )
                    @if( Auth::user()->commentLikes()->where('comment_id', $c->id)->first() && Auth::user()->commentLikes()->where('comment_id', $c->id)->first()->like == 0 )
                        <img class="ajax-comment-like dislike post-vote mr-2" src="/svg/thumbsdown.svg" id="commentDislike{{$c->id}}" alt="˅" data-comment_id="{{ $c->id }}">
                    @else
                        <img class="ajax-comment-like dislike post-vote mr-2" src="/svg/thumbsdown_blank.svg" id="commentDislike{{$c->id}}" alt="˅" data-comment_id="{{ $c->id }}">
                    @endif
                @else
                    <img class="post-vote mr-2" src="/svg/thumbsdown_blank.svg" id="commentDislike{{$c->id}}" alt="˅" data-comment_id="{{ $c->id }}">
                @endif

                <button class="comment-reply-btn" data-comment_id="{{ $c->id }}">Odpowiedz</button>

                <!-- Show Comment Replies -->
                    @if( $c->replies->count() > 0 )
                        <button class="comment-show-replies-btn ml-1" data-comment_id="{{ $c->id }}" data-count="{{ $c->replies->count() }}">
                            @if( $c->replies->count() == 1 )
                                Pokaż 1 odpowiedź
                            @else
                                Pokaż {{ $c->replies->count() }} odpowiedzi
                            @endif
                        </button>
                    @endif
            </div>

            <!-- Reply -->
            <div class="col-12 comment-reply" data-comment_id="{{ $c->id }}">
                @if ( Auth::user() )
                    <div class="row p-2 py-3">
                        <div class="comment-header d-flex flex-start align-items-center">
                            @if( !empty(Auth::user()->avatar) )
                                <img src="/storage/{{ Auth::user()->avatar }}" class="comment-avatar comment-avatar-border" alt="{{ Auth::user()->name }}">
                            @else
                                <img src="/img/User_Icon.png" class="comment-avatar comment-avatar-border" alt="{{ Auth::user()->name }}">
                            @endif
                            <button class="comment-btn ajax-comment ml-3" data-post_id="{{ $c->post->id }}" data-comment_id="{{ $c->id }}" data-reply_to_id="{{ $c->id }}" disabled>Odpowiedz</button>
                            <button class="comment-cancel-btn" data-comment_id="{{ $c->id }}">Anuluj</button>
                        </div>
                        <textarea class="comment-textarea" rows="3" data-comment_id="{{ $c->id }}"></textarea>
                    </div>
                @else
                    Zaloguj się aby skomentować.
                @endif
            </div>


            <!------ Replies ------>
            <div class="comment-replies ml-3" data-comment_id="{{ $c->id }}">
                @foreach ( $c->replies as $r )
                    <div class="col-12 pl-2 pr-0">
                        <div class="w-100 my-2">
                            <!-- User -->
                            <div class="d-flex align-items-top justify-content-between">
                                <div class="d-flex align-items-center">
                                    @if( !empty($c->user->avatar) )
                                        <img src="/storage/{{ $c->user->avatar }}" class="comment-avatar-small" alt="{{ $c->user->username }}">
                                    @else
                                        <img src="/img/User_Icon.png" class="comment-avatar-small" alt="{{ $c->user->username }}">
                                    @endif

                                    <div class="ml-1">
                                        <a href="/user/{{ $r->user->username }}">
                                            <span class="comment-user-name">{{ \Illuminate\Support\Str::limit($r->user->name, 30, $end='...') }}</span>
                                        </a>
                                        <span class="comment-time text-muted">· {{ $r->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                @if( Auth::user() && ( Auth::id()==$r->user->id || Auth::user()->user_type=='admin') )
                                    <div class="dropdown">
                                        <a href="#" id="imageDropdown" data-toggle="dropdown">
                                            <img src="/svg/three-dots.svg">
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="imageDropdown">
                                            <button class="comment-edit-dropdown dropdown-item" type="button" data-comment_id="{{ $r->id }}">Edytuj</button>
                                            <button class="comment-delete-dropdown dropdown-item" type="button" data-comment_id="{{ $r->id }}" data-reply_to_id="{{ $c->id }}">Usuń</button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="comment-text w-100" data-comment_id="{{ $r->id }}">{{ $r->content }}</div>
                            <div class="content-toggle text-muted" data-comment_id="{{ $r->id }}">Pokaż więcej</div>
                            <div class="comment-edit" data-comment_id="{{ $r->id }}">
                                <textarea class="comment-edit-textarea" rows="3" data-comment_id="{{$r->id}}">{{$r->content}}</textarea>
                                <div class="d-flex justify-content-end">
                                    <button class="comment-edit-btn ajax-edit-comment ml-3" data-comment_id="{{ $r->id }}" data-reply_to_id="{{ $c->id }}">Edytuj</button>
                                    <button class="comment-edit-cancel-btn" data-comment_id="{{ $r->id }}">Anuluj</button>
                                </div>
                            </div>

                            <!-- Likes -->
                            <div class="pt-2 d-inline-flex align-items-center">
                                @if ( Auth::user() )
                                    @if( Auth::user()->commentLikes()->where('comment_id', $r->id)->first() && Auth::user()->commentLikes()->where('comment_id', $r->id)->first()->like == 1 )
                                        <img class="ajax-comment-like like post-vote mb-1" src="/svg/thumbsup.svg" id="commentLike{{$r->id}}" alt="˄" data-comment_id="{{ $r->id }}">
                                    @else
                                        <img class="ajax-comment-like like post-vote mb-1" src="/svg/thumbsup_blank.svg" id="commentLike{{$r->id}}" alt="˄" data-comment_id="{{ $r->id }}">
                                    @endif
                                @else
                                    <img class="like post-vote mb-1" src="/svg/thumbsup_blank.svg" id="commentLike{{$r->id}}" alt="˄" data-comment_id="{{ $r->id }}">
                                @endif

                                <div class="px-2 like-counter" id="comment-like-counter{{$r->id}}">
                                    {{ $r->likes()->count() - $r->dislikes()->count()}}
                                </div>

                                @if ( Auth::user() )
                                    @if( Auth::user()->commentLikes()->where('comment_id', $r->id)->first() && Auth::user()->commentLikes()->where('comment_id', $r->id)->first()->like == 0 )
                                        <img class="ajax-comment-like dislike post-vote mr-2" src="/svg/thumbsdown.svg" id="commentDislike{{$r->id}}" alt="˅" data-comment_id="{{ $r->id }}">
                                    @else
                                        <img class="ajax-comment-like dislike post-vote mr-2" src="/svg/thumbsdown_blank.svg" id="commentDislike{{$r->id}}" alt="˅" data-comment_id="{{ $r->id }}">
                                    @endif
                                @else
                                    <img class="post-vote mr-2" src="/svg/thumbsdown_blank.svg" id="commentDislike{{$r->id}}" alt="˅" data-comment_id="{{ $r->id }}">
                                @endif

                                <button class="comment-reply-btn" data-comment_id="{{ $r->id }}" data-reply_to_user="{{ $r->user->name }}">Odpowiedz</button>
                            </div>

                            <!-- Reply -->
                            <div class="col-12 comment-reply" data-comment_id="{{ $r->id }}">
                                @if ( Auth::user() )
                                    <div class="row p-2 py-3">
                                        <div class="comment-header d-flex flex-start align-items-center">
                                            @if( !empty(Auth::user()->avatar) )
                                                <img src="/storage/{{ Auth::user()->avatar }}" class="comment-avatar comment-avatar-border" alt="{{ Auth::user()->name }}">
                                            @else
                                                <img src="/img/User_Icon.png" class="comment-avatar comment-avatar-border" alt="{{ Auth::user()->name }}">
                                            @endif
                                            <button class="comment-btn ajax-comment ml-3" data-comment_id="{{ $r->id }}" data-post_id="{{ $c->post->id }}" data-reply_to_id="{{ $c->id }}" disabled>Odpowiedz</button>
                                            <button class="comment-cancel-btn" data-comment_id="{{ $r->id }}">Anuluj</button>
                                        </div>
                                        <textarea class="comment-textarea" rows="3" data-comment_id="{{ $r->id }}"></textarea>
                                    </div>
                                @else
                                    Zaloguj się aby skomentować.
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div><!------ End Replies ------>

        </div>

    </div>
</div>
@endif
