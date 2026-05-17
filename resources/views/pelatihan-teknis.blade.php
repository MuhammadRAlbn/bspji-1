<x-layouts.app title="Pelatihan Teknis - BSPJI Banda Aceh">
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
                    Pelatihan Teknis
                </h1>
                <p class="mt-4 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                    Program pelatihan dan peningkatan kompetensi sumber daya manusia industri.
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
                <span class="text-base font-semibold sm:text-[1.05rem]">Ruang Lingkup dan Tarif</span>
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
                <span class="text-base font-semibold sm:text-[1.05rem]">Alur</span>
            </button>
        </div>

        <article class="min-h-[85vh] pb-32 sm:pb-[450px]">

            {{-- Tab Ruang Lingkup --}}
            <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex flex-col items-start gap-12">
                    @if($ruangLingkup && $ruangLingkup->image)
                        <button
                            type="button"
                            @click="openLightbox('{{ asset('storage/' . $ruangLingkup->image) }}', 'Ruang Lingkup dan Tarif Pelatihan Teknis')"
                            class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden rounded-2xl border border-slate-200 text-left"
                        >
                            <img
                                src="{{ asset('storage/' . $ruangLingkup->image) }}"
                                alt="Ruang Lingkup dan Tarif Pelatihan Teknis"
                                class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-[1.03]"
                            >
                            <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                    Klik untuk memperbesar
                                </span>
                            </div>
                        </button>
                    @else
                        <div class="w-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data ruang lingkup dan tarif Pelatihan Teknis belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Alur --}}
            <div x-show="tab === 'alur'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="flex flex-col items-start gap-12">
                    @if($alur && $alur->image)
                        <button
                            type="button"
                            @click="openLightbox('{{ asset('storage/' . $alur->image) }}', 'Alur Pelatihan Teknis')"
                            class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden rounded-2xl border border-slate-200 text-left"
                        >
                            <img
                                src="{{ asset('storage/' . $alur->image) }}"
                                alt="Alur Pelatihan Teknis"
                                class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-[1.03]"
                            >
                            <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                    Klik untuk memperbesar
                                </span>
                            </div>
                        </button>
                    @else
                        <div class="w-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data alur Pelatihan Teknis belum tersedia.</p>
                        </div>
                    @endif
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
