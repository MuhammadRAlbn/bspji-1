<x-layouts.app title="Konsultasi dan Pendampingan - BSPJI Pekanbaru">
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
        <header class="relative w-full overflow-hidden rounded-[2rem] border border-slate-200 py-10 shadow-md lg:py-12">
            <!-- Abstract Background Image (Aligned to Right) -->
            <img
                src="{{ asset('images/bgabstrak2.webp') }}"
                alt=""
                class="absolute inset-0 -z-10 h-full w-full object-cover object-right"
            >
            <!-- Very subtle overlay just for contrast if needed -->
            <div class="absolute inset-0 -z-10 bg-white/20"></div>

            <div class="px-6 text-left lg:px-10">
                <div class="mb-3 flex items-center gap-2">
                    <span class="text-[10px] text-blue-600">■</span>
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-slate-500">Layanan Jasa</span>
                </div>
                <h1 class="text-3xl font-light tracking-tight text-slate-900 sm:text-4xl md:text-5xl lg:text-[3.5rem] lg:leading-[1.1]">
                    Konsultasi dan Pendampingan
                </h1>
                <p class="mt-4 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                    Layanan konsultasi dan pendampingan bagi industri untuk meningkatkan kualitas dan daya saing.
                </p>
            </div>
        </header>
    </div>

    <div class="mx-auto grid max-w-7xl grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
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
                @click="tab = 'alur'"
                :class="tab === 'alur' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'alur' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 15.75 19.5 19.5m0 0-3.75 3.75M19.5 19.5H9A6.75 6.75 0 0 1 2.25 12.75V10.5A6.75 6.75 0 0 1 9 3.75h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Alur Proses</span>
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
                <span class="text-base font-semibold sm:text-[1.05rem]">Tarif Layanan</span>
            </button>
        </div>

        <article class="min-h-[85vh] pb-32 sm:pb-[450px]">
            <div class="mt-8 transition-all duration-500">
                <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="space-y-12">
                        @if($ruangLingkupParagraf)
                            <div class="bg-white rounded-[2.5rem] shadow-xl p-10 border border-slate-100 relative overflow-hidden group">
                                <div class="absolute top-0 left-0 w-2 h-full bg-blue-500"></div>
                            <div class="text-slate-700 text-lg leading-relaxed font-medium space-y-4">
                                {!! $ruangLingkupParagraf->content !!}
                            </div>
                            </div>
                        @else
                             <div class="bg-white rounded-[2.5rem] shadow-xl p-16 text-center border border-slate-100">
                                <p class="text-slate-400 font-medium italic">Informasi ruang lingkup belum tersedia.</p>
                            </div>
                        @endif

                        @if($ruangLingkupImages->count() > 0)
                            <div class="flex flex-col justify-start gap-8">
                                @foreach($ruangLingkupImages as $item)
                                    <button
                                        type="button"
                                        @click="openLightbox('{{ asset('storage/' . $item->image) }}', 'Ruang Lingkup')"
                                        class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden text-left"
                                    >
                                        <img
                                            src="{{ asset('storage/' . $item->image) }}"
                                            alt="Gambar Ruang Lingkup"
                                            class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-[1.03]"
                                        >
                                        <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                            <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                                Klik untuk memperbesar
                                            </span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div x-show="tab === 'alur'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;">
                    <div class="flex flex-col justify-start gap-12">
                        @forelse($alur as $item)
                            <button
                                type="button"
                                @click="openLightbox('{{ asset('storage/' . $item->image) }}', 'Alur Proses')"
                                class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden text-left"
                            >
                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    alt="Alur Proses"
                                    class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-[1.03]"
                                >
                                <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                        Klik untuk memperbesar
                                    </span>
                                </div>
                            </button>
                        @empty
                            <div class="w-full bg-white rounded-[2.5rem] shadow-xl p-24 text-center border border-slate-100">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                <p class="text-slate-400 font-medium italic text-lg">Informasi alur proses belum tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div x-show="tab === 'tarif'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;">
                    <div class="grid grid-cols-1 gap-12">
                        @if($tarif && $tarif->file_pdf)
                            <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100 group mb-8">
                                <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                                    <h3 class="text-xl font-bold text-slate-900 px-4">Dokumen Tarif Resmi</h3>
                                    <a href="{{ asset('storage/' . $tarif->file_pdf) }}" target="_blank" class="flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-bold rounded-xl shadow-lg hover:bg-blue-700 transition duration-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Unduh PDF
                                    </a>
                                </div>
                                <div class="bg-slate-800">
                                    <iframe src="{{ asset('storage/' . $tarif->file_pdf) }}" class="w-full h-[800px] border-0"></iframe>
                                </div>
                            </div>
                        @else
                            <div class="bg-white rounded-[2.5rem] shadow-xl p-24 text-center border border-slate-100">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-medium italic text-lg">Informasi tarif belum tersedia saat ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </article>
    </div>
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
