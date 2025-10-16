<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col bg-gray-100">
        @include('layouts.navigation')
        <main class="flex flex-1">
            {{ $slot }}
        </main>
        <footer class="bg-gray-100 text-center text-sm text-gray-600 p-4">
            <div class="container mx-auto">
                &copy; {{ date('Y') }} My App. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>
