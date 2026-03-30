<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah Singkat</title>
    <!-- Memuat CSS dari Vite (Tailwind CSS terinstal) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-5xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-4">Sejarah Singkat</h1>
            <p class="text-lg text-gray-600">Perjalanan dan jejak langkah kami dari masa ke masa.</p>
        </div>

        @if($sejarahSingkats->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                Belum ada data sejarah singkat yang ditambahkan.
            </div>
        @else
            <div class="space-y-12">
                @foreach($sejarahSingkats as $sejarah)
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col md:flex-row transition duration-300 hover:shadow-lg">
                        
                        {{-- Kolom Gambar (jika ada) --}}
                        @if($sejarah->gambar)
                            <div class="md:w-1/3 bg-gray-200">
                                <img src="{{ Storage::url($sejarah->gambar) }}" alt="{{ $sejarah->judul }}" class="w-full h-64 md:h-full object-cover">
                            </div>
                        @endif

                        {{-- Kolom Teks --}}
                        <div class="p-8 @if($sejarah->gambar) md:w-2/3 @else w-full @endif flex flex-col justify-center">
                            <div class="text-sm font-bold text-blue-600 mb-2">{{ $sejarah->tahun }}</div>
                            <h2 class="text-2xl font-bold mb-4">{{ $sejarah->judul }}</h2>
                            <div class="prose max-w-none text-gray-600 whitespace-pre-line">
                                {{ $sejarah->detail }}
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>
