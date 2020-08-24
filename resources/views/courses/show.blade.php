@extends('layouts.app')

@section('title')
{{ $course->title }} | {{ config('app.name') }}-ネット無料教材収集サービス-
@endsection

@section('meta')
<meta property="og:url" content="{{ route('courses.show', $course) }}"/>
<meta property="og:title" content="{{ $course->title }} | {{ config('app.name') }}-ネット無料教材収集サービス-"/>
@endsection

@section('main')
<div id="course-header">
    <div id="course-date-wrap">
        {{ $course->created_at }}
    </div>
    <div id="course-title-wrap">
        <a href="{{ $course->link }}" id="course-title-text">{{ $course->title }}</a>
    </div>
    <div id="course-tag-wrap">
        @foreach($course->tags as $tag)
        <a href="{{ route('courses.index') }}?tag={{ $tag->name }}">#{{ $tag->name }}</a>
        @endforeach
    </div>
    <div id="course-button-wrap">
        <div id="bookmark-button-wrap">
            @if(Auth::guard('web')->check())
            <a href="{{ route('courses.bookmark', $course) }}" id="bookmark-button{{ $bookmark_flag ? '-active' : '-non-active'}}" onclick="event.preventDefault();document.getElementById('bookmark-form').submit();">
                <form id="bookmark-form" action="{{ route('courses.bookmark', $course) }}" method="POST">
                    @csrf
                </form>
                <i class="fas fa-bookmark"></i>
                お気に入り
                {{ $course->bookmark_count }}
            </a>
            @else
            <div id="bookmark-button-non-active">
                <i class="fas fa-bookmark"></i>
                お気に入り
                {{ $course->bookmark_count }}
            </div>
            @endif
        </div>
        <div id="twitter-button-wrap">
            <a id="twitter-button" href="https://twitter.com/share?url={{ route('courses.show', $course) }}&text={{ $course->title }}&hashtags=nocuro" rel="nofollow" target="_blank">
                <i class="fab fa-twitter"></i>
                Twitterで共有
            </a>
        </div>
    </div>
</div>
<div id="course-main">
    @if(!Auth::guard('web')->check())
    @foreach($course->lessons as $lesson)
    <v-card class="course-item" outlined>
        <div class="lesson-title-wrap" style="flex: 1;">
            <a href="{{ $lesson->link }}" class="lesson-title-text" target="_blank" rel="noopener noreferrer">{{ $lesson->title }}</a>
        </div>
        <div class="check-button-wrap">
            <button type="button" class="check-button" disabled>
                <span>未完了</span>
            </button>
        </div>
    </v-card>
    @endforeach
    @else
    <lessons :lessons="{{ $lessons }}" :auth-id="{{ Auth::guard('web')->id() }}" :course-id="{{ json_encode($course->id) }}" :checked-count="{{ $checkedCount }}"></lessons>
    @endif
</div>
@endsection