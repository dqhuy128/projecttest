<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    @yield('title')
    {{-- meta basic --}}
    @if (View::hasSection('meta_basic'))
        @yield('meta_basic')
    @else
        {!! @$seoDefault['meta_basic'] !!}
    @endif
    {{-- meta facebook --}}
    @if (View::hasSection('facebook_meta'))
        @yield('facebook_meta')
    @else
        {!! @$seoDefault['facebook_meta'] !!}
    @endif
    {{-- meta twitter --}}
    @if (View::hasSection('twitter_meta'))
        @yield('twitter_meta')
    @else
        {!! @$seoDefault['twitter_meta'] !!}
    @endif
    {{-- meta google --}}
    @if (View::hasSection('g_meta'))
        @yield('g_meta')
    @else
        {!! @$seoDefault['g_meta'] !!}
    @endif

    <!-- Icons -->
    @foreach ($def['site_media'] as $css)
        {!! \Lib::addMedia($css) !!}
    @endforeach

    <!-- Main styles for this application -->
    @foreach ($def['site_css'] as $css)
        {!! \Lib::addMedia($css) !!}
    @endforeach

    @yield('css_top')
    @stack('css_bot_all')
    @yield('js_top')

    {!! @$def['script_head'] !!}
</head>

<body>
    <div id="app">
        @include('FrontEnd::layouts.header')
        @yield('content')
        @include('FrontEnd::layouts.footer')

        <script type="text/javascript">
            var cart_items_root = [];
            var ENV = {
                    version: '{{ env('APP_VER', 0) }}',
                    token: '{{ csrf_token() }}',
                    @foreach ($def['site_js_val'] as $key => $val)
                        {{ $key }}: '{{ $val }}',
                    @endforeach
                },
                COOKIE_ID = '{{ env('APP_NAME', '') }}',
                DOMAIN_COOKIE_REG_VALUE = 1,
                DOMAIN_COOKIE_STRING = '{{ config('session.domain') }}';
                console.log(ENV)
        </script>

        @if (env('APP_DEBUG'))
            {!! \Lib::addMedia('js/prettyprint.js') !!}
        @endif

        <!-- Bootstrap and necessary plugins -->
        @foreach ($def['site_js'] as $js)
            {!! \Lib::addMedia($js) !!}
        @endforeach

        <!-- other script -->
        @yield('js_bot')
        @stack('js_bot_all')

    </div>

    {!! @$def['site_chatbot'] !!}

    {!! @$def['script_body'] !!}
</body>

</html>
