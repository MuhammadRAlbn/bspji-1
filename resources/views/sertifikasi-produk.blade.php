<x-layouts.app title="Sertifikasi Produk - BSPJI Pekanbaru">
<div x-data="{ tab: 'sertifikat' }">
    <header class="relative mb-8 flex h-[300px] w-full items-center overflow-hidden text-white sm:mx-auto sm:mt-5 sm:mb-10 sm:h-[360px] sm:w-[96%] sm:rounded-[25px] md:mt-5 md:h-[400px]">
        <img
            src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?auto=format&fit=crop&q=80&w=2070"
            alt="Sertifikasi Produk"
            class="absolute inset-0 -z-10 h-full w-full object-cover brightness-[0.7]"
        >
        <div class="mx-auto w-full max-w-[1400px] px-5 text-left sm:px-8 md:px-20">
            <h1 class="text-[2.25rem] font-bold tracking-[-0.03em] sm:text-[3rem] md:text-[4.5rem]">
                Sertifikasi Produk (LSPro)
            </h1>
        </div>
    </header>

    <div class="mx-auto grid max-w-[1400px] grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1">
            <button
                type="button"
                @click="tab = 'alur'"
                :class="tab === 'alur' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'alur' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 15.75 19.5 19.5m0 0-3.75 3.75M19.5 19.5H9A6.75 6.75 0 0 1 2.25 12.75V10.5A6.75 6.75 0 0 1 9 3.75h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Alur</span>
            </button>

            <button
                type="button"
                @click="tab = 'sertifikat'"
                :class="tab === 'sertifikat' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'sertifikat' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75m5.25 2.814c0 4.285-2.924 8.032-7.087 9.063a1.38 1.38 0 0 1-.326.037 1.38 1.38 0 0 1-.326-.037C8.348 20.596 5.424 16.85 5.424 12.564V7.902c0-.67.423-1.267 1.056-1.491l5.25-1.867a1.37 1.37 0 0 1 .913 0l5.25 1.867c.633.224 1.056.82 1.056 1.49v4.663Z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Sertifikat</span>
            </button>

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
                @click="tab = 'dokumen'"
                :class="tab === 'dokumen' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'dokumen' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Dokumen</span>
            </button>

            <button
                type="button"
                @click="tab = 'hak-kewajiban'"
                :class="tab === 'hak-kewajiban' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'hak-kewajiban' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Hak & Kewajiban</span>
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
                @click="tab = 'sdm'"
                :class="tab === 'sdm' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'sdm' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">SDM</span>
            </button>

            <button
                type="button"
                @click="tab = 'informasi-publik'"
                :class="tab === 'informasi-publik' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'informasi-publik' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Informasi Publik</span>
            </button>
        </div>

        <article class="min-h-[70vh] pb-20 sm:pb-[150px]">
            
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
                        <div class="bg-white rounded-4xl shadow-xl overflow-hidden border border-gray-100 flex flex-col group hover:-translate-y-2 transition duration-500">
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

            {{-- Tab Hak & Kewajiban --}}
            <div x-show="tab === 'hak-kewajiban'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-green-950 uppercase tracking-tight">Hak dan Kewajiban Pelanggan</h2>
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
                                @forelse($hakKewajibans as $index => $hak)
                                    <tr class="bg-gray-50/50 hover:bg-emerald-50 transition duration-300 group rounded-2xl shadow-sm">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-400 w-16 rounded-l-2xl border-y border-l border-gray-100">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-green-950 border-y border-gray-100">
                                            {{ $hak->nama_dokumen }}
                                        </td>
                                        <td class="px-6 py-4 text-right rounded-r-2xl border-y border-r border-gray-100">
                                            <a href="{{ route('hak-kewajiban-produk.download', $hak) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 transition duration-300 group">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-400 font-medium italic bg-gray-50/50 rounded-2xl border-2 border-dashed border-gray-200">
                                            Belum ada dokumen hak dan kewajiban yang tersedia saat ini.
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
                                <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-inner bg-gray-50 aspect-3/4 md:aspect-video">
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
                        <div class="group relative bg-linear-to-br from-indigo-600 to-blue-700 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-100/50 hover:shadow-indigo-200/50 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
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
                        <div class="group relative bg-linear-to-br from-amber-500 to-orange-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-amber-100/50 hover:shadow-amber-200/50 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
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
                        <div class="group relative bg-linear-to-br from-emerald-500 to-teal-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-emerald-100/50 hover:shadow-emerald-200/50 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
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
        </article>
    </div>
</div>
</x-layouts.app>
