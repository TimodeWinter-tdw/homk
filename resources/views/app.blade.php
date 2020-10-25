<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HOMK') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="shortcut icon" type="image/png" href="/images/favicon.png">


        <!-- Scripts -->
        @routes
{{--        <script src="/js/moment.min.js" defer></script>--}}
        <script src="/js/fa-all.min.js" defer></script>
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#6875f5">
        <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">
    </head>
    <body class="font-sans antialiased">
        @inertia

        <noscript>
            <div style="padding: 10px">
                <span style="color:red">Javascript is not enabled.</span>
            </div>
        </noscript>

        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/service-worker.js');
                });
            }
        </script>
        <script src="{{ mix('js/app.js') }}" defer></script>

    </body>
</html>
