@extends('errors.layouts.base')

@section('title')
503エラー | {{ config('app.name') }}-ネット教材収集サービス-
@endsection

@section('message_title')
503エラー
@endsection

@section('message_detail')
申し訳ありません<br>
ただ今、メンテナンス中です
@endsection