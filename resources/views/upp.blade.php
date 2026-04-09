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

    <div class="max-w-6xl mx-auto px-6 py-16" x-data="{ tab: 'profil' }">
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
                    @click="tab = 'profil'" 
                    :class="tab === 'profil' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 ring-1 ring-blue-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-8 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-4 h-4 mr-2.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil UPP
                </button>
            </nav>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8">
            {{-- Tab Profil UPP --}}
            <div x-show="tab === 'profil'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="max-w-5xl mx-auto space-y-12">
                    
                    {{-- Section 1: Maklumat Pelayanan --}}
                    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-12">
                        <div class="flex items-center mb-10 pb-6 border-b border-slate-100">
                            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mr-5 shadow-sm">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Maklumat Pelayanan</h2>
                                <p class="text-slate-500 font-medium">Standar pelayanan yang kami berikan kepada publik.</p>
                            </div>
                        </div>

                        @if($profil && $profil->moto_pelayanan_path)
                            <div class="bg-slate-50 rounded-[1.5rem] overflow-hidden border border-slate-100 group p-2">
                                <div class="relative overflow-hidden rounded-[1.25rem]">
                                    <img src="{{ asset('storage/' . $profil->moto_pelayanan_path) }}" class="w-full h-auto group-hover:scale-[1.01] transition duration-700">
                                </div>
                            </div>
                        @else
                            <div class="py-12 text-center border-2 border-dashed border-slate-100 rounded-3xl">
                                <p class="text-slate-400 font-medium italic">Gambar maklumat belum tersedia.</p>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        {{-- Section 2: Tupoksi (Left/Large Col) --}}
                        <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-12 relative">
                            <div class="absolute top-0 right-0 p-8 opacity-5">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            
                            <div class="flex items-center mb-10 pb-6 border-b border-slate-100 relative z-10">
                                <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mr-5 shadow-sm">
                                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tugas & Fungsi</h2>
                                    <p class="text-slate-500 font-medium">Tugas Pokok dan Fungsi UPP.</p>
                                </div>
                            </div>

                            <div class="relative prose prose-slate max-w-none prose-headings:text-slate-900 prose-headings:font-extrabold prose-p:text-slate-600 prose-p:leading-relaxed prose-li:text-slate-600">
                                @if($profil && $profil->tupoksi)
                                    {!! $profil->tupoksi !!}
                                @else
                                    <p class="text-slate-400 font-medium italic text-center py-8">Data Tupoksi belum tersedia.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Section 3: Jadwal Operasional (Right/Small Col) --}}
                        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8">
                            <div class="flex items-center mb-8 pb-6 border-b border-slate-100">
                                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mr-4 shadow-sm">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Jam Kerja</h2>
                            </div>

                            <div class="space-y-3">
                                @if($profil && $profil->waktu_pelayanan)
                                    @foreach($profil->waktu_pelayanan as $jadwal)
                                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 group transition duration-300">
                                            <div class="text-sm font-bold text-slate-500 mb-1 uppercase tracking-wider">{{ $jadwal['hari'] }}</div>
                                            <div class="text-slate-900 font-extrabold">{{ $jadwal['waktu'] }}</div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-6">
                                        <p class="text-slate-400 font-medium italic">Jadwal belum tersedia.</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-8 p-5 bg-blue-50 border border-blue-100 rounded-2xl">
                                <p class="text-xs text-blue-800 font-semibold leading-relaxed">Penyelenggaraan pelayanan publik mengikuti hari kerja efektif.</p>
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
