<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Favicon -->
    @php
        use App\Models\SiteSetting;
        $faviconUrl = SiteSetting::getFaviconUrl();
        
        // Debug for checking
        // dd($faviconUrl, SiteSetting::getValue('favicon'));
    @endphp
    
    @if($faviconUrl)
        <link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">
        <link rel="shortcut icon" href="{{ $faviconUrl }}" type="image/x-icon">
        <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
    @else
        {{-- Default favicon --}}
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        <!-- Your layout content here -->
        @yield('content')
    </div>
</body>
</html>