<x-layouts.app title="Sertifikasi Produk - BSPJI Pekanbaru">
<div x-data="{
    tab: 'sertifikat',
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

        <article class="min-h-[85vh] pb-32 sm:pb-[450px]">
            <div class="grid grid-cols-1 items-start">
            
                <section x-show="tab === 'alur'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="mx-auto max-w-6xl space-y-6">
                    @if($alurProduk && $alurProduk->image)
                        <div class="flex justify-center">
                            <button
                                type="button"
                                @click="openLightbox('{{ asset('storage/' . $alurProduk->image) }}', 'Alur Sertifikasi Produk')"
                                class="group relative block w-full max-w-4xl cursor-pointer overflow-hidden rounded-[30px] border border-black/15 bg-slate-50 text-left shadow-xl transition-all duration-500 hover:shadow-2xl"
                            >
                                <img
                                    src="{{ asset('storage/' . $alurProduk->image) }}"
                                    alt="Alur Sertifikasi"
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
                            <p class="font-medium text-slate-400">Data alur sertifikasi belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </section>

                <section x-show="tab === 'sertifikat'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="mx-auto max-w-6xl space-y-8">
                    @if($sertifikats->isNotEmpty())
                        <div class="flex flex-wrap justify-center gap-8">
                            @foreach($sertifikats as $sert)
                                <button
                                    type="button"
                                    @click="openLightbox('{{ asset('storage/' . $sert->image) }}', 'Sertifikat Akreditasi')"
                                    class="group relative block aspect-square w-full max-w-[380px] cursor-pointer overflow-hidden rounded-[24px] border border-black/10 bg-slate-50 text-left shadow-sm transition-all hover:shadow-md"
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
                <div class="mx-auto max-w-6xl">
                    <div class="flex flex-wrap justify-center gap-8">
                    @forelse($ruangLingkup as $item)
                        @if($item->image)
                            <button
                                type="button"
                                @click="openLightbox('{{ asset('storage/' . $item->image) }}', 'Ruang Lingkup')"
                                class="group relative block w-full max-w-[380px] cursor-pointer overflow-hidden rounded-[24px] border border-black/10 bg-slate-50 text-left shadow-sm transition-all hover:shadow-md"
                            >
                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    alt="Ruang Lingkup"
                                    class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-110"
                                >
                                <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                        Klik untuk memperbesar
                                    </span>
                                </div>
                            </button>
                        @endif
                    @empty
                        <div class="col-span-full rounded-[30px] border border-dashed border-black/15 bg-[#fbfbfd] px-6 py-20 text-center">
                            <p class="font-medium text-slate-400">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </section>

                <section x-show="tab === 'dokumen'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="overflow-hidden rounded-2xl border border-black/20 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead>
                                <tr class="border-b border-black/20 bg-slate-50">
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-800">No</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-800">Nama Dokumen</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-800">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black/10">
                                @forelse($dokumens as $index => $dokumen)
                                    <tr class="transition-colors hover:bg-slate-50/50">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-500">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                                            {{ $dokumen->nama_dokumen }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('dokumen-produk.download', $dokumen) }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-800 px-4 py-2 text-xs font-bold text-white transition-all active:scale-95">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-16 text-center">
                                            <p class="font-medium text-slate-400">Belum ada dokumen yang tersedia saat ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

                <section x-show="tab === 'hak-kewajiban'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="overflow-hidden rounded-2xl border border-black/20 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead>
                                <tr class="border-b border-black/20 bg-slate-50">
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-800">No</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-800">Nama Dokumen</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-800">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black/10">
                                @forelse($hakKewajibans as $index => $hak)
                                    <tr class="transition-colors hover:bg-slate-50/50">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-500">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                                            {{ $hak->nama_dokumen }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('hak-kewajiban-produk.download', $hak) }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-800 px-4 py-2 text-xs font-bold text-white transition-all active:scale-95">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-16 text-center">
                                            <p class="font-medium text-slate-400">Belum ada dokumen hak dan kewajiban yang tersedia saat ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

                <section x-show="tab === 'tarif'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="space-y-12">
                    @forelse($tarifs as $tarif)
                        <div class="space-y-4">
                            <h3 class="border-l-4 border-slate-800 px-4 text-lg font-bold text-slate-800">{{ $tarif->nama_dokumen }}</h3>
                            <div class="aspect-3/4 overflow-hidden rounded-2xl border border-black/10 bg-[#fbfbfd] shadow-inner md:aspect-video">
                                <iframe
                                    src="{{ asset('storage/' . $tarif->file_path) }}"
                                    class="h-full w-full border-none"
                                    title="{{ $tarif->nama_dokumen }}"
                                >
                                    Browser Anda tidak mendukung iframe. Silakan download dokumen.
                                </iframe>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-[30px] border border-dashed border-black/15 bg-[#fbfbfd] px-6 py-20 text-center">
                            <p class="font-medium text-slate-400">Informasi tarif belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </section>

                <section x-show="tab === 'sdm'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="mx-auto max-w-6xl space-y-10">
                    <p class="max-w-3xl text-sm leading-relaxed text-slate-600 md:text-base">
                        Auditor Sertifikasi Produk yang kompeten dan berpengalaman untuk menjamin kualitas layanan.
                    </p>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        {{-- Card Ahli Madya --}}
                        <div class="group relative flex flex-col items-center gap-6 overflow-hidden rounded-[30px] border border-black/10 bg-white p-8 text-center shadow-sm transition-all duration-500 hover:shadow-md">
                            <div class="absolute top-0 left-0 h-1.5 w-full bg-slate-800"></div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-black text-slate-800">{{ $countAhliMadya }}</span>
                                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Auditor</span>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-xl font-black tracking-tight text-slate-800">AMMI</h3>
                                <p class="text-sm font-bold uppercase tracking-widest text-slate-500">Ahli Madya</p>
                            </div>
                        </div>

                        {{-- Card Ahli Muda --}}
                        <div class="group relative flex flex-col items-center gap-6 overflow-hidden rounded-[30px] border border-black/10 bg-white p-8 text-center shadow-sm transition-all duration-500 hover:shadow-md">
                            <div class="absolute top-0 left-0 h-1.5 w-full bg-slate-400"></div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-black text-slate-800">{{ $countAhliMuda }}</span>
                                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Auditor</span>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-xl font-black tracking-tight text-slate-800">AMMI</h3>
                                <p class="text-sm font-bold uppercase tracking-widest text-slate-500">Ahli Muda</p>
                            </div>
                        </div>

                        {{-- Card Ahli Pertama --}}
                        <div class="group relative flex flex-col items-center gap-6 overflow-hidden rounded-[30px] border border-black/10 bg-white p-8 text-center shadow-sm transition-all duration-500 hover:shadow-md">
                            <div class="absolute top-0 left-0 h-1.5 w-full bg-slate-200"></div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-black text-slate-800">{{ $countAhliPertama }}</span>
                                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Auditor</span>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-xl font-black tracking-tight text-slate-800">AMMI</h3>
                                <p class="text-sm font-bold uppercase tracking-widest text-slate-500">Ahli Pertama</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

                <section x-show="tab === 'informasi-publik'" x-transition.opacity.duration.500ms class="col-start-1 row-start-1">
                <div class="mx-auto max-w-6xl overflow-hidden rounded-2xl border border-black/20 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead>
                                <tr class="border-b border-black/20 bg-slate-50">
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-800">No</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-800">Nama Informasi</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-800">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black/10">
                                @forelse($informasiPubliks as $index => $informasi)
                                    <tr class="transition-colors hover:bg-slate-50/50">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-500">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                                            {{ $informasi->nama }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('informasi-publik-produk.download', $informasi) }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-800 px-4 py-2 text-xs font-bold text-white transition-all active:scale-95">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-16 text-center">
                                            <p class="font-medium text-slate-400">Belum ada informasi publik yang tersedia saat ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
