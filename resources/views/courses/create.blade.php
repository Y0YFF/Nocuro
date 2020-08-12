@extends('layouts.app')

@section('title')
コース作成 | {{ config('app.name') }}-ネット教材収集サービス-
@endsection

@section('main')
<div id="form-title-wrap" style="padding-bottom:5px;border-bottom:1px solid #aaa;">
    <span id="form-title-text" style="font-weight:600;">コース作成</span>
</div>
<div id="form-main-wrap">
    <form action="{{ route('courses.store') }}" method="POST">
    @csrf
    <div id="course-title-wrap">
        <v-text-field label="course_title" type="text" name="course_title"></v-text-field>
    </div>
    <div id="tags-wrap">
        <v-text-field label="tags" type="text" name="tags"></v-text-field>
    </div>
    <div id="course-link-wrap">
        <v-text-field label="course_link" type="text" name="course_link"></v-text-field>
    </div>
    <lessons-form></lessons-form>
    <div id="sumit-button-wrap" style="margin-top:30px;">
        <v-btn block color="#2196F3" dark type="submit">作成</v-btn>
    </div>
    </form>
</div>
@endsection