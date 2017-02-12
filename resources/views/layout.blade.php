<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <title>{{ config('app.name') }}</title>
    {{--<link rel="stylesheet" href="/css/font-awesome.css">--}}
    <!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->

    <link rel="stylesheet" href="/css/all.css">
    {{--<script src="/js/axios.min.js"></script>--}}
    @yield('header_extra_scripts')
</head>
<body>
<section class="hero is-fullheight is-default is-bold">
    @include('snippets.nav')
    <div class="hero-body" id="root">
        <div class="container has-text-centered">
            <div class="columns is-vcentered">
                <div class="column is-4">
                    <figure class="is-4by3">
                        <a href="/"><img src="/images/johnny.jpeg" alt="Description"></a>
                    </figure>
                    @yield('content_left')
                </div>
                <div class="column is-8 is-offset-1">
                    @yield('content_right')
                </div>
            </div>
        </div>
    </div>
    @include('snippets.footer')
</section>
</body>
<script src="/js/app.js"></script>
<script src="/js/all.js"></script>
@yield('footer_extra_scripts')
</html>
