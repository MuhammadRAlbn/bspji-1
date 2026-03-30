<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas dan Fungsi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-2">Tugas dan Fungsi</h1>
            <p class="text-lg text-gray-600">Tugas pokok dan fungsi strategis kami dalam melayani masyarakat.</p>
        </div>

        @if(!$tugasFungsi)
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                Data Tugas dan Fungsi belum tersedia.
            </div>
        @else
            <div class="space-y-8">
                {{-- Bagian Tugas --}}
                <div class="bg-white rounded-2xl shadow-sm p-8 border-l-4 border-blue-600 transition duration-300 hover:shadow-lg">
                    <h2 class="text-2xl font-bold text-blue-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Tugas
                    </h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $tugasFungsi->tugas !!}
                    </div>
                </div>

                {{-- Bagian Fungsi --}}
                <div class="bg-white rounded-2xl shadow-sm p-8 border-l-4 border-indigo-600 transition duration-300 hover:shadow-lg">
                    <h2 class="text-2xl font-bold text-indigo-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.642.257a4 4 0 01-1.58.19H5.152a2 2 0 110-4h2.152a2 2 0 011.58.19l1.458.583a2 2 0 00.738.14h3.504a2 2 0 011.022.547l2.387.477a6 6 0 013.86-.517l.642-.257a4 4 0 001.58-.19h6.148a2 2 0 100-4h-6.148a2 2 0 00-1.58.19l-1.458.583a2 2 0 01-.738.14H16.03a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.642.257a4 4 0 01-1.58.19H5.152a2 2 0 110-4h2.152a2 2 0 011.58.19l1.458.583a2 2 0 00.738.14h3.504a2 2 0 011.022.547l2.387.477a6 6 0 013.86-.517l.642-.257a4 4 0 001.58-.19h6.148a2 2 0 100-4h-6.148a2 2 0 00-1.58.19l-1.458.583a2 2 0 01-.738.14H16.03a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.642.257a4 4 0 01-1.58.19H5.152a2 2 0 110-4h2.152a2 2 0 011.58.19l1.458.583a2 2 0 00.738.14h3.504a2 2 0 011.022.547l2.387.477a6 6 0 013.86-.517l.642-.257a4 4 0 001.58-.19h6.148a2 2 0 100-4h-6.148a2 2 0 00-1.58.19l-1.458.583a2 2 0 01-.738.14H16.03"></path>
                        </svg>
                        Fungsi
                    </h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $tugasFungsi->fungsi !!}
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
