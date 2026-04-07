<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengujian</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-6xl mx-auto px-4 py-12" x-data="{ tab: 'sertifikasi' }">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-2">Layanan Pengujian</h1>
            <p class="text-lg text-gray-600">Informasi lengkap mengenai alur, sertifikasi, dan ruang lingkup pengujian kami.</p>
        </div>

        {{-- Navigasi Tab --}}
        <div class="flex justify-center mb-8">
            <div class="inline-flex p-1 bg-gray-200 rounded-xl">
                <button 
                    @click="tab = 'alur-pengujian'" 
                    :class="tab === 'alur-pengujian' ? 'bg-white text-blue-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 focus:outline-none"
                >
                    Alur Pengujian
                </button>
                <button 
                    @click="tab = 'sertifikasi'" 
                    :class="tab === 'sertifikasi' ? 'bg-white text-blue-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 focus:outline-none"
                >
                    Sertifikasi
                </button>
                <button 
                    @click="tab = 'ruang-lingkup'" 
                    :class="tab === 'ruang-lingkup' ? 'bg-white text-blue-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 focus:outline-none"
                >
                    Ruang Lingkup
                </button>
            </div>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8 transition-all duration-300">
            
            {{-- Tab Alur Pengujian --}}
            <div x-show="tab === 'alur-pengujian'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                        <svg class="w-7 h-7 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        Alur Layanan Pengujian
                    </h2>
                    
                    @if($alurPengujian && $alurPengujian->image)
                        <div class="flex justify-center">
                            <div class="relative group">
                                <img 
                                    src="{{ asset('storage/' . $alurPengujian->image) }}" 
                                    alt="Alur Layanan Pengujian" 
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
                    <h2 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                        <svg class="w-7 h-7 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Sertifikat Akreditasi
                    </h2>
                    
                    @if($sertifikasi && $sertifikasi->image)
                        <div class="flex justify-center">
                            <div class="relative group">
                                <img 
                                    src="{{ asset('storage/' . $sertifikasi->image) }}" 
                                    alt="Sertifikat Akreditasi" 
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
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="p-8 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-blue-900 flex items-center">
                            <svg class="w-7 h-7 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.618.308a3 3 0 01-1.286.308H9.75a3 3 0 00-1.302.308l-.618.308a6 6 0 01-3.86.517l-2.388-.477a2 2 0 00-1.022.547l-.23.23a2 2 0 00-.547 1.022l-.477 2.387a2 2 0 00.547 1.022l.23.23a2 2 0 001.022.547l2.387.477a6 6 0 003.86-.517l.618-.308a3 3 0 011.286-.308h2.121a3 3 0 001.302-.308l.618-.308a6 6 0 003.86-.517l2.388.477a2 2 0 001.022-.547l.23-.23a2 2 0 00.547-1.022l.477-2.387a2 2 0 00-.547-1.022l-.23-.23z"></path>
                            </svg>
                            Ruang Lingkup Pengujian
                        </h2>
                        <span class="px-4 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider">
                            {{ $ruangLingkupan->count() }} Komoditi
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="px-8 py-5 text-sm font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Komoditi</th>
                                    <th class="px-8 py-5 text-sm font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Ruang Lingkup Pengujian</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($ruangLingkupan as $item)
                                    <tr class="hover:bg-blue-50/30 transition duration-150">
                                        <td class="px-8 py-6 font-semibold text-gray-900 align-top w-1/3">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 rounded-full bg-blue-500 mr-3"></div>
                                                {{ $item->komoditi }}
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-gray-600 leading-relaxed whitespace-pre-line">
                                            {!! $item->ruang_lingkup !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-8 py-12 text-center text-gray-400">
                                            Data ruang lingkup belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-16 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition duration-200"> 
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda 
            </a>
        </div>
    </div>

</body>
</html>
