@extends('errors.layouts.base')

@section('title')
500エラー | {{ config('app.name') }}-ネット無料教材収集サービス-
@endsection

@section('message_title')
500エラー
@endsection

@section('message_detail')
申し訳ありません<br>
サービスでエラーが発生しています<br>
至急<a href="mailto:yatarofujinaga@gmail">管理者</a>もしくは<a href="https://twitter.com/Y0YFF">Twitterアカウント</a>まで連絡ください
@endsection