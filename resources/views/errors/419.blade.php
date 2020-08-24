@extends('errors.layouts.base')

@section('title')
419エラー | {{ config('app.name') }}-ネット無料教材収集サービス-
@endsection

@section('message_title')
419エラー
@endsection

@section('message_detail')
セッションが切れました<br>
再度アクセスしてください
@endsection