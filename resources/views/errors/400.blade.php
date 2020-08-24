@extends('errors.layouts.base')

@section('title')
400エラー | {{ config('app.name') }}-ネット無料教材収集サービス-
@endsection

@section('message_title')
400エラー
@endsection

@section('message_detail')
リクエストエラー<br>
このレスポンスは無効です
@endsection