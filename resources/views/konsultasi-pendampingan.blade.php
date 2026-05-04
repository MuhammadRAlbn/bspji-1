<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi dan Pendampingan - BSPJI Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body
    x-data="{ tab: 'ruang-lingkup' }"
    class="overflow-x-hidden bg-white font-sans text-[#1d1d1f] antialiased leading-relaxed"
>
    <header class="relative mb-8 flex h-[300px] w-full items-center overflow-hidden text-white sm:mx-auto sm:mt-5 sm:mb-10 sm:h-[360px] sm:w-[96%] sm:rounded-[25px] md:mt-5 md:h-[400px]">
        <img
            src="https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&q=80&w=2069"
            alt="Konsultasi dan Pendampingan"
            class="absolute inset-0 -z-10 h-full w-full object-cover brightness-[0.7]"
        >
        <div class="mx-auto w-full max-w-[1400px] px-5 text-left sm:px-8 md:px-20">
            <h1 class="text-[2.25rem] font-bold tracking-[-0.03em] sm:text-[3rem] md:text-[4.5rem]">
                Konsultasi dan Pendampingan
            </h1>
        </div>
    </header>

    <main class="mx-auto grid max-w-[1400px] grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:sticky lg:top-10 lg:grid-cols-1">
            <button
                type="button"
                @click="tab = 'ruang-lingkup'"
                :class="tab === 'ruang-lingkup' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'ruang-lingkup' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.75h4.5m-7.386 2.25h10.272c.53 0 1.02.28 1.286.736l2.226 3.818a1.5 1.5 0 0 1 0 1.51l-2.226 3.818a1.5 1.5 0 0 1-1.286.736H6.864a1.5 1.5 0 0 1-1.286-.736l-2.226-3.818a1.5 1.5 0 0 1 0-1.51l2.226-3.818A1.5 1.5 0 0 1 6.864 6ZM9 9.75h6m-6 3h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Ruang Lingkup</span>
            </button>

            <button
                type="button"
                @click="tab = 'alur'"
                :class="tab === 'alur' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'alur' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 15.75 19.5 19.5m0 0-3.75 3.75M19.5 19.5H9A6.75 6.75 0 0 1 2.25 12.75V10.5A6.75 6.75 0 0 1 9 3.75h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Alur Proses</span>
            </button>

            <button
                type="button"
                @click="tab = 'tarif'"
                :class="tab === 'tarif' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'tarif' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14.25 6.75 12m0 0L9 9.75M6.75 12h10.5m3.75-6.75v13.5A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V5.25A2.25 2.25 0 0 1 5.25 3h13.5A2.25 2.25 0 0 1 21 5.25Z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Tarif Layanan</span>
            </button>
        </div>

        <article class="min-h-[70vh] pb-20 sm:pb-[150px]">

        {{-- Tab Content --}}
        <div class="mt-8 transition-all duration-500">
            
            {{-- Tab Ruang Lingkup --}}
            <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="space-y-12">
                    {{-- Paragraf Deskripsi --}}
                    @if($ruangLingkupParagraf)
                        <div class="bg-white rounded-[2.5rem] shadow-xl p-10 border border-slate-100 relative overflow-hidden group">
                            <div class="absolute top-0 left-0 w-2 h-full bg-blue-500"></div>
                        <div class="text-slate-700 text-lg leading-relaxed font-medium space-y-4">
                            {!! $ruangLingkupParagraf->content !!}
                        </div>
                        </div>
                    @else
                         <div class="bg-white rounded-[2.5rem] shadow-xl p-16 text-center border border-slate-100">
                            <p class="text-slate-400 font-medium italic">Informasi ruang lingkup belum tersedia.</p>
                        </div>
                    @endif

                    {{-- Galeri Gambar --}}
                    @if($ruangLingkupImages->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($ruangLingkupImages as $item)
                                <div class="bg-white p-4 rounded-[2rem] shadow-lg border border-slate-100 hover:-translate-y-2 transition duration-500 group">
                                    <div class="aspect-square rounded-2xl overflow-hidden relative bg-slate-50">
                                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-contain group-hover:scale-110 transition duration-700" alt="Gambar Ruang Lingkup">
                                        <div class="absolute inset-0 bg-gradient-to-t from-blue-900/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Alur Proses --}}
            <div x-show="tab === 'alur'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;">
                <div class="grid grid-cols-1 gap-12">
                    @forelse($alur as $item)
                        <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100 group p-2 bg-gradient-to-br from-white to-slate-50">
                            <div class="p-8 md:p-12 flex justify-center items-center">
                                <img src="{{ asset('storage/' . $item->image) }}" class="max-w-full h-auto rounded-2xl shadow-sm group-hover:scale-[1.02] transition duration-1000" alt="Alur Proses">
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-[2.5rem] shadow-xl p-24 text-center border border-slate-100">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <p class="text-slate-400 font-medium italic text-lg">Informasi alur proses belum tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab Tarif --}}
            <div x-show="tab === 'tarif'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;">
                <div class="grid grid-cols-1 gap-12">
                    @if($tarif && $tarif->file_pdf)
                        <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100 group mb-8">
                            <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                                <h3 class="text-xl font-bold text-slate-900 px-4">Dokumen Tarif Resmi</h3>
                                <a href="{{ asset('storage/' . $tarif->file_pdf) }}" target="_blank" class="flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-bold rounded-xl shadow-lg hover:bg-blue-700 transition duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh PDF
                                </a>
                            </div>
                            <div class="bg-slate-800">
                                <iframe src="{{ asset('storage/' . $tarif->file_pdf) }}" class="w-full h-[800px] border-0"></iframe>
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-[2.5rem] shadow-xl p-24 text-center border border-slate-100">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-slate-400 font-medium italic text-lg">Informasi tarif belum tersedia saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </article>
    </main>

</body>
</html>
