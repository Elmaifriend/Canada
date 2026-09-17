<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Estilos y Scripts (Vite / Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100 font-sans text-gray-900 antialiased">

    <!-- Contenido principal cargado por Livewire -->
    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>