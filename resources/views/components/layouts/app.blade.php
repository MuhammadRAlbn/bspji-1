@props(['title' => 'BSPJI Banda Aceh', 'description' => 'Balai Standardisasi dan Pelayanan Jasa Industri (BSPJI) Banda Aceh — layanan teknis pengujian, kalibrasi, sertifikasi, dan konsultasi industri.', 'bodyClass' => 'bg-white'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;600;800&display=swap" rel="stylesheet">

    @livewireScriptConfig
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body {{ $attributes->merge(['class' => $bodyClass . ' text-slate-800 antialiased font-sans pt-20']) }}>

    <x-layouts.partials.navbar />

    <main>
        {{ $slot }}
    </main>

    <x-layouts.partials.footer />

    @stack('scripts')
</body>

</html>
