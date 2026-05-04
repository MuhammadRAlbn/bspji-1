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
<body
    x-data="{ tab: 'ruang-lingkup' }"
    class="overflow-x-hidden bg-white font-sans text-[#1d1d1f] antialiased leading-relaxed"
>
    <header class="relative mb-8 flex h-[300px] w-full items-center overflow-hidden text-white sm:mx-auto sm:mt-5 sm:mb-10 sm:h-[360px] sm:w-[96%] sm:rounded-[25px] md:mt-5 md:h-[400px]">
        <img
            src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=2074"
            alt="Lembaga Pemeriksa Halal (LPH)"
            class="absolute inset-0 -z-10 h-full w-full object-cover brightness-[0.7]"
        >
        <div class="mx-auto w-full max-w-[1400px] px-5 text-left sm:px-8 md:px-20">
            <h1 class="text-[2.25rem] font-bold tracking-[-0.03em] sm:text-[3rem] md:text-[4.5rem]">
                Lembaga Pemeriksa Halal (LPH)
            </h1>
        </div>
    </header>

    <main class="mx-auto grid max-w-[1400px] grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:sticky lg:top-10 lg:grid-cols-1">
            <button
                type="button"
                @click="tab = 'ruang-lingkup'"
                :class="tab === 'ruang-lingkup' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'ruang-lingkup' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.75h4.5m-7.386 2.25h10.272c.53 0 1.02.28 1.286.736l2.226 3.818a1.5 1.5 0 0 1 0 1.51l-2.226 3.818a1.5 1.5 0 0 1-1.286.736H6.864a1.5 1.5 0 0 1-1.286-.736l-2.226-3.818a1.5 1.5 0 0 1 0-1.51l2.226-3.818A1.5 1.5 0 0 1 6.864 6ZM9 9.75h6m-6 3h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Ruang Lingkup</span>
            </button>

            <button
                type="button"
                @click="tab = 'sdm'"
                :class="tab === 'sdm' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'sdm' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">SDM LPH</span>
            </button>

            <button
                type="button"
                @click="tab = 'alur'"
                :class="tab === 'alur' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'alur' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 15.75 19.5 19.5m0 0-3.75 3.75M19.5 19.5H9A6.75 6.75 0 0 1 2.25 12.75V10.5A6.75 6.75 0 0 1 9 3.75h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Alur & Kelengkapan</span>
            </button>

            <button
                type="button"
                @click="tab = 'struktur'"
                :class="tab === 'struktur' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'struktur' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Struktur, Visi & Misi</span>
            </button>
            
            <button
                type="button"
                @click="tab = 'mutu'"
                :class="tab === 'mutu' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'mutu' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.42 15.17L17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.492-3.053c.15-.18.232-.405.232-.64V6.105c0-.44-.226-.85-.595-1.104l-1.094-.753A1.826 1.826 0 0 0 10.61 4H6.264a2.25 2.25 0 0 0-2.25 2.25v2.247c0 .598.237 1.171.659 1.594l3.197 3.197A2.25 2.25 0 0 0 11.42 15.17Z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Kebijakan & Sasaran Mutu</span>
            </button>

            <button
                type="button"
                @click="tab = 'tarif'"
                :class="tab === 'tarif' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'tarif' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14.25 6.75 12m0 0L9 9.75M6.75 12h10.5m3.75-6.75v13.5A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V5.25A2.25 2.25 0 0 1 5.25 3h13.5A2.25 2.25 0 0 1 21 5.25Z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Tarif</span>
            </button>
            
            <button
                type="button"
                @click="tab = 'infrastruktur'"
                :class="tab === 'infrastruktur' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'infrastruktur' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6.75h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Infrastruktur</span>
            </button>
        </div>

        <article class="min-h-[70vh] pb-20 sm:pb-[150px]">
            
            {{-- Tab Ruang Lingkup --}}
            <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($ruangLingkup as $item)
                        <div class="bg-white rounded-4xl shadow-xl overflow-hidden border border-gray-100 flex flex-col group hover:-translate-y-2 transition duration-500">
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

            {{-- Tab Kebijakan & Sasaran Mutu --}}
            <div x-show="tab === 'mutu'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 gap-12">
                    @forelse($kebijakanSasaranMutu as $item)
                        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 group p-8">
                            @if($item->kebijakan)
                                <div class="mb-8 p-6 bg-green-50/50 rounded-2xl border border-green-100">
                                    <h3 class="text-xl font-extrabold text-green-950 tracking-tight mb-4 flex items-center">
                                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Kebijakan
                                    </h3>
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $item->kebijakan }}</p>
                                </div>
                            @endif
                            @if($item->sasaran_mutu)
                                <div class="p-6 bg-blue-50/50 rounded-2xl border border-blue-100">
                                    <h3 class="text-xl font-extrabold text-blue-950 tracking-tight mb-4 flex items-center">
                                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Sasaran Mutu
                                    </h3>
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $item->sasaran_mutu }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data kebijakan dan sasaran mutu belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab Tarif --}}
            <div x-show="tab === 'tarif'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 gap-12">
                    @forelse($tarifHalal as $item)
                        <div class="space-y-12">
                            {{-- PDF Iframe Section --}}
                            @if($item->file_iframe)
                                <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 group">
                                    <div class="p-8 border-b border-gray-100 bg-gray-50/30 flex justify-between items-center">
                                        <h3 class="text-2xl font-extrabold text-green-950 tracking-tight">{{ $item->nama_tarif }} (Tampilan)</h3>
                                        <span class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-widest">Document Viewer</span>
                                    </div>
                                    <div class="p-0 bg-gray-100">
                                        <iframe src="{{ asset('storage/' . $item->file_iframe) }}" class="w-full h-[800px] border-0"></iframe>
                                    </div>
                                </div>
                            @endif

                            {{-- PDF Download Section --}}
                            @if($item->file_download)
                                <div class="bg-white rounded-4xl shadow-xl overflow-hidden border border-gray-100 p-8 hover:bg-green-50/30 transition duration-500">
                                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                                        <div class="flex items-center">
                                            <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mr-6 shadow-sm">
                                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div>
                                                <h4 class="text-xl font-extrabold text-green-950 mb-1">{{ $item->nama_tarif }}</h4>
                                                <p class="text-gray-500 font-medium">Klik tombol di samping untuk mengunduh dokumen lengkap.</p>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/' . $item->file_download) }}" target="_blank" class="flex items-center px-8 py-4 bg-green-600 text-white font-bold rounded-2xl shadow-lg shadow-green-100 hover:bg-green-700 hover:-translate-y-1 transition duration-300 group">
                                            <svg class="w-5 h-5 mr-3 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Unduh PDF Tarif
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-gray-400 font-medium italic text-lg">Data tarif belum tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            {{-- Tab Infrastruktur --}}
            <div x-show="tab === 'infrastruktur'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($infrastruktur as $item)
                        <div class="bg-white rounded-4xl shadow-xl overflow-hidden border border-gray-100 flex flex-col group hover:-translate-y-2 transition duration-500">
                            @if($item->gambar)
                                <div class="h-64 overflow-hidden relative p-4 bg-gray-50">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-700">
                                </div>
                            @endif
                            <div class="p-8">
                                @if($item->nama)
                                    <h3 class="text-xl font-extrabold text-green-950 mb-2 leading-tight">{{ $item->nama }}</h3>
                                    <div class="h-1 w-12 bg-green-500 rounded-full"></div>
                                @else
                                    <h3 class="text-xl font-extrabold text-green-950 mb-2 leading-tight">Infrastruktur LPH</h3>
                                    <div class="h-1 w-12 bg-green-500 rounded-full"></div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-gray-400 font-medium italic text-lg">Data infrastruktur belum tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </article>
    </main>

</body>
</html>
