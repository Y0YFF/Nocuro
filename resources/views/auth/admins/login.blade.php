@extends('layouts.app')

@section('title')
管理者ログイン | {{ config('app.name') }}-ネット無料教材収集サービス-
@endsection

@section('meta')
<meta name=”robots” content=”noindex”/>
@endsection

@section('main')
<div id="form-title-wrap" style="padding-bottom:5px;border-bottom:1px solid #aaa;">
    <span id="form-title-text" style="font-weight:600;">ログイン</span>
</div>
<div id="form-main-wrap">
    <form action="{{ route('admins.login') }}" method="POST">
    @csrf
    <div id="account_id-wrap">
        <v-text-field label="id" type="text" name="account_id"></v-text-field>
    </div>
    <div id="password-wrap">
        <v-text-field label="password" type="password" name="password"></v-text-field>
    </div>
    <v-btn block color="#2196F3" dark type="submit">ログイン</v-btn>
    </form>
</div>
@endsection