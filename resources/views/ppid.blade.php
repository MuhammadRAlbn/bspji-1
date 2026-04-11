<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPID - BSPJI Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-blue-100 selection:text-blue-900">

    <div class="max-w-6xl mx-auto px-6 py-16">
        <!-- Hero Section -->
        <div class="text-center mb-16 relative">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-32 h-32 bg-blue-100 rounded-full blur-3xl opacity-50 -z-10"></div>
            <span class="px-4 py-1.5 bg-blue-100/50 text-blue-700 text-xs font-bold rounded-full uppercase tracking-widest mb-4 inline-block backdrop-blur-sm border border-blue-200">Informasi Publik</span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">Pejabat Pengelola <br> Informasi & Dokumentasi <span class="text-blue-600">(PPID)</span></h1>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">Transparansi informasi sebagai perwujudan tata kelola pemerintahan yang baik dan akuntabel di lingkungan BSPJI Pekanbaru.</p>
        </div>

        <div class="space-y-16">
            {{-- Section: Struktur Organisasi PPID --}}
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-12 transition duration-51 hover:shadow-blue-500/5">
                <div class="flex items-center mb-10 pb-6 border-b border-slate-100">
                    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mr-5 shadow-sm">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Struktur Organisasi PPID</h2>
                        <p class="text-slate-500 font-medium">Bagan susunan pengelola informasi dan dokumentasi.</p>
                    </div>
                </div>

                @if($ppid && $ppid->structure_image)
                    <div class="bg-slate-50 rounded-[1.5rem] overflow-hidden border border-slate-100 group p-2">
                        <div class="relative overflow-hidden rounded-[1.25rem]">
                            <img src="{{ asset('storage/' . $ppid->structure_image) }}" class="w-full h-auto group-hover:scale-[1.01] transition duration-700" alt="Struktur PPID">
                        </div>
                    </div>
                @else
                    <div class="py-24 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-medium italic text-lg">Gambar struktur belum diunggah.</p>
                    </div>
                @endif
            </div>

            {{-- Section: Dokumen PPID --}}
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-12 transition duration-51 hover:shadow-blue-500/5">
                <div class="flex items-center mb-10 pb-6 border-b border-slate-100">
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mr-5 shadow-sm">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dokumen Informasi Publik</h2>
                        <p class="text-slate-500 font-medium">Laporan dan dokumen pendukung keterbukaan informasi.</p>
                    </div>
                </div>

                @if($ppid && $ppid->pdf_file)
                    <div class="bg-slate-50 rounded-[1.5rem] overflow-hidden border border-slate-200 group">
                        <iframe src="{{ asset('storage/' . $ppid->pdf_file) }}" class="w-full h-[800px] border-none"></iframe>
                    </div>
                    <div class="mt-8 flex justify-end">
                         <a href="{{ asset('storage/' . $ppid->pdf_file) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download PDF
                        </a>
                    </div>
                @else
                    <div class="py-24 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-medium italic text-lg">Dokumen PDF belum diunggah.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer/Back Link -->
        <div class="mt-20 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center px-10 py-4 bg-white text-slate-800 font-bold rounded-2xl shadow-lg border border-slate-100 hover:bg-slate-50 hover:-translate-y-1 transition duration-300 group"> 
                <svg class="w-5 h-5 mr-3 transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda 
            </a>
        </div>
    </div>

</body>
</html>
