<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title')</title>

<link rel="shortcut icon" href="/favicon.ico">
<script src="https://kit.fontawesome.com/64bc6b4e38.js" crossorigin="anonymous"></script>

<link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <v-app id="vue-app">
            <v-app-bar app dense flat color="#009688">
                <div class="mx-auto w-100" id="top-bar-wrap">
                    <a href="{{ route('top') }}" id="top-bar-left">
                        <h1 id="site-title">Nocuro</h1>
                        <h2 id="site-sub-title">(ノクロ)</h2>
                    </a>
                </div>
            </v-app-bar>
            <v-main>
                <div class="mx-auto w-100" id="main-wrap">
                    <div id="error-wrap">
                        <h1 id="error-title">@yield('message_title')</h1>
                        <p>@yield('message_detail')</p>
                    </div>
                </div>
            </v-main>
            <v-footer>
                <div id="footer-wrap" class="mx-auto w-100">
                    <span class="footer-text">
                        <a href="{{ route('trm') }}">利用規約</a>
                    </span>
                    <span class="footer-text">
                        <a href="{{ route('pvy') }}">プライバシーポリシー</a>
                    </span>
                    <span class="footer-text">
                        ©︎2020 Nocuro
                    </span>
                </div>
            </v-footer>
            <v-bottom-navigation background-color="#009688" grow id="navigation-wrap">
                <v-btn href="{{ route('courses.index') }}" class="nav-button">
                    <span class="nav-button-text">ホーム</span>
                    <v-icon class="nav-button-icon">fas fa-home</v-icon>
                </v-btn>
                @if(Auth::guard('web')->check())
                <v-btn href="{{ route('users.show', Auth::guard('web')->user()) }}" class="nav-button">
                    <span class="nav-button-text">ユーザー</span>
                    <v-icon class="nav-button-icon">fas fa-user</v-icon>
                </v-btn>
                @else
                <v-btn href="{{ route('login') }}" class="nav-button">
                    <span class="nav-button-text">ユーザー</span>
                    <v-icon class="nav-button-icon">fas fa-user</v-icon>
                </v-btn>
                @endif
            </v-bottom-navigation>
        </v-app>
    </div>
    <script src="{{ asset(mix('js/app.js')) }}"></script>
</body>
</html>