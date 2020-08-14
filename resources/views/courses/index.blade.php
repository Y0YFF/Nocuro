@extends('layouts.app')

@section('title')
教材一覧 | {{ config('app.name') }}-ネット教材収集サービス-
@endsection

@section('meta')
<meta property="og:url" content="{{ route('courses.index') }}"/>
<meta property="og:title" content="コース一覧 | {{ config('app.name') }}-ネット教材収集サービス-"/>
@endsection

@section('main')
<div id="search-wrap">
    <div id="search-description">あなたの探したいキーワードを入力してください</div>
    <div id="search-bar-wrap">
        <form action="{{ route('courses.index') }}" method="GET">
            <v-text-field rounded dense filled prepend-inner-icon="fas fa-search" :counter="20" name="query">{{ old('query') }}</v-text-field>
        </form>
    </div>
</div>
<div id="courses-items-list">
    @forelse($courses as $course)
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
    <div id="course-empty-item">
        <span id="course-empty-text">まだコースはありません</span>
    </div>
    @endforelse
    <div id="pagination-wrap">
        {{ $courses->appends(Request::except('page'))->links() }}
    </div>
</div> 
@endsection