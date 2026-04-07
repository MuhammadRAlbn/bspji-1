<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalibrasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-6xl mx-auto px-4 py-12" x-data="{ tab: 'sertifikasi' }">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-indigo-900 mb-2">Layanan Kalibrasi</h1>
            <p class="text-lg text-gray-600">Informasi lengkap mengenai alur, sertifikasi, dan ruang lingkup kalibrasi kami.</p>
        </div>

        {{-- Navigasi Tab --}}
        <div class="flex justify-center mb-8">
            <div class="inline-flex p-1 bg-gray-200 rounded-xl">
                <button 
                    @click="tab = 'alur-kalibrasi'" 
                    :class="tab === 'alur-kalibrasi' ? 'bg-white text-indigo-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 focus:outline-none"
                >
                    Alur Kalibrasi
                </button>
                <button 
                    @click="tab = 'sertifikasi'" 
                    :class="tab === 'sertifikasi' ? 'bg-white text-indigo-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 focus:outline-none"
                >
                    Sertifikasi
                </button>
                <button 
                    @click="tab = 'ruang-lingkup'" 
                    :class="tab === 'ruang-lingkup' ? 'bg-white text-indigo-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 focus:outline-none"
                >
                    Ruang Lingkup
                </button>
            </div>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8 transition-all duration-300">
            
            {{-- Tab Alur Kalibrasi --}}
            <div x-show="tab === 'alur-kalibrasi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-indigo-900 mb-6 flex items-center">
                        <svg class="w-7 h-7 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        Alur Layanan Kalibrasi
                    </h2>
                    
                    @if($alurKalibrasi && $alurKalibrasi->image)
                        <div class="flex justify-center">
                            <div class="relative group">
                                <img 
                                    src="{{ asset('storage/' . $alurKalibrasi->image) }}" 
                                    alt="Alur Layanan Kalibrasi" 
                                    class="max-w-full h-auto rounded-2xl shadow-2xl border-4 border-white transition duration-500 group-hover:scale-[1.02]"
                                >
                            </div>
                        </div>
                    @else
                        <div class="text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-400">Gambar alur layanan belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Sertifikasi --}}
            <div x-show="tab === 'sertifikasi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-indigo-900 mb-6 flex items-center">
                        <svg class="w-7 h-7 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Sertifikat Akreditasi Kalibrasi
                    </h2>
                    
                    @if($sertifikasi && $sertifikasi->image)
                        <div class="flex justify-center">
                            <div class="relative group">
                                <img 
                                    src="{{ asset('storage/' . $sertifikasi->image) }}" 
                                    alt="Sertifikat Akreditasi Kalibrasi" 
                                    class="max-w-full h-auto rounded-2xl shadow-2xl border-4 border-white transition duration-500 group-hover:scale-[1.02]"
                                >
                            </div>
                        </div>
                    @else
                        <div class="text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-400">Gambar sertifikat belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Ruang Lingkup --}}
            <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($ruangLingkupan as $item)
                        <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100 flex flex-col transition duration-300 hover:shadow-2xl hover:-translate-y-1">
                            @if($item->image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="h-48 bg-indigo-50 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-6 flex-grow">
                                <h3 class="text-xl font-bold text-indigo-900 mb-4">{{ $item->title }}</h3>
                                <ul class="space-y-2">
                                    @foreach($item->details ?? [] as $detail)
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-indigo-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-gray-600 text-sm leading-relaxed">{{ $detail }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl shadow-xl p-12 text-center border border-gray-100">
                            <p class="text-gray-400">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="mt-16 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-800 transition duration-200"> 
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda 
            </a>
        </div>
    </div>

</body>
</html>
