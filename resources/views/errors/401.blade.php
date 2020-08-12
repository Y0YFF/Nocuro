@extends('errors.layouts.base')

@section('title')
401エラー | {{ config('app.name') }}-ネット教材収集サービス-
@endsection

@section('message_title')
401エラー
@endsection

@section('message_detail')
認証エラー<br>
認証に失敗しました
@endsection