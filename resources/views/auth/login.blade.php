@extends('layouts.app')

@section('title')
ログイン | {{ config('app.name') }}-ネット教材収集サービス-
@endsection

@section('meta')
<meta property="og:url" content="{{ route('login') }}"/>
<meta property="og:title" content="ログイン | {{ config('app.name') }}-ネット教材収集サービス-"/>
@endsection

@section('main')
<div id="form-title-wrap">
    <span id="form-title-text">ログイン</span>
</div>
<div id="form-description-wrap">
    <v-alert type="success" outlined>
        <i class="far fa-check-circle"></i>
        ログイン/登録すると進捗管理できます
    </v-alert>
</div>
<div id="form-button-wrap">
    <v-btn block color="#00acee" dark href="{{ route('twitter.auth') }}">
        <i class="fab fa-twitter"></i>
        <span>Twitterでログイン/登録</span>
    </v-btn>
</div>
@endsection
