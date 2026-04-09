<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Pelayanan Publik - BSPJI Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-blue-100 selection:text-blue-900">

    <div class="max-w-6xl mx-auto px-6 py-16" x-data="{ tab: 'maklumat' }">
        <!-- Hero Section -->
        <div class="text-center mb-16 relative">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-32 h-32 bg-blue-100 rounded-full blur-3xl opacity-50 -z-10"></div>
            <span class="px-4 py-1.5 bg-blue-100/50 text-blue-700 text-xs font-bold rounded-full uppercase tracking-widest mb-4 inline-block backdrop-blur-sm border border-blue-200">Informasi Layanan</span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">Unit Pelayanan Publik <br><span class="text-blue-600">(UPP)</span></h1>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">Berkomitmen memberikan pelayanan publik yang transparan, akuntabel, dan berorientasi pada kepuasan masyarakat industri.</p>
        </div>

        {{-- Navigasi Tab --}}
        <div class="flex justify-center mb-16">
            <nav class="inline-flex p-1.5 bg-white rounded-2xl shadow-sm border border-slate-200 backdrop-blur-xl">
                <button 
                    @click="tab = 'maklumat'" 
                    :class="tab === 'maklumat' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 ring-1 ring-blue-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-4 h-4 mr-2.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Maklumat Pelayanan
                </button>
                <button 
                    @click="tab = 'tupoksi'" 
                    :class="tab === 'tupoksi' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 ring-1 ring-blue-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-4 h-4 mr-2.5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Tugas & Fungsi
                </button>
                <button 
                    @click="tab = 'waktu'" 
                    :class="tab === 'waktu' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 ring-1 ring-blue-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-4 h-4 mr-2.5 transition-transform group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Waktu Pelayanan
                </button>
            </nav>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8">
            
            {{-- Tab Maklumat Pelayanan --}}
            <div x-show="tab === 'maklumat'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="max-w-4xl mx-auto">
                    @if($profil && $profil->moto_pelayanan_path)
                        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 group p-2">
                            <div class="relative overflow-hidden rounded-[2.25rem]">
                                <img src="{{ asset('storage/' . $profil->moto_pelayanan_path) }}" class="w-full h-auto group-hover:scale-[1.02] transition duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent pointer-events-none"></div>
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-[2.5rem] shadow-xl p-24 text-center border border-slate-100 border-dashed">
                             <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-slate-400 font-medium italic text-lg">Maklumat pelayanan belum diunggah.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Tupoksi --}}
            <div x-show="tab === 'tupoksi'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-12 relative">
                        <div class="absolute top-0 right-0 p-8 opacity-5">
                            <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="relative prose prose-slate max-w-none prose-headings:text-slate-900 prose-headings:font-extrabold prose-p:text-slate-600 prose-p:leading-relaxed prose-li:text-slate-600">
                            @if($profil && $profil->tupoksi)
                                {!! $profil->tupoksi !!}
                            @else
                                <div class="text-center py-12">
                                    <p class="text-slate-400 font-medium italic text-lg">Data Tugas Pokok dan Fungsi belum tersedia.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Waktu Pelayanan --}}
            <div x-show="tab === 'waktu'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-10">
                        <div class="flex items-center mb-10 pb-6 border-b border-slate-100">
                            <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center mr-5 shadow-sm">
                                <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Jadwal Operasional</h2>
                                <p class="text-slate-500 font-medium">Jam kerja pelayanan Unit Pelayanan Publik</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @if($profil && $profil->waktu_pelayanan)
                                @foreach($profil->waktu_pelayanan as $jadwal)
                                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-2xl border border-slate-100/80 hover:bg-blue-50/50 hover:border-blue-100 transition duration-300 group">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-4 group-hover:scale-150 transition-transform"></div>
                                            <span class="text-lg font-bold text-slate-800">{{ $jadwal['hari'] }}</span>
                                        </div>
                                        <div class="px-6 py-2 bg-white rounded-xl shadow-sm border border-slate-200 text-blue-700 font-bold text-sm tracking-wide">
                                            {{ $jadwal['waktu'] }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-12">
                                    <p class="text-slate-400 font-medium italic text-lg">Informasi waktu pelayanan belum tersedia.</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-10 p-6 bg-blue-50 border border-blue-100 rounded-2xl">
                            <div class="flex gap-4">
                                <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-sm text-blue-800 font-medium leading-relaxed">Penyelenggaraan pelayanan publik mengikuti hari kerja efektif. Harap perhatikan waktu istirahat pada jam siang.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer/Back Link --}}
        <div class="mt-20 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center px-10 py-4 bg-white text-slate-800 font-bold rounded-2xl shadow-lg border border-slate-100 hover:bg-slate-50 hover:-translate-y-1 transition duration-300 group"> 
                <svg class="w-5 h-5 mr-3 transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda 
            </a>
        </div>
    </div>

</body>
</html>
