@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs">
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $question->title }}</h1>
            </div>
            <div class="col-md-12">
                <div class="crumbs">
                    <a href="{{ route('home') }}">{{ __('Home') }}</a>
                    <span class="crumbs-span">/</span>
                    <span class="current">
                        {{ $question->title }}
                    </span>
                </div>
            </div>
        </div><!-- End row -->
    </section><!-- End container -->
</div><!-- End breadcrumbs -->
@endsection

@section('main')

<div class="col-md-9">
    <article class="question single-question question-type-normal">
        <h2>
            <a href="">
                {{ $question->title }}
            </a>
        </h2>
        @if (Auth::check())
        <a class="question-report" id = "report" data-question="{{ $question->id }}">{{ __('Report') }}</a>
        @else
        <a class="question-report" href="{{ route('login') }}">{{ __('Report') }}</a>
        @endif
        @if ($question->is_poll)
            <div class="question-type-main"><i class="icon-signal"></i>{{ __('Poll') }}</div>
        @else
            <div class="question-type-main"><i class="icon-question-sign"></i>{{ __('Question') }}</div>
        @endif
        <div class="question-inner">
            <div class="poll_2">
                @if ($question->is_poll)
                @if (!Auth::check())
                <span class="error">{{ __('You need to') }} <a href="{{ route('login') }}">{{ __('login') }}</a> {{ __('to vote !') }}</span>
                <div class="clearfix height_10"></div>
                @endif
                <form class="form-style form-style-3">
                    <div class="form-inputs clearfix">
                        @foreach ($question->polls as $item)
                        @if (Auth::check())
                            <p>
                            <input id="poll-{{ $item->id }}" value="{{ $item->id }}" name="poll-radio" type="radio" {{ $item->users->where('id', Auth::user()->id)->count() ? 'checked' : '' }}>
                            <label for="poll-{{ $item->id }}">{{ $item->title }}  <span class="active-clip">(<span class="poll-count">{{ $item->users->count() }}</span> {{ __('Vote') }})</span></label>
                            </p>
                        @else
                            <p>
                            <input id="poll-{{ $item->id }}" name="poll-radio" type="radio" disabled>
                            <label for="poll-{{ $item->id }}">{{ $item->title }}  <span class="active-clip">({{ $item->users->count() }} {{ __('Vote') }})</span></label>
                            </p>
                        @endif   
                        @endforeach
                    </div>
                </form>
                @endif
            </div>
            <div class="clearfix height_10"></div>
            <div class="question-desc">
                @markdown($question->content)
            </div>
            <div class="question-details">
                @if ($question->is_resolve == 0)
                @can('setResolve', $question)
                <div class="share-inside-warp">
                    <ul>
                        <li>
                            <a href="#">
                            <span class="icon_i">
                            <span class="icon_square" icon_size="20" span_bg="#3498Db" span_hover="#666">
                            <i i_color="#FFF" class="icon-ok"></i>
                            </span>
                            </span>
                            </a>
                            <a href="{{ route('questions.resolve.index', ['question' => $question->id]) }}">{{ __('Set resolve') }}</a>
                        </li>
                    </ul>
                    <span class="share-inside-f-arrow"></span>
                    <span class="share-inside-l-arrow"></span>
                </div><!-- End share-inside-warp -->
                @endcan
                <span class="question-answered share-inside" >{{ __('in progress') }}</span>
                @else
                @can('setProgress', $question)
                <div class="share-inside-warp">
                    <ul>
                        <li>
                            <a href="#">
                            <span class="icon_i">
                            <span class="icon_square" icon_size="20" span_bg="#c7151a" span_hover="#666">
                            <i i_color="#FFF" class="icon-remove"></i>
                            </span>
                            </span>
                            </a>
                            <a href="{{ route('questions.progress.index', ['question' => $question->id]) }}">{{ __('in progress') }}</a>
                        </li>
                    </ul>
                    <span class="share-inside-f-arrow"></span>
                    <span class="share-inside-l-arrow"></span>
                </div><!-- End share-inside-warp -->
                @endcan
                <span class="question-answered question-answered-done share-inside"><i class="icon-ok"></i>{{ __('solved') }}</span>
                @endif
                {{-- <span class="question-favorite"><i class="icon-star"></i>{{ $question->votes->count() }}</span> --}}
            </div>
            <span class="question-category"><a href="#"><i class="icon-folder-close"></i>{{ $question->category->name }}</a></span>
            <span class="question-date"><i class="icon-time"></i>{{ $question->created_at->diffForHumans() }}</span>
            <span class="question-comment"><a href="#" id="answer"><i class="icon-comment"></i>{{ $question->answers->count() }} {{ __('Answer') }}</a></span>
            <span class="question-view"><i class="icon-user"></i>{{ $question->view }} {{ __('Views') }}</span>
            <span class="single-question-vote-result" id="count-vote"> {{ $question->voteCount() }}</span>
            <ul class="single-question-vote">
                @if (Auth::check())
                <li><a href="" class="single-question-vote-down {{ Auth::user()->votes()->wherePivot('state', -1)->get()->where('id', $question->id)->count() ? 'active-dislike' : '' }}" title="Dislike" id="dislike" data-question = "{{ $question->id }}"><i class="icon-thumbs-down"></i></a>
                </li>
                @else
                <li><a href="{{ route('login') }}" class="single-question-vote-down" title="Dislike"><i class="icon-thumbs-down"></i></a>
                </li>
                @endif
                @if (Auth::check())
                <li><a href="" class="single-question-vote-up {{ Auth::user()->votes()->wherePivot('state', 1)->get()->where('id', $question->id)->count() ? 'active-like' : '' }}" title="Like" id="like" data-question = "{{ $question->id }}"><i class="icon-thumbs-up"></i></a>
                </li>
                @else
                <li><a href="{{ route('login') }}" class="single-question-vote-up" title="Like"><i class="icon-thumbs-up"></i></a>
                </li>
                @endif
            </ul>
            <div class="clearfix"></div>
        </div>
    </article>

    <div class="share-tags page-content">
        <div class="question-tags"><i class="icon-tags"></i>
            @foreach ($question->tags as $tag)
                <a href="#">{{ $tag->name }}</a>
                @if (!$loop->last), 
                @endif
            @endforeach
        </div>
        <a href="#"><i class="icon-share-alt"></i> {{ __('Share') }}</a> &nbsp; &nbsp;
        @if (Auth::check())
        <a href="#" class="{{ $question->clips->where('id', Auth::user()->id)->count() ? 'active-clip' : '' }}" id = "clip" data-question="{{ $question->id }}"><i class="fa fa-paperclip"></i> {{ __('Clip question') }}</a>&nbsp; &nbsp;
        @else
        <a href="{{ route('login') }}"><i class="fa fa-paperclip"></i> {{ __('Clip question') }}</a>
        @endif
        @can('update', $question)
            <a href="{{ route('questions.edit', ['question' => $question->id]) }}"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>&nbsp; &nbsp;
        @endcan
        @can('delete', $question)
            <a href="#" id="question_id"><i class="fa fa-times"></i> {{ __('delete') }}</a>
            <form id="delete-form" action="{{ route('questions.destroy', ['question' => $question->id]) }}" method="POST">
                <input type="hidden" name="_method" value="delete">
                {{ csrf_field() }}
            </form>
        @endcan
        <div class="clearfix"></div>
    </div><!-- End share-tags -->
    
    @if ($bestComment)
    <div id="commentlist" class="page-content">
        <div class="boxedtitle page-title">
            <h2><i class="icon-ok"></i> {{ __('Best answer') }}</h2>
            <ol class="commentlist clearfix">
                <li class="comment">
                    <div class="comment-body comment-body-answered clearfix">
                        <div class="avatar">
                            <img alt="{{ $bestComment->user->fullname }}" src="{{ asset(config('asset.avatar_path') . $bestComment->user->avatar) }}">
                        </div>
                        <div class="comment-text">
                            <div class="author clearfix">
                                <div class="comment-author"><a href="{{ route('users.show', ['id' => $bestComment->user->id]) }}">{{ $bestComment->user->fullname }}</a></div>
                                <div class="comment-vote">
                                @if (Auth::check())
                                    <ul class="question-vote">
                                        <li><a href="#" class="like-comment question-vote-up {{ Auth::user()->voteAnswers()->wherePivot('state', 1)->get()->where('id', $bestComment->id)->count() ? 'active-like-comment' : '' }}" title="Like" data-comment="{{ $bestComment->id }}"></a></li>
                                        <li><a href="#" class="dislike-comment question-vote-down {{ Auth::user()->voteAnswers()->wherePivot('state', -1)->get()->where('id', $bestComment->id)->count() ? 'active-like-comment' : '' }}" title="Dislike" data-comment="{{ $bestComment->id }}"></a></li>
                                    </ul>
                                @else
                                    <ul class="question-vote">
                                        <li><a href="{{ route('login') }}" class="question-vote-up" title="Like"></a></li>
                                        <li><a href="{{ route('login') }}" class="question-vote-down" title="Dislike"></a></li>
                                    </ul>
                                @endif        
                                </div>
                                <span class="question-vote-result count-vote-comment"> {{ $bestComment->voteCount() }} </span>
                                <div class="comment-meta">
                                    <div class="date"><i class="icon-time"></i>{{ $bestComment->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="text">
                                @markdown($bestComment->content)
                            </div>
                        </div>
                    </div>
                </li>
            </ol>
        </div>
    </div>
    @endif

    <div id="commentlist" class="page-content">
        <div class="boxedtitle page-title">
            <h2>{{ __('Answers') }}</h2>
        </div>
        <ol class="commentlist clearfix">
            @foreach ($comments as $comment)
            <li class="comment">
                <div class="comment-body comment-body-answered clearfix">
                    <div class="avatar">
                        <a href="{{ route('users.show', ['id' => $comment->user->id]) }}">
                            <img alt="{{ $comment->user->fullname }}" src="{{ asset(config('asset.avatar_path') . $comment->user->avatar) }}">
                        </a>
                    </div>
                    <div class="comment-text">
                        <div class="author clearfix">
                            <div class="comment-author"><a href="{{ route('users.show', ['id' => $comment->user->id]) }}">{{ $comment->user->fullname }}</a></div>
                            <div class="comment-vote">
                            @if (Auth::check())
                                <ul class="question-vote">
                                <li><a href="#" class="like-comment question-vote-up {{ Auth::user()->voteAnswers()->wherePivot('state', 1)->get()->where('id', $comment->id)->count() ? 'active-like-comment' : '' }}" title="Like" data-comment="{{ $comment->id }}"></a></li>
                                <li><a href="#" class="dislike-comment question-vote-down {{ Auth::user()->voteAnswers()->wherePivot('state', -1)->get()->where('id', $comment->id)->count() ? 'active-like-comment' : '' }}" title="Dislike" data-comment="{{ $comment->id }}"></a></li>
                                </ul>
                            @else
                                <ul class="question-vote">
                                    <li><a href="{{ route('login') }}" class="question-vote-up" title="Like"></a></li>
                                    <li><a href="{{ route('login') }}" class="question-vote-down" title="Dislike"></a></li>
                                </ul>
                            @endif
                                
                            </div>
                            <span class="question-vote-result count-vote-comment"> {{ $comment->voteCount() }} </span>
                            <div class="comment-meta">
                                <div class="date"><i class="icon-time"></i>{{ $comment->created_at->diffForHumans() }}
                                </div>
                            </div>
                            @if (Auth::check())
                            <a class="comment-reply" href="#"><i class="icon-reply"></i>{{ __('Reply') }}</a>
                            @else
                            <a class="comment-reply" href="{{ route('login') }}"><i class="icon-reply"></i>{{ __('Reply') }}</a>
                            @endif
                        </div>
                        <div class="text">
                            @markdown($comment->content)
                        </div>
                        @can('setBestAnswer', $comment)
                        <div class="question-answered"><a href="{{ route('answers.setbest.index', ['answer' => $comment->id]) }}"><i class="icon-ok"></i>{{ __('Set best answer') }}</a></div>
                        @endcan
                    </div>
                </div>
                
                <ul class="children">
                @if ($comment->childs->count())
                    <li class="comment">
                        <div class="comment-body clearfix">
                            <div class="avatar"><img alt="" src="{{ asset(config('asset.avatar_path') . $comment->user->avatar) }}"></div>
                            <div class="comment-text">
                                <div class="author clearfix">
                                    <div class="comment-author"><a href="#">{{ __('vbegy') }}</a></div>
                                    <div class="comment-vote">
                                        <ul class="question-vote">
                                            @if (Auth::check())
                                            <li><a href="#" class="question-vote-up" title="Like"></a></li>
                                            @else
                                            <li><a href="{{ route('login') }}" class="question-vote-up" title="Like"></a></li>
                                            @endif
                                            @if (Auth::check())
                                            <li><a href="#" class="question-vote-down" title="Dislike"></a></li>
                                            @else
                                            <li><a href="{{ route('login') }}" class="question-vote-down" title="Dislike"></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <span class="question-vote-result">+1</span>
                                    <div class="comment-meta">
                                        <div class="date"><i class="icon-time"></i>{{ __('January 15 , 2014 at 10:00 pm') }}
                                        </div>
                                    </div>
                                    <a class="comment-reply" href="#"><i class="icon-reply"></i>{{ __('Reply') }}</a>
                                </div>
                                <div class="text">
                                    <p>{{ __('Lorem') }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
                {{-- <textarea aria-required="true" cols="58" rows="3" name="content" class="reply">{{ old('content') }}</textarea> --}}
                </ul><!-- End children -->
            </li>
            @endforeach
        </ol><!-- End commentlist -->
        {{ $comments->render('paginations.paginate') }}
    </div><!-- End page-content -->
    
    @if (Auth::check())
    <div id="respond" class="comment-respond page-content clearfix">
        <div class="boxedtitle page-title">
            <h2>{{ __('Leave a reply') }}</h2>
        </div>
        <form action="{{ route('questions.answers.store', ['questions' => $question->id]) }}" method="post" id="commentform" class="comment-form">
            @csrf
            <input type="hidden" name="parent_id" value="0">
            <div id="respond-textarea">
                <p>
                    <label class="required" for="comment">{{ __('Comment') }}<span>*</span>
                    @error('content')
                    <span class="error form-description">{{ $message }}</span>
                    @enderror
                    </label>
                    <textarea id="question-details" name="content" aria-required="true" cols="58" rows="8" id = ""></textarea>
                </p>
            </div>
            <p class="form-submit">
                <input name="submit" type="submit" id="submit" value="Post your answer" class="button small color">
            </p>
        </form>
    </div>
    @else
    <div id="respond" class="comment-respond page-content clearfix">
        <p class="form-submit">
            <form action="{{ route('login') }}">
                <input name="submit" type="submit" id="submit" value="Login to answer" class="button small color">
            </form>
        </p>
    </div>
    @endif
</div><!-- End main -->
@endsection

@section('sidebar')
<aside class="col-md-3 sidebar">
    @include('layouts.statistic')
    <div class="widget widget_stats">
        <h3 class="widget_title">{{ __('About author') }}</h3>
        <div class="ul_list ul_list-icon-ok">
            <ul>
                <li>
                    <div class="author-img">
                        <a href="{{ route('users.show', ['user' => $question->user->id]) }}"><img src="{{ asset(config('asset.avatar_path') . $question->user->avatar) }}" alt="{{ $question->user->fullname }}"></a>
                    </div>
                    <h6><a href="{{ route('users.show', ['user' => $question->user->id]) }}">{{ $question->user->fullname }}</a></h6>
                </li>
                <li><i class="icon-question-sign"></i>{{ __('Questions') }} ( <span>{{ $question->user->questions->count() }}</span> )</li>
                <li><i class="icon-comment"></i>{{ __('Answers') }} ( <span>{{ $question->user->answers->count() }}</span> )</li>
                <li><i class="icon-btc"></i>{{ __('Points') }} ( <span>{{ $question->user->point }}</span> )</li>
            </ul>
        </div>
    </div>
    
    <div class="widget">
        <h3 class="widget_title">{{ __('Relate Questions') }}</h3>
        <ul class="related-posts">
            @foreach ($relate as $question)
                <li class="related-item">
                    <h3><a href="#">{{ $question->title }}</a></h3>
                    <div class="clear"></div>
                    <span>{{ $question->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    @if (Auth::check())
    <div class="widget">
        <h3 class="widget_title">{{ __('Clip Questions') }}</h3>
        <ul class="related-posts">
            @foreach ($questionClips as $question)
                <li class="related-item">
                    <h3><a href="#">{{ $question->title }}</a></h3>
                    <div class="clear"></div>
                    <span>{{ $question->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</aside>
<!-- End sidebar
@endsection
