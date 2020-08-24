@extends('layouts.app')

@section('title')
{{ config('app.name') }}-ネット無料教材収集サービス-
@endsection

@section('meta')
<meta name="description" content="{{ condig('app.name') }}はネット上の無料の教材を集めて進捗管理するサービスです">
<meta property="og:url" content="{{ route('top') }}"/>
<meta property="og:title" content="トップ | {{ config('app.name') }}-ネット無料教材収集サービス-"/>
<meta property="og:description" content="Nocuroはネット上の無料の教材を集めて進捗管理をするサービスです"/>
@endsection

@section('main')
<div id="top-image-wrap">
    <img src="{{ asset('images/top.jpg') }}" alt="top_icon" id="top-image">
</div>
<h2 id="top-title">ネット無料教材収集サービス</h2>
<div id="search-wrap">
    <div id="search-description">あなたの探したいキーワードを入力してください</div>
    <div id="search-bar-wrap">
        <form action="{{ route('courses.index') }}" method="GET">
            <v-text-field rounded dense filled prepend-inner-icon="fas fa-search" :counter="20" name="query">{{ old('query') }}</v-text-field>
        </form>
    </div>
</div>
<div id="courses-items-list">
    @forelse($popular_courses as $popular_course)
    <v-card outlined class="course-item">
        <div class="item-description">
            <div class="item-date">{{ $popular_course->course->created_at }}</div>
            <div class="item-icon-wrap">
                <i class="fas fa-bookmark"></i>
                {{ $popular_course->course->bookmark_count }}
            </div>
        </div>
        <div class="item-main">
            <div class="item-title">
                <a href="{{ route('courses.show', $popular_course->course) }}">{{ $popular_course->course->title }}</a>
            </div>
        </div>
        <div class="item-tags">
            @foreach($popular_course->course->tags as $tag)
            <a href="{{ route('courses.index') }}?tag={{ $tag->name }}" class="tag-text">#{{ $tag->name }}</a>
            @endforeach
        </div>
    </v-card>
    @empty
    <div id="course-empty-item">
        <span id="course-empty-text">まだコースはありません</span>
    </div>
    @endforelse
</div>
@endsection