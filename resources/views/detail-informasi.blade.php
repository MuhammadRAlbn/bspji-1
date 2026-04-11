<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tipeLabels[$tipe] }} - BSPJI Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-blue-100 selection:text-blue-900">

    <div class="max-w-6xl mx-auto px-6 py-16">
        {{-- Hero Section --}}
        <div class="text-center mb-12 relative">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-32 h-32 bg-emerald-100 rounded-full blur-3xl opacity-50 -z-10"></div>
            <a href="{{ route('informasi-publik.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-500 hover:text-emerald-600 transition mb-6 group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Informasi Publik
            </a>
        </div>

        {{-- Navigasi Antar Tipe --}}
        @php
            $tipeColors = [
                'berkala' => 'emerald',
                'setiap_saat' => 'blue',
                'serta_merta' => 'amber',
                'dikecualikan' => 'rose',
            ];
            $currentColor = $tipeColors[$tipe] ?? 'emerald';
        @endphp

        <div class="flex items-center justify-center mb-12">
            @if($prevTipe)
                <a href="{{ route('detail-informasi.show', $prevTipe) }}" class="flex items-center px-5 py-3 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:-translate-x-1 transition-all duration-300 mr-4 group">
                    <svg class="w-5 h-5 text-slate-500 group-hover:text-{{ $tipeColors[$prevTipe] ?? 'emerald' }}-600 transition mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    <span class="text-sm font-semibold text-slate-600 hidden sm:inline">{{ $tipeLabels[$prevTipe] }}</span>
                </a>
            @else
                <div class="w-[120px] sm:w-[200px]"></div>
            @endif

            <div class="px-8 py-4 bg-{{ $currentColor }}-600 text-white rounded-2xl shadow-xl shadow-{{ $currentColor }}-200 text-center min-w-[200px]">
                <h1 class="text-lg md:text-xl font-extrabold tracking-tight">{{ $tipeLabels[$tipe] }}</h1>
            </div>

            @if($nextTipe)
                <a href="{{ route('detail-informasi.show', $nextTipe) }}" class="flex items-center px-5 py-3 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:translate-x-1 transition-all duration-300 ml-4 group">
                    <span class="text-sm font-semibold text-slate-600 hidden sm:inline">{{ $tipeLabels[$nextTipe] }}</span>
                    <svg class="w-5 h-5 text-slate-500 group-hover:text-{{ $tipeColors[$nextTipe] ?? 'emerald' }}-600 transition ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </a>
            @else
                <div class="w-[120px] sm:w-[200px]"></div>
            @endif
        </div>

        {{-- Konten --}}
        @if(in_array($tipe, ['serta_merta', 'dikecualikan']))
            {{-- Static Empty State untuk Serta Merta & Dikecualikan --}}
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-16">
                <div class="py-20 text-center">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                        @if($tipe === 'serta_merta')
                            <svg class="w-12 h-12 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        @else
                            <svg class="w-12 h-12 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        @endif
                    </div>
                    <h3 class="text-2xl font-bold text-slate-700 mb-3">Tidak Ada Data</h3>
                    <p class="text-slate-400 text-lg max-w-md mx-auto leading-relaxed">
                        {{ $tipe === 'serta_merta' ? 'Informasi serta merta belum tersedia saat ini.' : 'Informasi dikecualikan belum tersedia saat ini.' }}
                    </p>
                </div>
            </div>
        @else
            {{-- Konten Dokumen Berkala & Setiap Saat --}}
            @if($dokumen->isEmpty())
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-16">
                    <div class="py-20 text-center">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-700 mb-3">Belum Ada Dokumen</h3>
                        <p class="text-slate-400 text-lg">Dokumen untuk kategori ini belum tersedia.</p>
                    </div>
                </div>
            @else
                <div class="space-y-8">
                    @foreach($kategoriLabels as $kategoriId => $kategoriLabel)
                        @if($dokumen->has($kategoriId))
                            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/40 overflow-hidden border border-slate-100 transition duration-300 hover:shadow-{{ $currentColor }}-100/30">
                                {{-- Header Kategori --}}
                                <div class="px-8 py-5 bg-gradient-to-r from-{{ $currentColor }}-50 to-transparent border-b border-slate-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-{{ $currentColor }}-100 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-5 h-5 text-{{ $currentColor }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-slate-800">{{ $kategoriLabel }}</h3>
                                            <p class="text-xs text-slate-400 font-medium">{{ $dokumen[$kategoriId]->count() }} dokumen</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Daftar Dokumen --}}
                                <div class="divide-y divide-slate-50">
                                    @foreach($dokumen[$kategoriId] as $doc)
                                        <div class="px-8 py-4 flex items-center justify-between group hover:bg-slate-50/50 transition duration-200">
                                            <div class="flex items-center min-w-0 flex-1">
                                                <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center mr-4 shrink-0">
                                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-semibold text-slate-700 truncate">{{ $doc->judul }}</p>
                                                    @if($doc->keterangan)
                                                        <p class="text-xs text-slate-400 truncate mt-0.5">{{ $doc->keterangan }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <a href="{{ asset('storage/' . $doc->pdf_file) }}" target="_blank" download
                                               class="inline-flex items-center px-4 py-2 bg-{{ $currentColor }}-50 text-{{ $currentColor }}-700 font-semibold text-sm rounded-xl hover:bg-{{ $currentColor }}-100 transition duration-200 shrink-0 ml-4 group-hover:shadow-sm">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Unduh
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @endif

        {{-- Footer/Back Link --}}
        <div class="mt-20 text-center">
            <a href="{{ route('informasi-publik.index') }}" class="inline-flex items-center px-10 py-4 bg-white text-slate-800 font-bold rounded-2xl shadow-lg border border-slate-100 hover:bg-slate-50 hover:-translate-y-1 transition duration-300 group">
                <svg class="w-5 h-5 mr-3 transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Informasi Publik
            </a>
        </div>
    </div>

</body>
</html>
