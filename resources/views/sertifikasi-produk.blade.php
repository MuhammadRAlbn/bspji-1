<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikasi Produk - BSPJI Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-6xl mx-auto px-4 py-16" x-data="{ tab: 'sertifikat' }">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-widest mb-4 inline-block">Layanan Unggulan</span>
            <h1 class="text-5xl font-extrabold text-green-950 mb-4 tracking-tight">Sertifikasi Produk (LSPro)</h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">Penyediaan jasa sertifikasi mutu produk (SNI) untuk menjamin kualitas dan daya saing produk industri Anda.</p>
        </div>

        {{-- Navigasi Tab --}}
        <div class="flex justify-center mb-12">
            <nav class="inline-flex p-1.5 bg-gray-200/80 backdrop-blur-sm rounded-2xl border border-gray-300/50">
                <button 
                    @click="tab = 'alur'" 
                    :class="tab === 'alur' ? 'bg-white text-green-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Alur
                </button>
                <button 
                    @click="tab = 'sertifikat'" 
                    :class="tab === 'sertifikat' ? 'bg-white text-green-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Sertifikat
                </button>
                <button 
                    @click="tab = 'ruang-lingkup'" 
                    :class="tab === 'ruang-lingkup' ? 'bg-white text-green-900 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Ruang Lingkup
                </button>
                <button 
                    @click="tab = 'dokumen'" 
                    :class="tab === 'dokumen' ? 'bg-white text-green-900 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Dokumen
                </button>
                <button 
                    @click="tab = 'tarif'" 
                    :class="tab === 'tarif' ? 'bg-white text-green-900 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Tarif
                </button>
                <button 
                    @click="tab = 'sdm'" 
                    :class="tab === 'sdm' ? 'bg-white text-green-900 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    SDM
                </button>
                <button 
                    @click="tab = 'informasi-publik'" 
                    :class="tab === 'informasi-publik' ? 'bg-white text-green-900 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Informasi Publik
                </button>
            </nav>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8 transition-all duration-300">
            
            {{-- Tab Alur --}}
            <div x-show="tab === 'alur'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-green-950 uppercase tracking-tight">Alur Sertifikasi Produk</h2>
                    </div>
                    
                    @if($alurProduk && $alurProduk->image)
                        <div class="flex justify-center bg-gray-50 rounded-2xl p-4">
                            <img src="{{ asset('storage/' . $alurProduk->image) }}" alt="Alur Sertifikasi" class="max-w-full h-auto rounded-xl shadow-lg border-2 border-white">
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 py-24 text-center">
                            <p class="text-gray-400 font-medium italic">Data alur sertifikasi belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Sertifikat --}}
            <div x-show="tab === 'sertifikat'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-green-950 uppercase tracking-tight">Sertifikat Akreditasi LSPro</h2>
                    </div>
                    
                    @if($sertifikats->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($sertifikats as $sert)
                                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300 text-center">
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
                    @forelse($ruangLingkup as $item)
                        <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-gray-100 flex flex-col group hover:-translate-y-2 transition duration-500">
                            @if($item->image)
                                <div class="h-64 overflow-hidden relative p-4 bg-gray-50">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-700">
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab Dokumen --}}
            <div x-show="tab === 'dokumen'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-green-950 uppercase tracking-tight">Dokumen Sertifikasi Produk</h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-3">
                            <thead>
                                <tr class="text-gray-400 text-xs uppercase tracking-widest font-bold">
                                    <th class="px-6 py-3">No</th>
                                    <th class="px-6 py-3">Nama Dokumen</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumens as $index => $dokumen)
                                    <tr class="bg-gray-50/50 hover:bg-green-50 transition duration-300 group rounded-2xl shadow-sm">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-400 w-16 rounded-l-2xl border-y border-l border-gray-100">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-green-950 border-y border-gray-100">
                                            {{ $dokumen->nama_dokumen }}
                                        </td>
                                        <td class="px-6 py-4 text-right rounded-r-2xl border-y border-r border-gray-100">
                                            <a href="{{ route('dokumen-produk.download', $dokumen) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-green-200 hover:bg-green-700 hover:shadow-green-300 transition duration-300 group">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-400 font-medium italic bg-gray-50/50 rounded-2xl border-2 border-dashed border-gray-200">
                                            Belum ada dokumen yang tersedia saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Tab Tarif --}}
            <div x-show="tab === 'tarif'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-green-950 uppercase tracking-tight">Tarif Layanan Sertifikasi Produk</h2>
                    </div>
                    
                    <div class="space-y-12">
                        @forelse($tarifs as $tarif)
                            <div class="space-y-4">
                                <h3 class="text-lg font-bold text-green-900 px-2 border-l-4 border-amber-500">{{ $tarif->nama_dokumen }}</h3>
                                <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-inner bg-gray-50 aspect-[3/4] md:aspect-video">
                                    <iframe 
                                        src="{{ asset('storage/' . $tarif->file_path) }}" 
                                        class="w-full h-full border-none"
                                        title="{{ $tarif->nama_dokumen }}"
                                    >
                                        Browser Anda tidak mendukung iframe. Silakan download dokumen.
                                    </iframe>
                                </div>
                            </div>
                        @empty
                            <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 py-24 text-center">
                                <p class="text-gray-400 font-medium italic">Informasi tarif belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Tab SDM --}}
            <div x-show="tab === 'sdm'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-10">
                        <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-extrabold text-green-950 uppercase tracking-tight">Sumber Daya Manusia (SDM)</h2>
                            <p class="text-gray-500 font-medium">Auditor Sertifikasi Produk yang kompeten dan berpengalaman.</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {{-- Card Ahli Madya --}}
                        <div class="group relative bg-gradient-to-br from-indigo-600 to-blue-700 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-100/50 hover:shadow-indigo-200/50 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative z-10 flex flex-col items-center text-center space-y-6">
                                <div class="bg-white/20 backdrop-blur-md px-6 py-2 rounded-2xl border border-white/20">
                                    <span class="text-3xl font-black">{{ $countAhliMadya }}</span>
                                    <span class="text-xs font-bold uppercase tracking-widest ml-2 opacity-80">Auditor</span>
                                </div>
                                
                                <h3 class="text-4xl font-extrabold tracking-tighter group-hover:scale-110 transition-transform duration-500">AMMI</h3>
                                
                                <div class="w-full space-y-1">
                                    <div class="h-px bg-white/20 w-1/2 mx-auto"></div>
                                    <p class="text-lg font-bold tracking-tight uppercase">Ahli Madya</p>
                                    <div class="h-px bg-white/20 w-1/2 mx-auto"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Card Ahli Muda --}}
                        <div class="group relative bg-gradient-to-br from-amber-500 to-orange-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-amber-100/50 hover:shadow-amber-200/50 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative z-10 flex flex-col items-center text-center space-y-6">
                                <div class="bg-white/20 backdrop-blur-md px-6 py-2 rounded-2xl border border-white/20">
                                    <span class="text-3xl font-black">{{ $countAhliMuda }}</span>
                                    <span class="text-xs font-bold uppercase tracking-widest ml-2 opacity-80">Auditor</span>
                                </div>
                                
                                <h3 class="text-4xl font-extrabold tracking-tighter group-hover:scale-110 transition-transform duration-500">AMMI</h3>
                                
                                <div class="w-full space-y-1">
                                    <div class="h-px bg-white/20 w-1/2 mx-auto"></div>
                                    <p class="text-lg font-bold tracking-tight uppercase">Ahli Muda</p>
                                    <div class="h-px bg-white/20 w-1/2 mx-auto"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Card Ahli Pertama --}}
                        <div class="group relative bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-emerald-100/50 hover:shadow-emerald-200/50 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative z-10 flex flex-col items-center text-center space-y-6">
                                <div class="bg-white/20 backdrop-blur-md px-6 py-2 rounded-2xl border border-white/20">
                                    <span class="text-3xl font-black">{{ $countAhliPertama }}</span>
                                    <span class="text-xs font-bold uppercase tracking-widest ml-2 opacity-80">Auditor</span>
                                </div>
                                
                                <h3 class="text-4xl font-extrabold tracking-tighter group-hover:scale-110 transition-transform duration-500">AMMI</h3>
                                
                                <div class="w-full space-y-1">
                                    <div class="h-px bg-white/20 w-1/2 mx-auto"></div>
                                    <p class="text-lg font-bold tracking-tight uppercase">Ahli Pertama</p>
                                    <div class="h-px bg-white/20 w-1/2 mx-auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Informasi Publik --}}
            <div x-show="tab === 'informasi-publik'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-green-950 uppercase tracking-tight">Informasi Publik Produk</h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-3">
                            <thead>
                                <tr class="text-gray-400 text-xs uppercase tracking-widest font-bold">
                                    <th class="px-6 py-3">No</th>
                                    <th class="px-6 py-3">Nama Informasi</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($informasiPubliks as $index => $informasi)
                                    <tr class="bg-gray-50/50 hover:bg-blue-50 transition duration-300 group rounded-2xl shadow-sm">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-400 w-16 rounded-l-2xl border-y border-l border-gray-100">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-green-950 border-y border-gray-100">
                                            {{ $informasi->nama }}
                                        </td>
                                        <td class="px-6 py-4 text-right rounded-r-2xl border-y border-r border-gray-100">
                                            <a href="{{ route('informasi-publik-produk.download', $informasi) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition duration-300 group">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-400 font-medium italic bg-gray-50/50 rounded-2xl border-2 border-dashed border-gray-200">
                                            Belum ada informasi publik yang tersedia saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
