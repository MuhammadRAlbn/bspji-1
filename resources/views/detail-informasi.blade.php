<x-layouts.app :title="($tipeLabels[$tipe] ?? 'Detail Informasi') . ' - BSPJI Banda Aceh'">
    @php
        $heroImage = asset('images/ppid/gbrppid.webp');
        $emptyState = [
            'serta_merta' => 'Informasi serta merta belum tersedia saat ini.',
            'dikecualikan' => 'Informasi dikecualikan belum tersedia saat ini.',
        ];
    @endphp

    <section class="bg-slate-100 max-w-6xl mx-auto rounded-3xl pt-4 mt-6">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-2 items-center">
                <div class="pl-6">
                    <a href="{{ route('informasi-publik.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-orange-500 transition mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                            </path>
                        </svg>
                        Kembali ke Informasi Publik
                    </a>
                    <h1 class="text-4xl md:text-5xl tracking-tight text-slate-800">
                        {{ $tipeLabels[$tipe] ?? 'Detail Informasi' }}
                    </h1>
                    <p class="text-slate-600 mt-4 text-lg max-w-md">
                        Balai Standardisasi dan Pelayanan Jasa Industri Banda Aceh
                    </p>
                </div>

                <div class="flex justify-center md:justify-center">
                    <img src="{{ $heroImage }}" alt="Detail Informasi Publik" class="w-full max-w-md">
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-8">
        <div class="mx-4 mb-6">
            <div class="grid grid-cols-3 items-start gap-4">
                <div class="flex flex-col items-start">
                    @if ($prevTipe)
                        <a href="{{ route('detail-informasi.show', $prevTipe) }}"
                            class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white border border-slate-300 text-slate-700 hover:text-orange-500 hover:border-orange-300 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <p class="mt-2 text-xs md:text-sm text-slate-500 font-semibold text-left">
                            {{ $tipeLabels[$prevTipe] }}
                        </p>
                    @else
                        <span
                            class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 border border-slate-200 text-slate-300 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </span>
                    @endif
                </div>

                <div class="flex justify-center">
                    <div class="px-4 py-2 rounded-full bg-slate-200/80 text-slate-700 font-semibold text-sm md:text-base text-center">
                        {{ $tipeLabels[$tipe] ?? 'Detail Informasi' }}
                    </div>
                </div>

                <div class="flex flex-col items-end">
                    @if ($nextTipe)
                        <a href="{{ route('detail-informasi.show', $nextTipe) }}"
                            class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white border border-slate-300 text-slate-700 hover:text-orange-500 hover:border-orange-300 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <p class="mt-2 text-xs md:text-sm text-slate-500 font-semibold text-right">
                            {{ $tipeLabels[$nextTipe] }}
                        </p>
                    @else
                        <span
                            class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 border border-slate-200 text-slate-300 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        @if (in_array($tipe, ['serta_merta', 'dikecualikan']))
            <div class="bg-white rounded-2xl shadow-sm border border-slate-300 mx-4 p-8 md:p-12">
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl text-slate-800 mb-3">Belum Ada Data</h2>
                    <p class="text-slate-500 max-w-xl mx-auto">
                        {{ $emptyState[$tipe] ?? 'Data detail informasi belum tersedia saat ini.' }}
                    </p>
                </div>
            </div>
        @elseif ($dokumen->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-300 mx-4 p-8 md:p-12">
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl text-slate-800 mb-3">Belum Ada Dokumen</h2>
                    <p class="text-slate-500 max-w-xl mx-auto">
                        Dokumen untuk kategori ini belum tersedia.
                    </p>
                </div>
            </div>
        @else
            <div class="mb-8 px-4">
                <div>
                    <h2 class="text-2xl text-slate-800">{{ $tipeLabels[$tipe] }}</h2>
                    <p class="text-slate-600 mt-1">Daftar dokumen yang dapat diakses publik berdasarkan kategori.</p>
                </div>
            </div>

            <div class="space-y-6 mx-4">
                @foreach ($kategoriLabels as $kategoriId => $kategoriLabel)
                    @if ($dokumen->has($kategoriId))
                        <div class="bg-white rounded-2xl shadow-sm border px-2 border-slate-300 overflow-hidden">
                            <div class="px-5 md:px-8 py-5 border-b border-slate-100 bg-slate-50/70">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">{{ $kategoriLabel }}</h3>
                                            <p class="text-sm text-slate-500">{{ $dokumen[$kategoriId]->count() }} dokumen</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @foreach ($dokumen[$kategoriId] as $doc)
                                <div @class([
                                    'flex items-center justify-between p-3 md:px-8 md:py-4',
                                    'border-b border-slate-50' => ! $loop->last,
                                    'bg-slate-100' => $loop->iteration % 2 === 0,
                                ])>
                                    <div class="flex items-start min-w-0 mr-4">
                                        <span class="w-2 h-2 rounded-full bg-slate-400 mr-3 mt-2 shrink-0"></span>
                                        <div class="min-w-0">
                                            <p class="font-medium text-slate-700 text-sm md:text-base truncate">{{ $doc->judul }}</p>
                                            @if ($doc->keterangan)
                                                <p class="text-xs md:text-sm text-slate-500 truncate">{{ $doc->keterangan }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <a href="{{ asset('storage/' . $doc->pdf_file) }}" target="_blank" rel="noopener noreferrer"
                                        class="flex items-center text-orange-500 font-bold shrink-0">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                        LIHAT
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.app>
