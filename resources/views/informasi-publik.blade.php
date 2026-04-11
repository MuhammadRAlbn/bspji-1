<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Publik - BSPJI Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-blue-100 selection:text-blue-900">

    <div class="max-w-6xl mx-auto px-6 py-16" x-data="{ tab: 'daftar' }">
        <!-- Hero Section -->
        <div class="text-center mb-16 relative">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-32 h-32 bg-emerald-100 rounded-full blur-3xl opacity-50 -z-10"></div>
            <span class="px-4 py-1.5 bg-emerald-100/50 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-widest mb-4 inline-block backdrop-blur-sm border border-emerald-200">Keterbukaan Informasi</span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">Informasi <span class="text-emerald-600">Publik</span></h1>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">Akses mudah dan transparan terhadap daftar informasi serta prosedur permohonan informasi publik.</p>
        </div>

        {{-- Navigasi Tab --}}
        <div class="flex justify-center mb-16">
            <nav class="inline-flex p-1.5 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 backdrop-blur-xl">
                <button 
                    @click="tab = 'daftar'" 
                    :class="tab === 'daftar' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200 ring-1 ring-emerald-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-8 py-4 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-5 h-5 mr-2.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Daftar Informasi
                </button>
                <button 
                    @click="tab = 'permohonan'" 
                    :class="tab === 'permohonan' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200 ring-1 ring-emerald-500' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'"
                    class="px-8 py-4 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center group"
                >
                    <svg class="w-5 h-5 mr-2.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Permohonan Informasi
                </button>
            </nav>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8">
            {{-- Tab Daftar Informasi --}}
            <div x-show="tab === 'daftar'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-12">
                    <div class="flex items-center mb-10 pb-6 border-b border-slate-100">
                        <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mr-5 shadow-sm">
                            <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Informasi Publik</h2>
                            <p class="text-slate-500 font-medium">Akses informasi berdasarkan kategori yang tersedia.</p>
                        </div>
                    </div>

                    {{-- Menu 4 Kategori --}}
                    <div class="space-y-3 mb-10">
                        @php
                            $kategoriMenu = [
                                ['tipe' => 'berkala', 'label' => 'Informasi Berkala', 'desc' => 'Informasi yang wajib disediakan dan diumumkan secara berkala', 'color' => 'emerald', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                ['tipe' => 'setiap_saat', 'label' => 'Informasi Setiap Saat', 'desc' => 'Informasi yang wajib tersedia setiap saat', 'color' => 'blue', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['tipe' => 'serta_merta', 'label' => 'Informasi Serta Merta', 'desc' => 'Informasi yang wajib diumumkan serta merta', 'color' => 'amber', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                                ['tipe' => 'dikecualikan', 'label' => 'Informasi Dikecualikan', 'desc' => 'Informasi yang dikecualikan dari akses publik', 'color' => 'rose', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                            ];
                        @endphp

                        @foreach($kategoriMenu as $item)
                            <a href="{{ route('detail-informasi.show', $item['tipe']) }}"
                               class="group flex items-center justify-between p-5 bg-{{ $item['color'] }}-50/50 hover:bg-{{ $item['color'] }}-50 border border-{{ $item['color'] }}-100 rounded-2xl transition-all duration-300 hover:shadow-lg hover:shadow-{{ $item['color'] }}-100/50 hover:-translate-y-0.5">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-{{ $item['color'] }}-100 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-6 h-6 text-{{ $item['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 group-hover:text-{{ $item['color'] }}-700 transition">{{ $item['label'] }}</h3>
                                        <p class="text-sm text-slate-400">{{ $item['desc'] }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-{{ $item['color'] }}-600 font-semibold text-sm group-hover:translate-x-1 transition-transform duration-300">
                                    <span class="mr-2">Lihat</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Divider --}}
                    <div class="flex items-center mb-8">
                        <div class="flex-1 border-t border-slate-100"></div>
                        <span class="px-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Dokumen Daftar Informasi</span>
                        <div class="flex-1 border-t border-slate-100"></div>
                    </div>

                    @if($daftarInformasi && $daftarInformasi->pdf_file)
                        <div class="bg-slate-50 rounded-[1.5rem] overflow-hidden border border-slate-200 group">
                            <iframe src="{{ asset('storage/' . $daftarInformasi->pdf_file) }}" class="w-full h-[800px] border-none"></iframe>
                        </div>
                        <div class="mt-8 flex justify-end">
                             <a href="{{ asset('storage/' . $daftarInformasi->pdf_file) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Daftar
                            </a>
                        </div>
                    @else
                        <div class="py-24 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-slate-400 font-medium italic text-lg">Dokumen daftar informasi belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Permohonan Informasi --}}
            <div x-show="tab === 'permohonan'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="space-y-12">
                    {{-- Section: Formulir Image --}}
                    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-12">
                        <div class="flex items-center mb-10 pb-6 border-b border-slate-100">
                            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mr-5 shadow-sm">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Formulir Permohonan</h2>
                                <p class="text-slate-500 font-medium">Bentuk fisik formulir permohonan informasi.</p>
                            </div>
                        </div>

                        @if($permohonanInformasi && $permohonanInformasi->form_image)
                            <div class="bg-slate-50 rounded-[1.5rem] overflow-hidden border border-slate-100 group p-2">
                                <div class="relative overflow-hidden rounded-[1.25rem]">
                                    <img src="{{ asset('storage/' . $permohonanInformasi->form_image) }}" class="w-full h-auto group-hover:scale-[1.01] transition duration-700" alt="Formulir Permohonan">
                                </div>
                            </div>
                        @else
                            <div class="py-24 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                                <p class="text-slate-400 font-medium italic">Gambar formulir belum tersedia.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Section: Prosedur PDF --}}
                    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 p-8 md:p-12">
                        <div class="flex items-center mb-10 pb-6 border-b border-slate-100">
                            <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mr-5 shadow-sm">
                                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Prosedur & Panduan PDF</h2>
                                <p class="text-slate-500 font-medium">Dokumen panduan lengkap permohonan informasi.</p>
                            </div>
                        </div>

                        @if($permohonanInformasi && $permohonanInformasi->pdf_file)
                            <div class="bg-slate-50 rounded-[1.5rem] overflow-hidden border border-slate-200 group">
                                <iframe src="{{ asset('storage/' . $permohonanInformasi->pdf_file) }}" class="w-full h-[800px] border-none"></iframe>
                            </div>
                            <div class="mt-8 flex justify-end">
                                <a href="{{ asset('storage/' . $permohonanInformasi->pdf_file) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition duration-300">
                                   <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                   Download Panduan
                               </a>
                           </div>
                        @else
                            <div class="py-24 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                                <p class="text-slate-400 font-medium italic">Dokumen PDF belum tersedia.</p>
                            </div>
                        @endif
                    </div>
                </div>
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
