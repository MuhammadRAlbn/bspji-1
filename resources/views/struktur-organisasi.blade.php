<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-5xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-2">Struktur Organisasi</h1>
            <p class="text-lg text-gray-600">Bagan susunan organisasi dan tata kerja instansi kami.</p>
        </div>

        @if(!$strukturOrganisasi || !$strukturOrganisasi->image_path)
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                Data Struktur Organisasi belum tersedia.
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-6 overflow-hidden">
                <img src="{{ asset('storage/' . $strukturOrganisasi->image_path) }}" alt="Struktur Organisasi" class="w-full h-auto rounded-lg shadow-sm">
            </div>
        @endif
        
        <div class="mt-12 text-center">
            <a href="{{ url('/') }}" class="text-blue-600 hover:underline inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
