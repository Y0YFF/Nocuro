@extends('layouts.app')

@section('title')
登録 | {{ config('app.name') }}-ネット教材収集サービス-
@endsection

@section('meta')
<meta property="og:url" content="{{ route('register') }}"/>
<meta property="og:title" content="登録 | {{ config('app.name') }}-ネット教材収集サービス-"/>
@endsection

@section('main')
<div id="form-header-wrap">
    <div id="title-wrap">
        <div id="register-text-wrap">
            <span id="register-text">
                登録
            </span>
        </div>
        <div id="login-text-wrap">
            <span id="login-text">
                <a href="{{ route('login') }}">ログイン</a>
            </span>
        </div>
    </div>
    <div id="twitter-login-wrap">
        <a href="{{ route('twitter.auth') }}">
            <i class="fab fa-twitter"></i>
            Twitterで登録
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
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <name-input old-value="{{ old('name') }}" :errors="{{ $errors }}"></name-input>
        <account-id-input old-value="{{ old('account_id') }}" :errors="{{ $errors }}" placeholder="4文字以上15文字以下の半角英数字"></account-id-input>
        <email-input old-value="{{ old ('email') }}" :errors="{{ $errors }}"></email-input>
        <password-input :errors="{{ $errors }}" placeholder="6文字以上20文字以下の半角英数字"></password-input>
        <password-confirmation-input></password-confirmation-input>
        <v-btn block color="#2196F3" type="submit" id="submit-button">登録</v-btn>
    </form>
</div>
@endsection
