@extends('layouts.app')

@section('title')
{{ $user->account_id }} | {{ config('app.name') }}-ネット無料教材収集サービス-
@endsection

@section('meta')
<meta property="og:url" content="{{ route('users.show', $user) }}"/>
<meta property="og:title" content="{{ $user->account_id }} | {{ config('app.name') }}-ネット無料教材収集サービス-"/>
@endsection

@section('main')
<div id="user-header-wrap">
    <h1 id="name-wrap">
        <span id="name-text">{{ $user->name }}</span>
    </h1>
    <div id="account-id-wrap">
        <span id="account-id-text">{{ '@' . $user->account_id }}</span>
    </div>
    <div id="completed-course-count-wrap">
        修了数:<i class="fas fa-star complete-icon"></i>
        {{ $user->userinfo->completed_course_count }}
    </div>
</div>
<hr>
<div id="user-progresses-wrap">
    @forelse($user->courses as $course)
    <div class="course-item">
        @if($course->progress == 100)
        <i class="fas fa-star complete-icon"></i>
        @endif
        <a href="{{ route('courses.show', $course) }}" class="course-title">{{ $course->title }}:</a>
        <v-progress-linear value="{{ $course->progress }}" height="30" striped rounded class="lesson-progress">
            <strong class="progress-text">{{ $course->progress }}%</strong>
        </v-progress-linear>
    </div>
    @empty
    <div id="course-empty-item">
        <span id="course-empty-text">まだ進捗はありません</span>
    </div>
    @endforelse
</div>
<hr>
<div id="user-bookmark-wrap">
    <div id="bookmark-title">
        <i class="fas fa-bookmark" id="bookmark-icon"></i>
        お気に入り
    </div>
    <div id="bookmarks-wrap">
        @forelse($user->bookmark_courses as $course)
        <v-card outlined class="course-item">
            <div class="item-description">
                <div class="item-date">{{ $course->created_at }}</div>
                <div class="item-icon-wrap">
                    <i class="fas fa-bookmark"></i>
                    {{ $course->bookmark_count }}
                </div>
            </div>
            <div class="item-main">
                <div class="item-title">
                    <a href="{{ route('courses.show', $course) }}">{{ $course->title }}</a>
                </div>
            </div>
            <div class="item-tags">
                @foreach($course->tags as $tag)
                <a href="{{ route('courses.index') }}?tag={{ $tag->name }}" id="tag-text">#{{ $tag->name }}</a>
                @endforeach
            </div>
        </v-card>
        @empty
        <div id="bookmark-empty-item">
            <span id="bookmark-empty-text">まだお気に入りはありません</span>
        </div>
        @endforelse
    </div>
</div>
@endsection