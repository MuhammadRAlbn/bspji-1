<x-layouts.app title="Layanan Kalibrasi" bodyClass="bg-slate-100/90">
<div x-data="{
    tab: 'sertifikasi',
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
        <header class="relative w-full overflow-hidden rounded-4xl border border-slate-300 bg-white py-10 shadow-md lg:py-12">
            <div class="px-6 text-left lg:px-10">
                <div class="mb-3 flex items-center gap-2">
                    <span class="text-[10px] text-blue-600">■</span>
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-slate-500">Layanan Jasa</span>
                </div>
                <h1 class="text-3xl font-light tracking-tight text-slate-900 sm:text-4xl lg:text-[3rem] lg:leading-[1.1]">
                    Layanan Kalibrasi
                </h1>
                <p class="mt-4 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                    Menjamin keakuratan alat ukur Anda dengan standar nasional maupun internasional yang tertelusur.
                </p>
            </div>
        </header>
    </div>

    <div class="mx-auto grid max-w-7xl grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1">
            <button
                type="button"
                @click="tab = 'sertifikasi'"
                :class="tab === 'sertifikasi' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'sertifikasi' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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
                <span class="text-base font-semibold sm:text-[1.05rem]">Ruang Lingkup dan Tarif</span>
            </button>

            <button
                type="button"
                @click="tab = 'alur-kalibrasi'"
                :class="tab === 'alur-kalibrasi' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'alur-kalibrasi' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 15.75 19.5 19.5m0 0-3.75 3.75M19.5 19.5H9A6.75 6.75 0 0 1 2.25 12.75V10.5A6.75 6.75 0 0 1 9 3.75h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Alur</span>
            </button>


        </div>

        <article class="min-h-[85vh] pb-32 sm:pb-[450px]">
            <div class="grid grid-cols-1 items-start">
            
                <section x-show="tab === 'sertifikasi'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="mx-auto max-w-5xl space-y-8">
                    @if($sertifikasis->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                            @foreach($sertifikasis as $sert)
                                <button
                                    type="button"
                                    @click="openLightbox('{{ asset('storage/' . $sert->image) }}', 'Sertifikat Akreditasi')"
                                    class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden border border-slate-200 text-left"
                                >
                                    <img
                                        src="{{ asset('storage/' . $sert->image) }}"
                                        alt="Sertifikat Akreditasi"
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
                    @else
                        <div class="rounded-[30px] border border-dashed border-black/15 bg-[#fbfbfd] px-6 py-20 text-center">
                            <p class="font-medium text-slate-400">Gambar sertifikat belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </section>

                <section x-show="tab === 'ruang-lingkup'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="mx-auto max-w-5xl">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($ruangLingkupan as $item)
                        <div class="group flex flex-col rounded-[20px] border border-slate-200 bg-white p-2 shadow-sm transition-all duration-500 hover:shadow-lg hover:shadow-slate-200/50">
                            @if($item->image)
                                <div class="relative aspect-[4/3] w-full overflow-hidden rounded-xl">
                                    <div class="absolute inset-0 z-10 bg-slate-900/5 transition duration-500 group-hover:bg-transparent"></div>
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                </div>
                            @endif
                            <div class="flex grow flex-col px-5 py-6 md:px-6">
                                <span class="mb-5 self-start text-[13px] font-bold text-slate-500">{{ $item->title }}</span>
                                <div class="space-y-8">
                                    @foreach($item->details ?? [] as $detail)
                                        <div class="flex flex-col gap-4">
                                            <h4 class="text-[1.35rem] font-bold leading-snug text-slate-900">{{ is_array($detail) ? ($detail['name'] ?? '-') : $detail }}</h4>
                                            @if(is_array($detail) && isset($detail['price']) && $detail['price'] > 0)
                                                <div class="flex items-center gap-3">
                                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-[8px] bg-[#0f172a] text-white shadow-sm transition-transform group-hover:scale-105">
                                                        <svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                                    </div>
                                                    <span class="text-[13px] font-semibold text-slate-700">Rp {{ number_format($detail['price'], 0, ',', '.') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full rounded-[30px] border border-dashed border-black/15 bg-[#fbfbfd] px-6 py-20 text-center">
                            <p class="font-medium text-slate-400">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </section>

                <section x-show="tab === 'alur-kalibrasi'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="mx-auto max-w-5xl space-y-6 text-center">
                    @if($alurKalibrasi && $alurKalibrasi->image)
                        <button
                            type="button"
                            @click="openLightbox('{{ asset('storage/' . $alurKalibrasi->image) }}', 'Alur Pelayanan Kalibrasi')"
                            class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden border border-slate-200 text-left"
                        >
                                <img
                                    src="{{ asset('storage/' . $alurKalibrasi->image) }}"
                                    alt="Alur Pelayanan Kalibrasi"
                                    class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-[1.03]"
                                >
                            <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                    Klik untuk memperbesar
                                </span>
                            </div>
                        </button>
                    @else
                        <div class="rounded-[30px] border border-dashed border-black/15 bg-[#fbfbfd] px-6 py-20 text-center">
                            <p class="font-medium text-slate-400">Gambar alur layanan belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </section>


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
