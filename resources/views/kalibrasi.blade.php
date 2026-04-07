<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Kalibrasi - BSPJI Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-6xl mx-auto px-4 py-16" x-data="{ tab: 'sertifikasi' }">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full uppercase tracking-widest mb-4 inline-block">Pelayanan Kami</span>
            <h1 class="text-5xl font-extrabold text-indigo-950 mb-4 tracking-tight">Layanan Kalibrasi</h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">Penyediaan jasa kalibrasi alat ukur industri dengan standar akreditasi nasional dan internasional.</p>
        </div>

        {{-- Navigasi Tab --}}
        <div class="flex justify-center mb-12">
            <nav class="inline-flex p-1.5 bg-gray-200/80 backdrop-blur-sm rounded-2xl border border-gray-300/50">
                <button 
                    @click="tab = 'alur-kalibrasi'" 
                    :class="tab === 'alur-kalibrasi' ? 'bg-white text-indigo-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Alur
                </button>
                <button 
                    @click="tab = 'sertifikasi'" 
                    :class="tab === 'sertifikasi' ? 'bg-white text-indigo-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Sertifikasi
                </button>
                <button 
                    @click="tab = 'ruang-lingkup'" 
                    :class="tab === 'ruang-lingkup' ? 'bg-white text-indigo-900 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Ruang Lingkup
                </button>
                <button 
                    @click="tab = 'tarif'" 
                    :class="tab === 'tarif' ? 'bg-white text-indigo-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Tarif
                </button>
            </nav>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8 transition-all duration-300">
            
            {{-- Tab Alur Kalibrasi --}}
            <div x-show="tab === 'alur-kalibrasi'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-indigo-950 uppercase tracking-tight">Alur Layanan Kalibrasi</h2>
                    </div>
                    
                    @if($alurKalibrasi && $alurKalibrasi->image)
                        <div class="flex justify-center bg-gray-50 rounded-2xl p-4">
                            <img src="{{ asset('storage/' . $alurKalibrasi->image) }}" alt="Alur Kalibrasi" class="max-w-full h-auto rounded-xl shadow-lg border-2 border-white">
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 py-24 text-center">
                            <p class="text-gray-400 font-medium italic">Data alur layanan belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Sertifikasi --}}
            <div x-show="tab === 'sertifikasi'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-indigo-950 uppercase tracking-tight">Sertifikat Akreditasi</h2>
                    </div>
                    
                    @if($sertifikasis->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($sertifikasis as $sert)
                                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                                    <img src="{{ asset('storage/' . $sert->image) }}" class="w-full h-auto rounded-xl shadow-inner border border-gray-200 transition duration-500 hover:scale-[1.01]">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 py-24 text-center">
                            <p class="text-gray-400 font-medium italic">Gambar sertifikat belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Ruang Lingkup --}}
            <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($ruangLingkupan as $item)
                        <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-gray-100 flex flex-col group hover:-translate-y-2 transition duration-500">
                            @if($item->image)
                                <div class="h-52 overflow-hidden relative">
                                    <div class="absolute inset-0 bg-indigo-900/10 group-hover:bg-transparent transition duration-500 z-10"></div>
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                </div>
                            @endif
                            <div class="p-8 flex-grow">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-full uppercase tracking-widest mb-3 inline-block">Scope</span>
                                <h3 class="text-2xl font-extrabold text-indigo-950 mb-6 leading-tight">{{ $item->title }}</h3>
                                <ul class="space-y-4">
                                    @foreach($item->details ?? [] as $detail)
                                        <li class="flex items-start">
                                            <div class="p-1 bg-green-100 rounded-full mr-3 mt-0.5">
                                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <span class="text-gray-600 text-sm font-medium leading-relaxed">{{ is_array($detail) ? ($detail['name'] ?? '-') : $detail }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab Tarif --}}
            <div x-show="tab === 'tarif'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($ruangLingkupan as $item)
                        <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-gray-100 flex flex-col group hover:shadow-indigo-900/5 transition duration-500">
                            @if($item->image)
                                <div class="h-32 overflow-hidden relative">
                                    <div class="absolute inset-0 bg-gray-900/40 z-10"></div>
                                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover blur-[1px] opacity-60">
                                    <div class="absolute inset-0 z-20 flex items-center justify-center">
                                        <h4 class="text-white font-extrabold text-center px-4 tracking-wide uppercase text-sm">{{ $item->title }}</h4>
                                    </div>
                                </div>
                            @endif
                            <div class="p-8 flex-grow bg-white">
                                <div class="space-y-3">
                                    @foreach($item->details ?? [] as $detail)
                                        @if(is_array($detail))
                                            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-md transition duration-200">
                                                <span class="text-gray-700 text-xs font-bold leading-snug pr-3">{{ $detail['name'] ?? '-' }}</span>
                                                <span class="text-indigo-700 text-sm font-extrabold whitespace-nowrap bg-white px-3 py-1.5 rounded-lg shadow-sm border border-gray-100">Rp {{ number_format($detail['price'] ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data daftar tarif belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        {{-- Footer/Back Link --}}
        <div class="mt-24 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center px-8 py-3 bg-white text-indigo-900 font-bold rounded-2xl shadow-lg border border-gray-100 hover:bg-indigo-50 transition duration-300 group"> 
                <svg class="w-5 h-5 mr-3 transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda 
            </a>
        </div>
    </div>

</body>
</html>
