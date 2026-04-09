<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelatihan Teknis - BSPJI Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-6xl mx-auto px-4 py-16" x-data="{ tab: 'ruang-lingkup' }">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full uppercase tracking-widest mb-4 inline-block">Layanan Teknis</span>
            <h1 class="text-5xl font-extrabold text-blue-950 mb-4 tracking-tight">Pelatihan Teknis</h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">Pengembangan kompetensi sumber daya manusia industri melalui pelatihan teknis yang terakreditasi dan profesional.</p>
        </div>

        {{-- Navigasi Tab --}}
        <div class="flex justify-center mb-12">
            <nav class="inline-flex p-1.5 bg-gray-200/80 backdrop-blur-sm rounded-2xl border border-gray-300/50">
                <button 
                    @click="tab = 'ruang-lingkup'" 
                    :class="tab === 'ruang-lingkup' ? 'bg-white text-blue-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Ruang Lingkup dan Tarif
                </button>
                <button 
                    @click="tab = 'alur'" 
                    :class="tab === 'alur' ? 'bg-white text-blue-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Alur
                </button>
            </nav>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8 transition-all duration-300">
            
            {{-- Tab Ruang Lingkup --}}
            <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 gap-12">
                    @if($ruangLingkup && $ruangLingkup->image)
                        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 group">
                            <div class="p-8 flex justify-center bg-white">
                                <img src="{{ asset('storage/' . $ruangLingkup->image) }}" alt="Ruang Lingkup dan Tarif Pelatihan Teknis" class="max-w-full h-auto rounded-2xl shadow-lg group-hover:scale-[1.01] transition duration-700">
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data ruang lingkup dan tarif Pelatihan Teknis belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Alur --}}
            <div x-show="tab === 'alur'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 gap-12">
                    @if($alur && $alur->image)
                        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 group">
                            <div class="p-8 flex justify-center bg-white">
                                <img src="{{ asset('storage/' . $alur->image) }}" alt="Alur Pelatihan Teknis" class="max-w-full h-auto rounded-2xl shadow-lg group-hover:scale-[1.01] transition duration-700">
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data alur Pelatihan Teknis belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Footer/Back Link --}}
        <div class="mt-24 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center px-8 py-3 bg-white text-blue-900 font-bold rounded-2xl shadow-lg border border-gray-100 hover:bg-blue-50 transition duration-300 group"> 
                <svg class="w-5 h-5 mr-3 transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda 
            </a>
        </div>
    </div>

</body>
</html>
