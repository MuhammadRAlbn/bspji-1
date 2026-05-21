<x-layouts.app title="Informasi Publik - BSPJI Banda Aceh">
    @push('styles')
        <style>
            [x-cloak] {
                display: none !important;
            }

            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .active-tab {
                background-color: #ff7300 !important;
                color: #fff !important;
            }
        </style>
    @endpush

    @php
        $heroImage = asset('images/ppid/gbrppid.webp');
        $permohonanImage = asset('images/informasi/icpermohonaninformasi.webp');
        $daftarInformasiPdf = $daftarInformasi?->pdf_file ? asset('storage/' . $daftarInformasi->pdf_file) : null;
        $dokumenNama = $daftarInformasi?->pdf_file ? basename($daftarInformasi->pdf_file) : null;
        $permohonanPdf = $permohonanInformasi?->pdf_file ? asset('storage/' . $permohonanInformasi->pdf_file) : null;
        $permohonanNama = $permohonanInformasi?->pdf_file ? basename($permohonanInformasi->pdf_file) : null;
        $formPermohonanImage = $permohonanInformasi?->form_image ? asset('storage/' . $permohonanInformasi->form_image) : null;

        $daftarMenu = [
            ['label' => 'Informasi Berkala', 'href' => route('detail-informasi.show', 'berkala')],
            ['label' => 'Informasi Setiap Saat', 'href' => route('detail-informasi.show', 'setiap_saat')],
            ['label' => 'Informasi Serta Merta', 'href' => route('detail-informasi.show', 'serta_merta')],
            ['label' => 'Informasi Dikecualikan', 'href' => route('detail-informasi.show', 'dikecualikan')],
            ['label' => 'Standar Biaya Pelayanan', 'href' => $daftarInformasiPdf],
        ];
    @endphp

    <div x-data="{ tab: 'daftar' }">
        <section class="bg-slate-100 max-w-6xl mx-4 md:mx-auto rounded-3xl pt-6 md:pt-4 mt-6 border border-slate-300 shadow-md">
            <div class="max-w-6xl mx-auto px-4 md:px-6">
                <div class="grid md:grid-cols-2 gap-6 md:gap-2 items-center">
                    <div class="px-4 md:px-0 md:pl-6 py-4 md:py-8 min-w-0">
                        <h1 class="text-4xl md:text-5xl tracking-tight text-slate-800">
                            Informasi Publik
                        </h1>
                        <p class="text-slate-600 mt-4 text-lg max-w-sm">
                            Balai Standardisasi dan Pelayanan Jasa Industri Banda Aceh
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 mt-6">
                            <button @click="tab = 'daftar'"
                                :class="tab === 'daftar' ? 'active-tab' : 'bg-slate-200/80 text-slate-700'"
                                class="tab-btn px-6 py-3 rounded-full text-sm md:text-base font-semibold text-center w-full sm:w-auto">
                                Daftar Informasi Publik
                            </button>
                            <button @click="tab = 'permohonan'"
                                :class="tab === 'permohonan' ? 'active-tab' : 'bg-slate-200/80 text-slate-700'"
                                class="tab-btn px-6 py-3 rounded-full text-sm md:text-base font-semibold text-center w-full sm:w-auto">
                                Permohonan Informasi
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-center px-4 md:px-0">
                        <img src="{{ $heroImage }}" alt="Dokumen Informasi Publik" class="w-full max-w-md object-contain">
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-6 py-8">
            <div id="tab-content">
                <div id="content-daftar" x-show="tab === 'daftar'">
                    <div class="mb-8 px-0 md:px-4">
                        <div>
                            <h2 class="text-2xl text-slate-800">Daftar Informasi Publik</h2>
                            <p class="text-slate-600 mt-1">Balai Standardisasi dan Pelayanan Jasa Industri Banda Aceh</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border px-2 border-slate-300 overflow-hidden mx-0 md:mx-4">
                        @foreach ($daftarMenu as $menu)
                            <div @class([
                                'flex items-center justify-between p-4 md:px-10',
                                'border-b border-slate-50' => ! $loop->last,
                                'bg-slate-100' => in_array($loop->index, [1, 3], true),
                            ])>
                                <span class="font-semibold text-slate-700 text-base md:text-lg">{{ $menu['label'] }}</span>

                                @if ($menu['href'])
                                    <a href="{{ $menu['href'] }}"
                                        @if ($loop->last) target="_blank" rel="noopener noreferrer" @endif
                                        class="flex items-center text-orange-500 font-bold group">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                        LIHAT
                                    </a>
                                @else
                                    <span class="flex items-center text-slate-400 font-bold cursor-not-allowed">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                        LIHAT
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12 mx-0 md:mx-4">
                        <div class="mb-6 px-0 md:px-4">
                            <h3 class="text-xl font-bold text-slate-800">Dokumen Daftar Informasi Publik</h3>
                            <p class="text-slate-500 text-sm mt-1 uppercase tracking-wider">
                                File: {{ $dokumenNama ?? 'Belum tersedia' }}
                            </p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-lg border border-slate-300 overflow-hidden h-[400px] sm:h-[600px] md:h-[800px]">
                            @if ($daftarInformasiPdf)
                                <iframe src="{{ $daftarInformasiPdf }}" class="w-full h-full" frameborder="0"></iframe>
                            @else
                                <div class="h-full flex items-center justify-center bg-slate-50 px-6">
                                    <p class="text-slate-500 italic text-center">Dokumen daftar informasi publik belum diunggah dari admin panel.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div id="content-permohonan" x-show="tab === 'permohonan'" x-cloak>
                    <div class="px-0 md:px-4"></div>
                    <p class="text-slate-600 mb-10 text-base md:text-lg">
                        Pelanggan dan Masyarakat dapat mengajukan Permohonan Informasi dengan mengunduh form di bawah ini.
                    </p>

                    <div class="grid md:grid-cols-2 gap-8 items-start">
                        <div class="flex flex-col gap-6">
                            <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-slate-400 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="bg-orange-50 p-4 rounded-xl text-orange-500 shrink-0">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-800 text-base md:text-lg truncate">Form Permohonan Informasi</h4>
                                        <p class="text-slate-500 text-xs md:text-sm truncate">File: {{ $permohonanNama ?? 'Belum tersedia' }}</p>
                                    </div>
                                </div>

                                @if ($permohonanPdf)
                                    <a href="{{ $permohonanPdf }}" target="_blank" rel="noopener noreferrer"
                                        class="bg-orange-500 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-md shadow-orange-100 active:scale-95 transition-all text-center whitespace-nowrap">
                                        DOWNLOAD
                                    </a>
                                @else
                                    <span class="bg-slate-300 text-white px-6 py-2.5 rounded-xl font-bold text-sm cursor-not-allowed text-center whitespace-nowrap">
                                        DOWNLOAD
                                    </span>
                                @endif
                            </div>

                            <div class="flex justify-center">
                                <img src="{{ $permohonanImage }}" alt="Permohonan Informasi" class="w-full max-w-sm h-auto object-contain">
                            </div>
                        </div>

                        <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-slate-400">
                            <h4 class="font-bold text-slate-800 text-lg mb-6">Contoh formulir Permohonan Informasi</h4>
                            <div class="bg-slate-50 rounded-xl overflow-hidden border border-slate-100 flex items-center justify-center min-h-[300px] md:min-h-[400px]">
                                @if ($formPermohonanImage)
                                    <img src="{{ $formPermohonanImage }}" alt="Contoh Formulir" class="max-w-full h-auto">
                                @else
                                    <p class="text-slate-500 italic px-6 text-center">Contoh formulir belum diunggah dari admin panel.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>
