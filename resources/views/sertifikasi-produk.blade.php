<x-layouts.app title="Sertifikasi Produk - BSPJI Pekanbaru" bodyClass="bg-slate-100/90">
<div x-data="{
    tab: @js($activeTab),
    lightboxOpen: false,
    lightboxImage: '',
    lightboxAlt: '',
    customerDetailOpen: false,
    selectedCustomer: null,
    openLightbox(image, alt) {
        this.lightboxImage = image;
        this.lightboxAlt = alt;
        this.lightboxOpen = true;
    },
    closeLightbox() {
        this.lightboxOpen = false;
    },
    openCustomerDetail(customer) {
        this.selectedCustomer = customer;
        this.customerDetailOpen = true;
    },
    closeCustomerDetail() {
        this.customerDetailOpen = false;
    }
}" x-effect="document.body.classList.toggle('overflow-hidden', lightboxOpen || customerDetailOpen)">
    <div class="mx-auto mt-4 mb-8 w-full max-w-7xl px-6 sm:mt-6 sm:mb-12 lg:mt-8 lg:px-8">
        <header class="relative w-full overflow-hidden rounded-[32px] border border-slate-200 bg-white py-10 shadow-md lg:py-12">
            <div class="px-6 text-left lg:px-10">
                <div class="mb-3 flex items-center gap-2">
                    <span class="text-[10px] text-blue-600">■</span>
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-slate-500">Layanan Jasa</span>
                </div>
                <h1 class="text-3xl font-light tracking-tight text-slate-900 sm:text-4xl lg:text-[3rem] lg:leading-[1.1]">
                    Sertifikasi Produk (LSPro)
                </h1>
                <p class="mt-4 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                    Lembaga Sertifikasi Produk untuk memastikan produk Anda memenuhi Standar Nasional Indonesia (SNI).
                </p>
            </div>
        </header>
    </div>

    <div class="mx-auto grid max-w-7xl grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
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

            <button
                type="button"
                @click="tab = 'direktori-pelanggan'"
                :class="tab === 'direktori-pelanggan' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'direktori-pelanggan' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3h15l-.75 18H5.25L4.5 3Zm4.5 4.5h1.5m3 0H15m-6 4.5h1.5m3 0H15m-6 4.5h1.5m3 0H15" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Direktori Pelanggan</span>
            </button>
        </div>

        <article class="min-h-[85vh] pb-32 sm:pb-[450px]">

                <section x-show="tab === 'alur'" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="mx-auto max-w-6xl space-y-6">
                    @if($alurProduk && $alurProduk->image)
                        <div class="flex justify-start">
                            <button
                                type="button"
                                @click="openLightbox('{{ asset('storage/' . $alurProduk->image) }}', 'Alur Sertifikasi Produk')"
                                class="group relative block w-full max-w-4xl cursor-pointer overflow-hidden rounded-2xl border border-slate-200 text-left"
                            >
                                <img
                                    src="{{ asset('storage/' . $alurProduk->image) }}"
                                    alt="Alur Sertifikasi"
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
                            <p class="font-medium text-slate-400">Data alur sertifikasi belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </section>

                <section x-show="tab === 'sertifikat'" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="mx-auto max-w-6xl space-y-8">
                    @if($sertifikats->isNotEmpty())
                        <div class="flex justify-start">
                            @foreach($sertifikats as $sert)
                                <button
                                    type="button"
                                    @click="openLightbox('{{ asset('storage/' . $sert->image) }}', 'Sertifikat Akreditasi')"
                                    class="group relative block w-full max-w-3xl cursor-pointer overflow-hidden rounded-2xl text-left"
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

                <section x-show="tab === 'ruang-lingkup'" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="mx-auto max-w-6xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                    @forelse($ruangLingkup as $item)
                        @if($item->image)
                            <button
                                type="button"
                                @click="openLightbox('{{ asset('storage/' . $item->image) }}', 'Ruang Lingkup')"
                                class="group relative block w-full cursor-pointer overflow-hidden rounded-2xl border border-slate-200 text-left"
                            >
                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    alt="Ruang Lingkup"
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
                        <div class="col-span-full rounded-[30px] border border-dashed border-black/15 bg-[#fbfbfd] px-6 py-20 text-center">
                            <p class="font-medium text-slate-400">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </section>

                <section x-show="tab === 'dokumen'" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
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
                                {{-- LOGIKA DINAMIS SEMENTARA DI-COMMENT
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
                                --}}

                                {{-- hapus dummy ini jika ingin menerapkan dinamis --}}
                                @php
                                    $staticDokumens = [
                                        "Blangko Daftar Isian Permohonan SPPT SNI",
                                        "Blangko Data Pemohon Sertifikasi",
                                        "Blangko Ilustrasi Pembubuhan Tanda SNI",
                                        "Blangko Kualifikasi Penanggung Jawab Mutu",
                                        "Blangko Peralatan Inspeksi - Pengujian",
                                        "Blangko Peralatan Produksi",
                                        "Blangko Pernyataan Kesesuaian",
                                        "Blangko Pernyataan PenanggungJawab di Indonesia",
                                        "Blangko Pernyataan Penerapan CPPOB",
                                        "Blangko Surat Pelimpahan Merek (bila merek punya orang lain)",
                                        "Blangko Surat Penunjukan Personil Pengurusan",
                                        "Blangko Surat Pernyataan Keabsahan Merek",
                                        "Blanko Surat Pernyataan Keaslian Dokumen",
                                        "Surat permohonan Perusahaan"
                                    ];
                                @endphp

                                @foreach($staticDokumens as $index => $namaDokumen)
                                    <tr class="transition-colors hover:bg-slate-50/50">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-500">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                                            {{ $namaDokumen }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ asset('dokumen-dummy.pdf') }}" download="{{ $namaDokumen }}.pdf" class="inline-flex items-center gap-2 rounded-xl bg-slate-800 px-4 py-2 text-xs font-bold text-white transition-all hover:bg-slate-700 active:scale-95">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

                <section x-show="tab === 'hak-kewajiban'" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
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

                <section x-show="tab === 'tarif'" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="space-y-12">
                    @forelse($tarifs as $tarif)
                        <div class="space-y-4">
                            <h3 class="border-l-4 border-slate-800 px-4 text-lg font-bold text-slate-800">TARIF SERTIFIKASI/RESERTIFIKASI/SURVEILANS BSPJI BANDA ACEH</h3>
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

                <section x-show="tab === 'sdm'" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="mx-auto max-w-6xl space-y-10">
                    <p class="max-w-3xl text-sm leading-relaxed text-slate-600 md:text-base">
                        Auditor Sertifikasi Produk yang kompeten dan berpengalaman untuk menjamin kualitas layanan.
                    </p>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        {{-- Card Ahli Madya --}}
                        <div class="group relative flex flex-col justify-between overflow-hidden rounded-[24px] p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-slate-500/30 bg-slate-800 text-white">
                            <!-- Background Decor -->
                            <div class="absolute -right-6 -top-6 h-32 w-32 rounded-full bg-white/10 blur-2xl transition-transform duration-500 group-hover:scale-150"></div>
                            
                            <div class="relative z-10 flex items-center justify-between">
                                <!-- Icon Wrapper -->
                                <div class="flex h-14 w-14 items-center justify-center rounded-[16px] bg-white/10 border border-white/20 backdrop-blur-sm text-white shadow-inner">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <!-- Count -->
                                <div class="flex items-baseline gap-1.5 text-right">
                                    <span class="text-4xl font-black tracking-tight text-white">{{ $countAhliMadya }}</span>
                                    <span class="text-xs font-bold uppercase tracking-widest text-slate-300">Orang</span>
                                </div>
                            </div>

                            <div class="relative z-10 mt-10 space-y-1 text-left">
                                <span class="inline-block rounded-full bg-white/20 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-white shadow-sm backdrop-blur-md">Auditor</span>
                                <h3 class="mt-4 text-3xl font-light tracking-tight text-slate-50 sm:text-4xl">
                                    Ahli <span class="font-bold text-white">Madya</span>
                                </h3>
                            </div>
                        </div>

                        {{-- Card Ahli Muda --}}
                        <div class="group relative flex flex-col justify-between overflow-hidden rounded-[24px] p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-slate-500/30 bg-slate-800 text-white">
                            <!-- Background Decor -->
                            <div class="absolute -right-6 -top-6 h-32 w-32 rounded-full bg-white/10 blur-2xl transition-transform duration-500 group-hover:scale-150"></div>
                            
                            <div class="relative z-10 flex items-center justify-between">
                                <!-- Icon Wrapper -->
                                <div class="flex h-14 w-14 items-center justify-center rounded-[16px] bg-white/10 border border-white/20 backdrop-blur-sm text-white shadow-inner">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <!-- Count -->
                                <div class="flex items-baseline gap-1.5 text-right">
                                    <span class="text-4xl font-black tracking-tight text-white">{{ $countAhliMuda }}</span>
                                    <span class="text-xs font-bold uppercase tracking-widest text-slate-300">Orang</span>
                                </div>
                            </div>

                            <div class="relative z-10 mt-10 space-y-1 text-left">
                                <span class="inline-block rounded-full bg-white/20 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-white shadow-sm backdrop-blur-md">Auditor</span>
                                <h3 class="mt-4 text-3xl font-light tracking-tight text-slate-50 sm:text-4xl">
                                    Ahli <span class="font-bold text-white">Muda</span>
                                </h3>
                            </div>
                        </div>

                        {{-- Card Ahli Pertama --}}
                        <div class="group relative flex flex-col justify-between overflow-hidden rounded-[24px] p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-slate-500/30 bg-slate-800 text-white">
                            <!-- Background Decor -->
                            <div class="absolute -right-6 -top-6 h-32 w-32 rounded-full bg-white/10 blur-2xl transition-transform duration-500 group-hover:scale-150"></div>
                            
                            <div class="relative z-10 flex items-center justify-between">
                                <!-- Icon Wrapper -->
                                <div class="flex h-14 w-14 items-center justify-center rounded-[16px] bg-white/10 border border-white/20 backdrop-blur-sm text-white shadow-inner">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <!-- Count -->
                                <div class="flex items-baseline gap-1.5 text-right">
                                    <span class="text-4xl font-black tracking-tight text-white">{{ $countAhliPertama }}</span>
                                    <span class="text-xs font-bold uppercase tracking-widest text-slate-300">Orang</span>
                                </div>
                            </div>

                            <div class="relative z-10 mt-10 space-y-1 text-left">
                                <span class="inline-block rounded-full bg-white/20 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-white shadow-sm backdrop-blur-md">Auditor</span>
                                <h3 class="mt-4 text-3xl font-light tracking-tight text-slate-50 sm:text-4xl">
                                    Ahli <span class="font-bold text-white">Pertama</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

                <section x-show="tab === 'direktori-pelanggan'" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="mx-auto max-w-6xl overflow-hidden rounded-2xl border border-black/20 bg-white shadow-sm">
                    <div class="border-b border-black/10 bg-white px-4 py-4 sm:px-6">
                        <form action="{{ route('sertifikasi-produk.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <input type="hidden" name="tab" value="direktori-pelanggan">

                            <label class="relative block w-full sm:max-w-md">
                                <span class="sr-only">Cari direktori pelanggan</span>
                                <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.6-5.15a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
                                </svg>
                                <input
                                    type="search"
                                    name="direktori_search"
                                    value="{{ $direktoriSearch }}"
                                    placeholder="Cari nama perusahaan, merek, tahun, atau alamat"
                                    class="w-full rounded-xl border border-black/20 bg-white py-2.5 pl-11 pr-4 text-sm font-medium text-slate-700 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                >
                            </label>

                            <div class="flex items-center gap-2">
                                @if($direktoriSearch !== '')
                                    <a href="{{ route('sertifikasi-produk.index', ['tab' => 'direktori-pelanggan']) }}" class="inline-flex items-center justify-center rounded-xl border border-black/20 px-4 py-2.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50">
                                        Reset
                                    </a>
                                @endif
                                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-800 px-4 py-2.5 text-xs font-bold text-white transition active:scale-95">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[760px] border-collapse text-left">
                            <thead>
                                <tr class="border-b border-black/20 bg-slate-50">
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-800">Nama Perusahaan</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-800">Merek</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-800">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-800">Gambar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black/10">
                                @forelse($direktoriPelanggan as $pelanggan)
                                    @php
                                        $detailPelanggan = [
                                            'namaPerusahaan' => $pelanggan->nama_perusahaan ?: '-',
                                            'merek' => $pelanggan->merek ?: '-',
                                            'tahunSertifikasi' => $pelanggan->tahun_sertifikasi ?: '-',
                                            'alamat' => $pelanggan->alamat ?: 'Alamat belum tersedia.',
                                            'isActive' => $pelanggan->is_active,
                                            'statusLabel' => $pelanggan->is_active ? 'Aktif' : 'Tidak Aktif',
                                            'image' => $pelanggan->gambar ? asset('storage/' . $pelanggan->gambar) : null,
                                            'imageAlt' => 'Gambar ' . ($pelanggan->nama_perusahaan ?: 'Direktori Pelanggan'),
                                        ];
                                    @endphp
                                    <tr
                                        tabindex="0"
                                        role="button"
                                        aria-label="Buka detail {{ $pelanggan->nama_perusahaan ?: 'direktori pelanggan' }}"
                                        @click="openCustomerDetail(@js($detailPelanggan))"
                                        @keydown.enter.prevent="openCustomerDetail(@js($detailPelanggan))"
                                        @keydown.space.prevent="openCustomerDetail(@js($detailPelanggan))"
                                        class="cursor-pointer align-middle transition-colors hover:bg-slate-50 focus:outline-none focus-visible:bg-slate-50 focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-slate-400"
                                    >
                                        <td class="w-[40%] px-6 py-4 align-middle text-sm font-semibold text-slate-800">
                                            {{ $pelanggan->nama_perusahaan ?: '-' }}
                                        </td>
                                        <td class="w-[30%] px-6 py-4 align-middle text-sm font-medium text-slate-700">
                                            {{ $pelanggan->merek ?: '-' }}
                                        </td>
                                        <td class="w-[15%] px-6 py-4 align-middle">
                                            @if($pelanggan->is_active)
                                                <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 ring-1 ring-emerald-200">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500 ring-1 ring-slate-200">
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="w-[15%] px-6 py-4 align-middle text-center">
                                            @if($pelanggan->gambar)
                                                <div class="mx-auto h-16 w-24 overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                                    <img
                                                        src="{{ asset('storage/' . $pelanggan->gambar) }}"
                                                        alt="Gambar {{ $pelanggan->nama_perusahaan }}"
                                                        loading="lazy"
                                                        decoding="async"
                                                        class="h-full w-full object-cover"
                                                    >
                                                </div>
                                            @else
                                                <span class="mx-auto inline-flex justify-center rounded-full bg-slate-100 px-3 py-1 text-center text-xs font-semibold text-slate-400">
                                                    Belum ada
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center">
                                            <p class="font-medium text-slate-400">Direktori pelanggan belum tersedia.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-4 border-t border-black/10 px-4 py-4 sm:px-6">
                        {{ $direktoriPelanggan->links() }}
                    </div>
                </div>
                </section>

                <section x-show="tab === 'informasi-publik'" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
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
        </article>
    </div>
    <div
        x-show="customerDetailOpen"
        x-cloak
        x-transition.opacity.duration.300ms
        @click="closeCustomerDetail()"
        @keydown.escape.window="closeCustomerDetail()"
        class="fixed inset-0 z-90 flex items-center justify-center bg-slate-950/70 p-4 backdrop-blur-sm md:p-8"
        role="dialog"
        aria-modal="true"
        aria-labelledby="customer-detail-title"
    >
        <div
            x-show="customerDetailOpen"
            x-transition.scale.duration.300ms
            @click.stop
            class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-2xl bg-white shadow-2xl"
        >
            <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-4 sm:px-6">
                <div class="min-w-0">
                    <div class="mb-2 flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex rounded-full px-3 py-1 text-xs font-bold ring-1"
                            :class="selectedCustomer?.isActive ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-slate-100 text-slate-500 ring-slate-200'"
                            x-text="selectedCustomer?.statusLabel"
                        ></span>
                    </div>
                    <h2 id="customer-detail-title" class="text-xl font-semibold leading-tight text-slate-900 sm:text-2xl" x-text="selectedCustomer?.namaPerusahaan"></h2>
                </div>
                <button
                    type="button"
                    @click="closeCustomerDetail()"
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:bg-slate-50 hover:text-slate-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-400"
                    aria-label="Tutup detail pelanggan"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="grid gap-0 md:grid-cols-[minmax(0,1fr)_260px]">
                <div class="space-y-5 px-5 py-5 sm:px-6">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Merek</p>
                            <p class="mt-2 text-sm font-semibold text-slate-900" x-text="selectedCustomer?.merek"></p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Tahun Sertifikasi</p>
                            <p class="mt-2 text-sm font-semibold text-slate-900" x-text="selectedCustomer?.tahunSertifikasi"></p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Alamat</p>
                        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-700" x-text="selectedCustomer?.alamat"></p>
                    </div>
                </div>

                <div class="border-t border-slate-200 bg-slate-50 p-5 md:border-l md:border-t-0">
                    <template x-if="selectedCustomer?.image">
                        <img
                            :src="selectedCustomer.image"
                            :alt="selectedCustomer.imageAlt"
                            class="h-64 w-full rounded-xl border border-slate-200 bg-white object-cover"
                        >
                    </template>
                    <template x-if="! selectedCustomer?.image">
                        <div class="flex h-64 w-full items-center justify-center rounded-xl border border-dashed border-slate-300 bg-white text-center">
                            <div class="px-6">
                                <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m2.25 15.75 5.16-5.16a2.25 2.25 0 0 1 3.18 0l5.16 5.16m-1.5-1.5 1.41-1.41a2.25 2.25 0 0 1 3.18 0l2.91 2.91m-18 3h16.5a1.5 1.5 0 0 0 1.5-1.5V6.75a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v10.5a1.5 1.5 0 0 0 1.5 1.5Zm14.25-9h.008v.008H18V9.75Z" />
                                </svg>
                                <p class="mt-3 text-sm font-semibold text-slate-400">Belum ada gambar</p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
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
