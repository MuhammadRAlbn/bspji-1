<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembaga Pemeriksa Halal - BSPJI Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-6xl mx-auto px-4 py-16" x-data="{ tab: 'ruang-lingkup' }">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-widest mb-4 inline-block">Layanan Utama</span>
            <h1 class="text-5xl font-extrabold text-green-950 mb-4 tracking-tight">Lembaga Pemeriksa Halal (LPH)</h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">Penyediaan jasa pemeriksaan dan pengujian kehalalan produk untuk menjamin kepastian halal bagi pelaku industri dan konsumen.</p>
        </div>

        {{-- Navigasi Tab --}}
        <div class="flex justify-center mb-12">
            <nav class="inline-flex p-1.5 bg-gray-200/80 backdrop-blur-sm rounded-2xl border border-gray-300/50">
                <button 
                    @click="tab = 'ruang-lingkup'" 
                    :class="tab === 'ruang-lingkup' ? 'bg-white text-green-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Ruang Lingkup
                </button>
                <button 
                    @click="tab = 'sdm'" 
                    :class="tab === 'sdm' ? 'bg-white text-green-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    SDM LPH
                </button>
                <button 
                    @click="tab = 'alur'" 
                    :class="tab === 'alur' ? 'bg-white text-green-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Alur & Kelengkapan
                </button>
                <button 
                    @click="tab = 'struktur'" 
                    :class="tab === 'struktur' ? 'bg-white text-green-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                    Struktur, Visi & Misi
                </button>
            </nav>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8 transition-all duration-300">
            
            {{-- Tab Ruang Lingkup --}}
            <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($ruangLingkup as $item)
                        <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-gray-100 flex flex-col group hover:-translate-y-2 transition duration-500">
                            @if($item->gambar)
                                <div class="h-64 overflow-hidden relative p-4 bg-gray-50">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-700">
                                </div>
                            @endif
                            <div class="p-8">
                                <h3 class="text-xl font-extrabold text-green-950 mb-2 leading-tight">{{ $item->nama }}</h3>
                                <div class="h-1 w-12 bg-green-500 rounded-full"></div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab SDM --}}
            <div x-show="tab === 'sdm'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    {{-- Auditor Halal --}}
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-8">
                        <div class="flex items-center mb-8">
                            <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-extrabold text-green-950 tracking-tight">Auditor Halal</h2>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse($sdmAuditor as $sdm)
                                <div class="flex items-center p-4 bg-gray-50/50 rounded-2xl border border-gray-100 hover:bg-indigo-50 transition duration-300">
                                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center mr-4 text-white font-bold shadow-lg shadow-indigo-100">
                                        {{ substr($sdm->nama, 0, 1) }}
                                    </div>
                                    <span class="text-lg font-bold text-green-950">{{ $sdm->nama }}</span>
                                </div>
                            @empty
                                <p class="text-gray-400 font-medium italic">Data auditor halal belum tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Dewan Pembina Syariah --}}
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-8">
                        <div class="flex items-center mb-8">
                            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-extrabold text-green-950 tracking-tight">Dewan Pembina Syariah</h2>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse($sdmPembina as $sdm)
                                <div class="flex items-center p-4 bg-gray-50/50 rounded-2xl border border-gray-100 hover:bg-amber-50 transition duration-300">
                                    <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center mr-4 text-white font-bold shadow-lg shadow-amber-100">
                                        {{ substr($sdm->nama, 0, 1) }}
                                    </div>
                                    <span class="text-lg font-bold text-green-950">{{ $sdm->nama }}</span>
                                </div>
                            @empty
                                <p class="text-gray-400 font-medium italic">Data dewan pembina syariah belum tersedia.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Alur & Kelengkapan --}}
            <div x-show="tab === 'alur'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 gap-12">
                    @forelse($alurKelengkapan as $item)
                        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 group">
                            @if($item->nama)
                                <div class="p-8 border-b border-gray-100 bg-gray-50/30">
                                    <h3 class="text-2xl font-extrabold text-green-950 tracking-tight">{{ $item->nama }}</h3>
                                </div>
                            @endif
                            @if($item->gambar)
                                <div class="p-8 flex justify-center bg-white">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="max-w-full h-auto rounded-2xl shadow-lg group-hover:scale-[1.01] transition duration-700">
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data alur dan kelengkapan belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab Struktur, Visi & Misi --}}
            <div x-show="tab === 'struktur'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 gap-12">
                    @forelse($strukturVisiMisi as $item)
                        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 group">
                            @if($item->nama)
                                <div class="p-8 border-b border-gray-100 bg-gray-50/30">
                                    <h3 class="text-2xl font-extrabold text-green-950 tracking-tight">{{ $item->nama }}</h3>
                                </div>
                            @endif
                            @if($item->gambar)
                                <div class="p-8 flex justify-center bg-white">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="max-w-full h-auto rounded-2xl shadow-lg group-hover:scale-[1.01] transition duration-700">
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data struktur, visi & misi belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        {{-- Footer/Back Link --}}
        <div class="mt-24 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center px-8 py-3 bg-white text-green-900 font-bold rounded-2xl shadow-lg border border-gray-100 hover:bg-green-50 transition duration-300 group"> 
                <svg class="w-5 h-5 mr-3 transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda 
            </a>
        </div>
    </div>

</body>
</html>
