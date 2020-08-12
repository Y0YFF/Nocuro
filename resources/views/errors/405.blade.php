@extends('errors.layouts.base')

@section('title')
405エラー | {{ config('app.name') }}-ネット教材収集サービス-
@endsection

@section('message_title')
405エラー
@endsection

@section('message_detail')
正当なアクセスではありません
@endsection