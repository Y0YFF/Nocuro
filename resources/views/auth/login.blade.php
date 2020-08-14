@extends('layouts.app')

@section('title')
ログイン | {{ config('app.name') }}-ネット教材収集サービス-
@endsection

@section('meta')
<meta property="og:url" content="{{ route('login') }}"/>
<meta property="og:title" content="ログイン | {{ config('app.name') }}-ネット教材収集サービス-"/>
@endsection

@section('main')
<div id="form-header-wrap">
    <div id="title-wrap">
        <div id="login-text-wrap">
            <span id="login-text">ログイン</span>
        </div>
        <div id="register-text-wrap">
            <span id="register-text">
                <a href="{{ route('register') }}">登録</a>
            </span>
        </div>
    </div>
    <div id="twitter-login-wrap">
        <a href="{{ route('twitter.auth') }}">
            <i class="fab fa-twitter"></i>
            Twitterでログイン
        </a>
    </div>
</div>
<div id="form-description-wrap">
    <i class="far fa-check-circle" id="description-icon"></i>
    <span id="description-text">
        ログインすると進捗管理できます
    </span>
</div>
<div id="form-main-wrap">
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <account-id-input old-value="{{ old('account_id') }}" :errors="{{ $errors }}" placeholder=""></account-id-input>
        <password-input :errors="{{ $errors }}" placeholder=""></password-input>
        <v-btn block color="#2196F3" type="submit" id="submit-button">ログイン</v-btn>
    </form>
</div>
@endsection
