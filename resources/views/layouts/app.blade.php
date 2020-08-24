<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:creator" content="@Y0YFF"/>
<meta property="og:image" content="{{ asset('images/nocuro.jpeg') }}"/>

@yield('meta')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>

<link rel="shortcut icon" href="/favicon.ico">
<script src="https://kit.fontawesome.com/64bc6b4e38.js" crossorigin="anonymous"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-135763173-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-135763173-2');
</script>


<!-- Styles -->
<link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
<link rel="preload" href="{{ url('/vendor/mckenziearts/laravel-notify/css/notify.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ url('/vendor/mckenziearts/laravel-notify/css/notify.css') }}"></noscript>
</head>
<body>
    <div id="app">
        <v-app id="vue-app">
            <v-app-bar app dense flat color="#009688">
                <div class="mx-auto w-100" id="top-bar-wrap">
                    <a href="{{ route('top') }}" id="top-bar-left">
                        <h1 id="site-title">Nocuro</h1>
                        <span id="site-sub-title">(ノクロ)</span>
                    </a>
                    <div id="top-bar-right">
                    @if(Auth::guard('admin')->check())
                    <a href="{{ route('admins.logout') }}" onclick="event.preventDefault();document.getElementById('logout-admin-form').submit();" id="auth-text">管理者ログアウト</a>
                    <form id="logout-admin-form" action="{{ route('admins.logout') }}" method="POST">
                        @csrf
                    </form>
                    @else
                        @if(!Auth::guard('web')->check())
                        <a href="{{ route('login') }}" id="auth-text-login">ログイン</a>
                        <a href="{{ route('register') }}" id="auth-text-register">登録</a>
                        @else
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" id="auth-text">ログアウト</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                        @endif
                    @endif
                    </div>
                </div>
            </v-app-bar>
            <v-main>
                <div class="mx-auto w-100" id="main-wrap">
                    @yield('main')
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
            <v-bottom-navigation background-color="#009688" grow id="navigation-wrap" fixed>
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
    @include('notify::messages')
    @notifyJs
</body>
</html>