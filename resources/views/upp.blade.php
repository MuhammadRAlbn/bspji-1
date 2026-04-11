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
                <button 
                    @click="tab = 'maklumat'" 
                    :class="tab === 'maklumat' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 ring-1 ring-blue-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-8 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-4 h-4 mr-2.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Maklumat
                </button>
                <button 
                    @click="tab = 'visi-misi'" 
                    :class="tab === 'visi-misi' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 ring-1 ring-blue-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-8 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-4 h-4 mr-2.5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Visi & Misi
                </button>
                <button 
                    @click="tab = 'sop-formulir'" 
                    :class="tab === 'sop-formulir' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 ring-1 ring-blue-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-8 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-4 h-4 mr-2.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    SOP & Formulir
                </button>
                <button 
                    @click="tab = 'sarana'" 
                    :class="tab === 'sarana' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 ring-1 ring-blue-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-8 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-4 h-4 mr-2.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Sarana & Prasarana
                </button>
                <button 
                    @click="tab = 'sk-spm'" 
                    :class="tab === 'sk-spm' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 ring-1 ring-blue-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-8 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-4 h-4 mr-2.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    SK SPM
                </button>
            </nav>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8">
            {{-- Tab Profil UPP --}}
            <div x-show="tab === 'profil'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="max-w-5xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        {{-- Section: Tupoksi (Left/Large Col) --}}
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

                        {{-- Section: Jadwal Operasional (Right/Small Col) --}}
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

            {{-- Tab Maklumat Pelayanan --}}
            <div x-show="tab === 'maklumat'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="max-w-5xl mx-auto">
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

                        @if($maklumat && $maklumat->path)
                            <div class="bg-slate-50 rounded-[1.5rem] overflow-hidden border border-slate-100 group p-2">
                                <div class="relative overflow-hidden rounded-[1.25rem]">
                                    <img src="{{ asset('storage/' . $maklumat->path) }}" class="w-full h-auto group-hover:scale-[1.01] transition duration-700">
                                </div>
                            </div>
                        @else
                            <div class="py-24 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-medium italic text-lg">Maklumat pelayanan belum diunggah.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tab Visi & Misi --}}
            <div x-show="tab === 'visi-misi'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="max-w-5xl mx-auto space-y-12">
                    
                    {{-- Moto Highlight --}}
                    @if($visiMisi && $visiMisi->moto)
                        <div class="bg-blue-600 rounded-[2.5rem] shadow-2xl shadow-blue-200/50 p-12 text-center relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-12 opacity-10">
                                <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div class="relative z-10">
                                <span class="text-blue-100 text-xs font-bold uppercase tracking-[0.3em] mb-4 block">Moto Pelayanan</span>
                                <h2 class="text-3xl md:text-5xl font-black text-white italic tracking-tight leading-tight">"{{ $visiMisi->moto }}"</h2>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        {{-- Visi --}}
                        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 p-12 border border-slate-100 relative group hover:-translate-y-2 transition duration-500">
                            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition duration-500 shadow-sm">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-slate-900 mb-6 tracking-tight">Visi</h3>
                            <div class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed">
                                @if($visiMisi && $visiMisi->visi)
                                    {!! $visiMisi->visi !!}
                                @else
                                    <p class="text-slate-400 font-medium italic">Visi belum ditetapkan.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Misi --}}
                        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 p-12 border border-slate-100 relative group hover:-translate-y-2 transition duration-500">
                            <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition duration-500 shadow-sm">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-slate-900 mb-6 tracking-tight">Misi</h3>
                            <div class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed">
                                @if($visiMisi && $visiMisi->misi)
                                    {!! $visiMisi->misi !!}
                                @else
                                    <p class="text-slate-400 font-medium italic">Misi belum ditetapkan.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab SOP & Formulir --}}
            <div x-show="tab === 'sop-formulir'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="max-w-6xl mx-auto space-y-16">
                    
                    {{-- Section SOP (Images) --}}
                    @if(isset($sopFormulir['sop']) && count($sopFormulir['sop']) > 0)
                        <div>
                            <div class="flex items-center mb-10">
                                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mr-4 shadow-sm">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Standard Operating Procedures (SOP)</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach($sopFormulir['sop'] as $sop)
                                    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 p-4 border border-slate-100 group">
                                        <div class="relative overflow-hidden rounded-[1.5rem] mb-6 aspect-[4/3] bg-slate-50">
                                            <img src="{{ asset('storage/' . $sop->path) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-500 flex items-end p-6">
                                                <a href="{{ asset('storage/' . $sop->path) }}" target="_blank" class="bg-white/20 backdrop-blur-md text-white px-4 py-2 rounded-lg text-sm font-bold uppercase tracking-wider border border-white/30 hover:bg-white hover:text-slate-900 transition duration-300">Lihat Detail</a>
                                            </div>
                                        </div>
                                        <h3 class="text-lg font-extrabold text-slate-900 px-2 line-clamp-2 leading-tight">{{ $sop->name }}</h3>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Section Formulir (PDFs) --}}
                    @if(isset($sopFormulir['formulir']) && count($sopFormulir['formulir']) > 0)
                        <div>
                            <div class="flex items-center mb-10">
                                <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mr-4 shadow-sm">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Formulir Layanan</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($sopFormulir['formulir'] as $form)
                                    <div class="bg-white rounded-3xl shadow-lg shadow-slate-200/40 p-6 border border-slate-100 flex items-center group hover:border-emerald-200 transition duration-300">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mr-6 group-hover:bg-emerald-50 transition duration-300 shadow-inner">
                                            <svg class="w-8 h-8 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path><path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"></path></svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-slate-900 mb-1 leading-snug">{{ $form->name }}</h3>
                                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Format: PDF</p>
                                        </div>
                                        <a href="{{ asset('storage/' . $form->path) }}" target="_blank" class="w-12 h-12 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-emerald-600 hover:text-white transition duration-300 shadow-sm border border-slate-100 group-hover:border-transparent">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!isset($sopFormulir['sop']) && !isset($sopFormulir['formulir']))
                        <div class="py-24 text-center">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 mb-2">Belum Ada Dokumen</h3>
                            <p class="text-slate-500 font-medium">SOP dan Formulir akan ditampilkan di sini setelah diunggah oleh admin.</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Tab Sarana & Prasarana --}}
            <div x-show="tab === 'sarana'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="max-w-6xl mx-auto">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-12">
                        <div class="flex items-center mb-10 pb-6 border-b border-slate-100">
                            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mr-5 shadow-sm">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Sarana & Prasarana</h2>
                                <p class="text-slate-500 font-medium">Fasilitas dan infrastruktur pendukung pelayanan.</p>
                            </div>
                        </div>

                        @if($saranaPrasarana && $saranaPrasarana->pdf)
                            <div class="bg-slate-50 rounded-[1.5rem] overflow-hidden border border-slate-200 group">
                                <iframe src="{{ asset('storage/' . $saranaPrasarana->pdf) }}" class="w-full h-[800px] border-none"></iframe>
                            </div>
                        @else
                            <div class="py-24 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-medium italic text-lg">Data Sarana & Prasarana belum diunggah.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tab SK SPM --}}
            <div x-show="tab === 'sk-spm'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="max-w-6xl mx-auto">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-12">
                        <div class="flex items-center mb-10 pb-6 border-b border-slate-100">
                            <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mr-5 shadow-sm">
                                <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">SK Standar Pelayanan Minimal (SPM)</h2>
                                <p class="text-slate-500 font-medium">Keputusan penetapan standar pelayanan minimal.</p>
                            </div>
                        </div>

                        @if($skSpm && $skSpm->pdf)
                            <div class="bg-slate-50 rounded-[1.5rem] overflow-hidden border border-slate-200 group">
                                <iframe src="{{ asset('storage/' . $skSpm->pdf) }}" class="w-full h-[800px] border-none"></iframe>
                            </div>
                        @else
                            <div class="py-24 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-medium italic text-lg">Data SK SPM belum diunggah.</p>
                            </div>
                        @endif
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
