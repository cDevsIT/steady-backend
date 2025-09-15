<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    {{--    SEO META--}}

    <title>{{isset($seo) ?  $seo['metaTitle'] : env('APP_NAME')}} @stack('title')</title>
    <link rel="canonical" href="{{isset($seo) ?  $seo['canonicalUrl'] : url()->current()}}">
    <meta name="description" content="{{ isset($seo) ? $seo['metaDescription'] : env('META_DESCRIPTION') }}">

    @if(isset($seo) && $seo['schema'])
        <script type="application/ld+json">
            {!! json_encode($seo['schema'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endif
    @if(isset($jsonLd))
        <script type="application/ld+json">
            {!! $jsonLd !!}
        </script>
    @endif
    <link rel="icon" href="{{asset('assets/images')}}/fav.png" sizes="32x32"/>
    <link rel="icon" href="{{asset('assets/images')}}/fav.png"
          sizes="192x192"/>
    <link rel="apple-touch-icon" href="{{asset('assets/images')}}/fav.png"/>
    <meta name="msapplication-TileImage"
          content="{{asset('assets/images')}}/fav.png"/>
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('css')
    @if(isset($setting) && $setting->gtm)
        <script>
            (function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{$setting->gtm}}');
        </script>
    @endif
    
    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Get the user's timezone
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        // Check if the timezone cookie exists
        if (!getCookie('timezone')) {
            // Set the timezone cookie with a 1-day expiration
            const expires = new Date();
            expires.setDate(expires.getDate() + 1); // Cookie expires in 1 day
            document.cookie = `timezone=${timezone}; expires=${expires.toUTCString()}; path=/`;
        } else if (getCookie('timezone') !== timezone) {
            const expires = new Date();
            expires.setDate(expires.getDate() + 1); // Cookie expires in 1 day
            document.cookie = `timezone=${timezone}; expires=${expires.toUTCString()}; path=/`;
        }
        console.log(getCookie('timezone') + "===" + timezone)
    </script>
</head>
<body>
@include('web.layouts.header')
@yield('content')

<input type="hidden" id="current_ip" value="">
<input type="hidden" id="store_route" value="{{route('test')}}">
<input type="hidden" id="csrf_token" value="{{csrf_token()}}">
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>


{{--Toaster Alart Section--}}
<script>
    @if (Session::has('success'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.success("{{ session('success') }}");
    @endif
        @if (Session::has('error'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.error("{{ session('error') }}");
    @endif
        @if (Session::has('info'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.info("{{ session('info') }}");
    @endif
        @if (Session::has('warning'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.warning("{{ session('warning') }}");

    @endif
    function alertMessage(type, message) {
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        if (type === 'success') {
            toastr.success(message);
        } else if (type === 'error') {
            toastr.error(message);
        } else if (type === 'info') {
            toastr.info(message);
        } else if (type === 'warning') {
            toastr.warning(message);
        }

    }
</script>
@stack('js')
<!-- Additionally, paste this code immediately after the opening <body> tag: -->
<!-- Google Tag Manager (noscript) -->
@if(isset($setting) && $setting->gtm)
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id={{$setting->gtm}}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
@endif

<!-- End Google Tag Manager (noscript) -->
<script>
    var logger = function()
{
    var oldConsoleLog = null;
    var pub = {};

    pub.enableLogger =  function enableLogger() 
                        {
                            if(oldConsoleLog == null)
                                return;

                            window['console']['log'] = oldConsoleLog;
                        };

    pub.disableLogger = function disableLogger()
                        {
                            oldConsoleLog = console.log;
                            window['console']['log'] = function() {};
                        };

    return pub;
}();

$(document).ready(
    function()
    {
        console.log('hello');

        logger.disableLogger();
        console.log('hi', 'hiya');
        console.log('this wont show up in console');

        logger.enableLogger();
        console.log('This will show up!');
    }
 );
</script>
</body>

</html>
