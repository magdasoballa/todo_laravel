<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <script>
        (function() {
            const appearance = '{{ $appearance ?? "system" }}';
            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>

{{--    <style>--}}
{{--        html {--}}
{{--            background-color: oklch(1 0 0);--}}
{{--        }--}}
{{--        html.dark {--}}
{{--            background-color: oklch(0.145 0 0);--}}
{{--        }--}}
{{--    </style>--}}

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any" />
    <link rel="icon" href="/favicon.svg" type="image/svg+xml" />
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @stack('styles')

</head>
<body class="bg-gray text-gray-900 font-sans antialiased">
<header class="flex items-center justify-between p-4 bg-gray-100 border-b">
    <h1 class="text-lg font-semibold">TODO APP</h1>

    <div class="flex items-center space-x-4">
        @auth

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Wyloguj się
            </button>
        </form>
        @endauth

    </div>
</header>

<div class="container mx-auto p-4">
    @yield('content')
</div>
</body>
</html>
