<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="gloval-nav">
        <nav>
            <ul class="nav__list">
                @if (Auth::check())
                <li class="nav__item">
                    <a class="nav__link" href="/">Home</a>
                </li>
                <li class="nav__item">
                    <form class="form" action="/logout" method="post">
                        @csrf
                            <input class="nav__logout" type="submit" value="Logout">
                    </form>
                </li>
                <li class="nav__item">
                    @role('admin')
                        <a class="nav__link" href="/admin/admin">Admin</a>
                    @elserole('editor')
                        <a class="nav__link" href="/editor/admin">Admin</a>
                    @else
                        <a class="nav__link" href="/mypage">Mypage</a>
                    @endrole
                </li>
                @else
                <li class="nav__item">
                    <a class="nav__link" href="/">Home</a>
                </li>
                <li class="nav__item">
                    <a class="nav__logout" href="/register">Registration</a>
                </li>
                <li class="nav__item">
                    <a class="nav__link" href="/login">Login</a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
    <header class="header">
        <div id="nav-toggle">
            <div>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="header__inner">
            <a class="header__logo" href="/">
                Rese
            </a>
            <div class="header__search">
                @yield('shop_search')
            </div>
        </div>
    </header>
    <main>
        <div id="container">
        @yield('content')
        </div>
    </main>
    <script>
        (function($) {
        $(function () {
        $('#nav-toggle').on('click', function() {
        $('body').toggleClass('open');
        });
        });
        })(jQuery);
    </script>
    @yield('script')
</body>

</html>