<x-layouts.app title="Lembaga Pemeriksa Halal - BSPJI Banda Aceh">
<div x-data="{
    tab: 'ruang-lingkup',
    lightboxOpen: false,
    lightboxImage: '',
    lightboxAlt: '',
    openLightbox(image, alt) {
        this.lightboxImage = image;
        this.lightboxAlt = alt;
        this.lightboxOpen = true;
    },
    closeLightbox() {
        this.lightboxOpen = false;
    }
}" x-effect="document.body.classList.toggle('overflow-hidden', lightboxOpen)">
    <div class="mx-auto mt-4 mb-8 w-full max-w-7xl px-6 sm:mt-6 sm:mb-12 lg:mt-8 lg:px-8">
        <header class="relative w-full overflow-hidden rounded-[2rem] border border-slate-200 bg-white py-10 shadow-md lg:py-12">
            <div class="px-6 text-left lg:px-10">
                <div class="mb-3 flex items-center gap-2">
                    <span class="text-[10px] text-blue-600">■</span>
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-slate-500">Layanan Jasa</span>
                </div>
                <h1 class="text-3xl font-light tracking-tight text-slate-900 sm:text-4xl lg:text-[3rem] lg:leading-[1.1]">
                    Lembaga Pemeriksa Halal (LPH)
                </h1>
                <p class="mt-4 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                    Layanan pemeriksaan produk untuk memastikan kehalalan sesuai standar yang ditetapkan.
                </p>
            </div>
        </header>
    </div>

    <main class="mx-auto grid max-w-7xl grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1">
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

        <article class="min-h-[85vh] pb-32 sm:pb-[450px]">

            {{-- Tab Ruang Lingkup --}}
            <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex flex-col justify-start gap-8">
                    @forelse($ruangLingkup as $item)
                        @if($item->gambar)
                            <button
                                type="button"
                                @click="openLightbox('{{ asset('storage/' . $item->gambar) }}', '{{ $item->nama }}')"
                                class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden rounded-2xl border border-slate-200 text-left"
                            >
                                <img
                                    src="{{ asset('storage/' . $item->gambar) }}"
                                    alt="{{ $item->nama }}"
                                    class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-[1.03]"
                                >
                                <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                        Klik untuk memperbesar
                                    </span>
                                </div>
                            </button>
                        @endif
                    @empty
                        <div class="w-full col-span-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab SDM --}}
            <div x-show="tab === 'sdm'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    {{-- Auditor Halal --}}
                    <div class="group/card relative bg-white rounded-2xl border border-slate-100 p-6 shadow-sm transition-all duration-300 hover:shadow-md">
                        <!-- Top Accent line (same as slate-800 tab color) -->
                        <div class="absolute top-0 inset-x-0 h-1 bg-slate-800 rounded-t-2xl"></div>
                        
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center mr-4 text-slate-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <h2 class="text-xl font-bold text-slate-800">Auditor Halal</h2>
                                <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold">Tim Ahli Pemeriksa</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @forelse($sdmAuditor as $sdm)
                                <div class="group/item flex items-center justify-between p-4 bg-slate-50/50 rounded-xl border border-slate-100/80 hover:bg-slate-100/60 hover:border-slate-200/50 transition-all duration-300">
                                    <div class="flex items-center">
                                        <!-- First letter avatar (slate-800 matching tab) -->
                                        <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center mr-4 text-white font-bold text-base shadow-sm">
                                            {{ substr($sdm->nama, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col text-left">
                                            <span class="text-base font-semibold text-slate-800 transition-colors group-hover/item:text-slate-900">{{ $sdm->nama }}</span>
                                            <span class="text-[10px] uppercase tracking-widest text-slate-400 font-semibold">Halal Auditor</span>
                                        </div>
                                    </div>
                                    <span class="text-slate-600 opacity-0 group-hover/item:opacity-100 transition-opacity duration-300 mr-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                        </svg>
                                    </span>
                                </div>
                            @empty
                                <div class="p-8 text-center bg-slate-50/50 rounded-xl border border-slate-100/50">
                                    <p class="text-slate-400 font-medium italic text-sm">Data auditor halal belum tersedia.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Dewan Pembina Syariah --}}
                    <div class="group/card relative bg-white rounded-2xl border border-slate-100 p-6 shadow-sm transition-all duration-300 hover:shadow-md">
                        <!-- Top Accent line (same as slate-800 tab color) -->
                        <div class="absolute top-0 inset-x-0 h-1 bg-slate-800 rounded-t-2xl"></div>
                        
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center mr-4 text-slate-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <h2 class="text-xl font-bold text-slate-800">Dewan Pembina Syariah</h2>
                                <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold">Pengawas Aspek Syariah</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @forelse($sdmPembina as $sdm)
                                <div class="group/item flex items-center justify-between p-4 bg-slate-50/50 rounded-xl border border-slate-100/80 hover:bg-slate-100/60 hover:border-slate-200/50 transition-all duration-300">
                                    <div class="flex items-center">
                                        <!-- First letter avatar (slate-800 matching tab) -->
                                        <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center mr-4 text-white font-bold text-base shadow-sm">
                                            {{ substr($sdm->nama, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col text-left">
                                            <span class="text-base font-semibold text-slate-800 transition-colors group-hover/item:text-slate-900">{{ $sdm->nama }}</span>
                                            <span class="text-[10px] uppercase tracking-widest text-slate-400 font-semibold">Dewan Pengawas</span>
                                        </div>
                                    </div>
                                    <span class="text-slate-600 opacity-0 group-hover/item:opacity-100 transition-opacity duration-300 mr-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                        </svg>
                                    </span>
                                </div>
                            @empty
                                <div class="p-8 text-center bg-slate-50/50 rounded-xl border border-slate-100/50">
                                    <p class="text-slate-400 font-medium italic text-sm">Data dewan pembina syariah belum tersedia.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Alur & Kelengkapan --}}
            <div x-show="tab === 'alur'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="flex flex-col justify-start gap-12">
                    @forelse($alurKelengkapan as $item)
                        @if($item->gambar)
                            <button
                                type="button"
                                @click="openLightbox('{{ asset('storage/' . $item->gambar) }}', '{{ $item->nama ?? 'Alur & Kelengkapan' }}')"
                                class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden rounded-2xl border border-slate-200 text-left"
                            >
                                <img
                                    src="{{ asset('storage/' . $item->gambar) }}"
                                    alt="{{ $item->nama ?? 'Alur & Kelengkapan' }}"
                                    class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-[1.03]"
                                >
                                <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                        Klik untuk memperbesar
                                    </span>
                                </div>
                            </button>
                        @endif
                    @empty
                        <div class="w-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data alur dan kelengkapan belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab Struktur, Visi & Misi --}}
            <div x-show="tab === 'struktur'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="flex flex-col justify-start gap-12">
                    @forelse($strukturVisiMisi as $item)
                        @if($item->gambar)
                            <button
                                type="button"
                                @click="openLightbox('{{ asset('storage/' . $item->gambar) }}', '{{ $item->nama ?? 'Struktur, Visi & Misi' }}')"
                                class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden rounded-2xl border border-slate-200 text-left"
                            >
                                <img
                                    src="{{ asset('storage/' . $item->gambar) }}"
                                    alt="{{ $item->nama ?? 'Struktur, Visi & Misi' }}"
                                    class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-[1.03]"
                                >
                                <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                        Klik untuk memperbesar
                                    </span>
                                </div>
                            </button>
                        @endif
                    @empty
                        <div class="w-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
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
                        <div class="space-y-8 text-left">
                            {{-- Main Heading at the absolute top --}}
                            <h3 class="text-lg font-bold text-slate-700 tracking-tight">TARIF LEMBAGA PEMERIKSA HALAL - BSPJI BANDA ACEH</h3>

                            {{-- PDF Download Section --}}
                            @if($item->file_download)
                                <div class="bg-white rounded-3xl shadow-md overflow-hidden border border-slate-200 p-6 hover:bg-slate-50/30 hover:border-slate-300 transition duration-500">
                                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-red-50 border border-red-100 rounded-xl flex items-center justify-center mr-4 shadow-sm text-red-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div>
                                                <h4 class="text-base font-bold text-slate-700 mb-1">Unduh Dokumen Lengkap</h4>
                                                <p class="text-xs text-slate-400 font-medium">Klik tombol di samping untuk mengunduh dokumen lengkap.</p>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/' . $item->file_download) }}" target="_blank" class="flex items-center px-6 py-3 bg-slate-800 text-white text-sm font-semibold rounded-xl shadow-md hover:bg-slate-900 hover:-translate-y-0.5 transition duration-300 group">
                                            <svg class="w-4 h-4 mr-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Unduh PDF Tarif
                                        </a>
                                    </div>
                                </div>
                            @endif

                            {{-- PDF Iframe Section --}}
                            @if($item->file_iframe)
                                <div class="w-full overflow-hidden rounded-2xl border border-slate-200 shadow-sm bg-slate-100">
                                    <iframe src="{{ asset('storage/' . $item->file_iframe) }}" class="w-full h-[800px] border-0"></iframe>
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
                <div class="flex flex-col justify-start gap-8">
                    @forelse($infrastruktur as $item)
                        @if($item->gambar)
                            <button
                                type="button"
                                @click="openLightbox('{{ asset('storage/' . $item->gambar) }}', '{{ $item->nama ?? 'Infrastruktur LPH' }}')"
                                class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden text-left"
                            >
                                <img
                                    src="{{ asset('storage/' . $item->gambar) }}"
                                    alt="{{ $item->nama ?? 'Infrastruktur LPH' }}"
                                    class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-[1.03]"
                                >
                                <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                        Klik untuk memperbesar
                                    </span>
                                </div>
                            </button>
                        @endif
                    @empty
                        <div class="w-full col-span-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
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
    <div
        x-show="lightboxOpen"
        x-transition.opacity.duration.300ms
        @click="closeLightbox()"
        @keydown.escape.window="closeLightbox()"
        class="fixed inset-0 z-100 flex items-center justify-center bg-black/90 p-4 backdrop-blur-sm md:p-10"
        style="display: none;"
    >
        <button
            type="button"
            @click.stop="closeLightbox()"
            class="absolute top-6 right-6 z-110 text-white transition-colors hover:text-gray-300"
            aria-label="Tutup lightbox"
        >
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <img
            :src="lightboxImage"
            :alt="lightboxAlt"
            @click.stop
            class="max-h-full max-w-full rounded-lg shadow-2xl"
        >
    </div>
</div>
</x-layouts.app>
