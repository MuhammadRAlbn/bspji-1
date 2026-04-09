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
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <div class="max-w-6xl mx-auto px-4 py-16" x-data="{ tab: 'ruang-lingkup' }">
        {{-- Header Section --}}
        <div class="text-center mb-16">
            <span class="px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full uppercase tracking-widest mb-4 inline-block">Layanan Teknis</span>
            <h1 class="text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">Konsultasi dan Pendampingan</h1>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">Penyediaan jasa konsultasi dan pendampingan teknis untuk mendukung peningkatan produktivitas dan kualitas industri.</p>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex justify-center mb-12">
            <nav class="inline-flex p-1.5 bg-slate-200/80 backdrop-blur-md rounded-2xl border border-slate-300/50 shadow-sm">
                <button 
                    @click="tab = 'ruang-lingkup'" 
                    :class="tab === 'ruang-lingkup' ? 'bg-white text-blue-900 shadow-lg ring-1 ring-black/5' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-300/50'"
                    class="px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Ruang Lingkup
                </button>
                <button 
                    @click="tab = 'alur'" 
                    :class="tab === 'alur' ? 'bg-white text-blue-900 shadow-lg ring-1 ring-black/5' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-300/50'"
                    class="px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Alur Proses
                </button>
            </nav>
        </div>

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
        </div>
        
        {{-- Footer navigation --}}
        <div class="mt-24 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center px-8 py-3.5 bg-white text-slate-900 font-bold rounded-2xl shadow-lg border border-slate-100 hover:bg-slate-50 transition duration-300 group"> 
                <svg class="w-5 h-5 mr-3 transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda 
            </a>
        </div>
    </div>

</body>
</html>
