@extends('layouts.app')

@section('title')
管理者ページ | {{ config('app.name') }}-ネット教材収集サービス-
@endsection

@section('main')
<div id="popular-courses-title-wrap">
    <div id="form-title-text">人気のコース</div>
    <div id="add-popular-courses-button-wrap">
        <div id="add-popular-courses-button" data-toggle="modal" data-target="#addPopularCourseModal">
            <i class="fas fa-plus"></i>
        </div>
        <div id="addPopularCourseModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">人気のコースの追加</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admins.addPopularCourse') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="id" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary text-white w-100">追加</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popular-courses-items-list">
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
            <a href="{{ route('courses.index') }}?tag={{ $tag->name }}" id="tag-text">#{{ $tag->name }}</a>
            @endforeach
        </div>
    </v-card>
    @empty
    <div id="course-empty-item">
        <span id="course-empty-text">まだコースはありません</span>
    </div>
    @endforelse
</div>
<div id="create-courses-button">
    <v-btn block href="{{ route('courses.create') }}" id="create-button">
        <v-icon x-small>fas fa-plus</v-icon>
        <span>コース</span>
    </v-btn>
</div>
@endsection