<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="css/jquery.formstyler.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="navbar navbar-inverse navbar-fixed-top header-nav" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    <!--li><a href="#">btn</a></li>
                    <li><a href="#">btn</a></li>
                    <li><a href="#">btn</a></li-->
                </ul>
                <div id="header_right" style="">
                    <div id="right_info">
                        <div class="flex-center position-ref full-height">
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                {{--@guest--}}
                                    {{--<li class="nav-item">--}}
                                        {{--<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
                                    {{--</li>--}}
                                    {{--<li class="nav-item">--}}
                                        {{--<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
                                    {{--</li>--}}
                                    {{--@else--}}
                                        <li class="nav-item dropdown">
                                            <a href="#"
                                               role="button"
                                               data-toggle="dropdown"
                                            >
                                                <img :src="currentFlag" style="height: 20px;"/>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="#"
                                                   @click.prevent="toggleLang('en')"
                                                   v-if="$i18n.locale != 'en'"
                                                >
                                                    <img src="/img/flag_en.png" style="height: 20px;"/>
                                                </a>
                                                <a class="dropdown-item" href="#"
                                                   @click.prevent="toggleLang('ru')"
                                                   v-if="$i18n.locale != 'ru'"
                                                >
                                                    <img src="/img/flag_ru.png" style="height: 20px;"/>
                                                </a>
                                                <a class="dropdown-item" href="#"
                                                   @click.prevent="toggleLang('ch')"
                                                   v-if="$i18n.locale != 'ch'"
                                                >
                                                    <img src="/img/flag_ch.png" style="height: 20px;"/>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown"
                                               class="nav-link dropdown-toggle"
                                               href="#"
                                               role="button"
                                               data-toggle="dropdown"
                                               aria-haspopup="true"
                                               aria-expanded="false"
                                               v-pre
                                            >
                                                {{--{{ Auth::user()->name }}--}}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                        {{--@endguest--}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <tabs-panel></tabs-panel>
    <div id="main" class="container-fluid">
        <div class="row">
            <sidebar></sidebar>
            <router-view v-cloak v-if="bloggers.length || this.$route.name != 'blogger'"></router-view>
            <footbar></footbar>
        </div>
    </div>
    <no-subscribes></no-subscribes>
</div>

<!--SCRIPTS-->
<script src="js/matchMedia.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/docs.min.js"></script>
<script src="js/jquery.formstyler.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
