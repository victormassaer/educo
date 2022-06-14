<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased overflow-hidden">
    <div class="min-h-screen bg-gray-100 flex flex-grow overflow-y-auto">

        <!-- Sidebar -->
        @if (auth()->user()->role_id === 2)
            @include('layouts.sidebar-expert')
        @elseif(auth()->user()->role_id === 3)
            @include('layouts.sidebar-admin')
        @else
            @include('layouts.sidebar-user')
        @endif


        <!-- Page Content -->
        <div class="w-full relative flex-1 overflow-y-auto h-screen">
            <div class="py-12 px-44 max-w-screen-2xl mx-auto sm:px-6 lg:px-8">{{ $slot }}</div>
        </div>



    </div>
</body>

</html>
