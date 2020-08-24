@extends('layouts.app')

@section('title')
{{ $course->title }}の編集 | {{ config('app.name') }}-ネット無料教材収集サービス-
@endsection

@section('main')
<div id="course-header">
    <div id="course-date-wrap">
        {{ $course->created_at }}
    </div>
    <div id="course-title-wrap">
        <a href="{{ $course->link }}" id="course-title-text">{{ $course->title }}</a>
    </div>
    <div id="course-delete-button-wrap">
        <a href="{{ route('courses.delete', $course) }}" id="delete-button" onclick="event.preventDefault();document.getElementById('delete-course-form').submit();">
            <form id="delete-course-form" action="{{ route('courses.delete', $course) }}" method="POST">
                @csrf
                @method('delete')
            </form>
            削除
        </a>
    </div>
</div>
@endsection