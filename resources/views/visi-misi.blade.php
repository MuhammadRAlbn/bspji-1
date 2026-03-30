<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi dan Misi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-2">Visi dan Misi</h1>
            <p class="text-lg text-gray-600">Landasan dan cita-cita kami dalam memberikan pelayanan terbaik.</p>
        </div>

        @if(!$visiMisi)
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                Data Visi dan Misi belum tersedia.
            </div>
        @else
            <div class="space-y-8">
                {{-- Bagian Visi --}}
                <div class="bg-white rounded-2xl shadow-sm p-8 border-l-4 border-blue-600 transition duration-300 hover:shadow-lg">
                    <h2 class="text-2xl font-bold text-blue-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Visi
                    </h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $visiMisi->visi !!}
                    </div>
                </div>

                {{-- Bagian Misi --}}
                <div class="bg-white rounded-2xl shadow-sm p-8 border-l-4 border-green-600 transition duration-300 hover:shadow-lg">
                    <h2 class="text-2xl font-bold text-green-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Misi
                    </h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $visiMisi->misi !!}
                    </div>
                </div>
            </div>
        @endif
        
        <div class="mt-12 text-center">
            <a href="{{ url('/') }}" class="text-blue-600 hover:underline"> Kembali ke Beranda </a>
        </div>
    </div>

</body>
</html>
