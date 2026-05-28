<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
       <link rel="icon" href="{{ asset('fruds.jpg') }}?v=1">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50/50 dark:bg-gray-950 transition-colors duration-300">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-12">

            <div class="flex flex-col items-center justify-center group mb-6">
                <a href="/" class="focus:outline-none transition-transform duration-200 active:scale-95">
                    <x-application-logo class="w-14 h-14 text-indigo-600 dark:text-indigo-400 transition-colors" />
                </a>
            </div>

            <div class="w-full sm:max-w-xxl px-6 py-6 overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>
