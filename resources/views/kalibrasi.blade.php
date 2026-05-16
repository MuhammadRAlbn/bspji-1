<x-layouts.app title="Layanan Kalibrasi">
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
    <header class="relative mb-8 flex h-[300px] w-full items-center overflow-hidden text-white sm:mx-auto sm:mt-5 sm:mb-10 sm:h-[360px] sm:w-[96%] sm:rounded-[25px] md:mt-5 md:h-[400px]">
        <img
            src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80&w=2070"
            alt="Layanan Kalibrasi"
            class="absolute inset-0 -z-10 h-full w-full object-cover brightness-[0.7]"
        >
        <div class="mx-auto w-full max-w-[1400px] px-5 text-left sm:px-8 md:px-20">
            <h1 class="text-[2.25rem] font-bold tracking-[-0.03em] sm:text-[3rem] md:text-[4.5rem]">
                Layanan Kalibrasi
            </h1>
        </div>
    </header>

    <div class="mx-auto grid max-w-[1400px] grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
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
                <span class="text-base font-semibold sm:text-[1.05rem]">Sertifikasi</span>
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
                @click="tab = 'alur-kalibrasi'"
                :class="tab === 'alur-kalibrasi' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'alur-kalibrasi' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 15.75 19.5 19.5m0 0-3.75 3.75M19.5 19.5H9A6.75 6.75 0 0 1 2.25 12.75V10.5A6.75 6.75 0 0 1 9 3.75h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Alur</span>
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
        </div>

        <article class="min-h-[85vh] pb-32 sm:pb-[450px]">
            <div class="grid grid-cols-1 items-start">
            
                <section x-show="tab === 'sertifikasi'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="mx-auto max-w-5xl space-y-8">
                    @if($sertifikasis->isNotEmpty())
                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($sertifikasis as $sert)
                                <button
                                    type="button"
                                    @click="openLightbox('{{ asset('storage/' . $sert->image) }}', 'Sertifikat Akreditasi')"
                                    class="group relative block aspect-square w-full cursor-pointer overflow-hidden rounded-[24px] border border-black/10 bg-slate-50 text-left shadow-sm transition-all hover:shadow-md"
                                >
                                    <img
                                        src="{{ asset('storage/' . $sert->image) }}"
                                        alt="Sertifikat Akreditasi"
                                        class="h-full w-full object-contain transition-transform duration-700 group-hover:scale-105"
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
                        <div class="group flex flex-col overflow-hidden rounded-[24px] border border-black/10 bg-white shadow-sm transition-all duration-500 hover:shadow-md">
                            @if($item->image)
                                <div class="relative aspect-square overflow-hidden">
                                    <div class="absolute inset-0 z-10 bg-slate-900/5 transition duration-500 group-hover:bg-transparent"></div>
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                                </div>
                            @endif
                            <div class="grow p-6">
                                <span class="mb-3 inline-block rounded-full bg-slate-50 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-slate-500">Scope</span>
                                <h3 class="mb-6 text-xl font-bold leading-tight text-slate-800">{{ $item->title }}</h3>
                                <ul class="space-y-3">
                                    @foreach($item->details ?? [] as $detail)
                                        <li class="flex items-start">
                                            <div class="mt-1 mr-3 rounded-full bg-emerald-50 p-1">
                                                <svg class="h-3 w-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <span class="text-sm font-medium leading-relaxed text-slate-600">{{ is_array($detail) ? ($detail['name'] ?? '-') : $detail }}</span>
                                        </li>
                                    @endforeach
                                </ul>
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
                            class="group relative mx-auto block aspect-square w-full max-w-[400px] cursor-pointer overflow-hidden rounded-[30px] border border-black/15 bg-slate-50 text-left shadow-xl transition-all duration-500 hover:shadow-2xl"
                        >
                                <img
                                    src="{{ asset('storage/' . $alurKalibrasi->image) }}"
                                    alt="Alur Pelayanan Kalibrasi"
                                    class="h-full w-full object-contain transition-transform duration-700 group-hover:scale-[1.01]"
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

                <section x-show="tab === 'tarif'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="mx-auto max-w-5xl">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($ruangLingkupan as $item)
                        <div class="group flex flex-col overflow-hidden rounded-[24px] border border-black/10 bg-white shadow-sm transition-all duration-500 hover:shadow-md">
                            @if($item->image)
                                <div class="relative h-32 overflow-hidden">
                                    <div class="absolute inset-0 z-10 bg-slate-900/40"></div>
                                    <img src="{{ asset('storage/' . $item->image) }}" class="h-full w-full object-cover opacity-60 blur-[1px]">
                                    <div class="absolute inset-0 z-20 flex items-center justify-center">
                                        <h4 class="px-4 text-center text-sm font-bold uppercase tracking-wide text-white">{{ $item->title }}</h4>
                                    </div>
                                </div>
                            @endif
                            <div class="grow bg-white p-6">
                                <div class="space-y-3">
                                    @foreach($item->details ?? [] as $detail)
                                        @if(is_array($detail))
                                            <div class="flex items-center justify-between rounded-xl border border-black/5 bg-slate-50 p-4 transition duration-200 hover:bg-white hover:shadow-sm">
                                                <span class="pr-3 text-xs font-bold leading-snug text-slate-700">{{ $detail['name'] ?? '-' }}</span>
                                                <span class="whitespace-nowrap rounded-lg border border-black/5 bg-white px-3 py-1.5 text-sm font-bold text-slate-800 shadow-sm">Rp {{ number_format($detail['price'] ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full rounded-[30px] border border-dashed border-black/15 bg-[#fbfbfd] px-6 py-20 text-center">
                            <p class="font-medium text-slate-400">Data daftar tarif belum tersedia.</p>
                        </div>
                    @endforelse
                    </div>
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
