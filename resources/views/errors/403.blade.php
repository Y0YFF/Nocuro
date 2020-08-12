@extends('errors.layouts.base')

@section('title')
403エラー | {{ config('app.name') }}-ネット教材収集サービス-
@endsection

@section('message_title')
403エラー
@endsection

@section('message_detail')
アクセス権エラー<br>
あなたにはアクセス権がありません
@endsection