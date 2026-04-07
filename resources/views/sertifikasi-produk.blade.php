<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikasi Produk - BSPJI Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="max-w-6xl mx-auto px-4 py-16" x-data="{ tab: 'sertifikat' }">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-widest mb-4 inline-block">Layanan Unggulan</span>
            <h1 class="text-5xl font-extrabold text-green-950 mb-4 tracking-tight">Sertifikasi Produk (LSPro)</h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">Penyediaan jasa sertifikasi mutu produk (SNI) untuk menjamin kualitas dan daya saing produk industri Anda.</p>
        </div>

        {{-- Navigasi Tab --}}
        <div class="flex justify-center mb-12">
            <nav class="inline-flex p-1.5 bg-gray-200/80 backdrop-blur-sm rounded-2xl border border-gray-300/50">
                <button 
                    @click="tab = 'alur'" 
                    :class="tab === 'alur' ? 'bg-white text-green-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Alur
                </button>
                <button 
                    @click="tab = 'sertifikat'" 
                    :class="tab === 'sertifikat' ? 'bg-white text-green-900 shadow-md ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Sertifikat
                </button>
                <button 
                    @click="tab = 'ruang-lingkup'" 
                    :class="tab === 'ruang-lingkup' ? 'bg-white text-green-900 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-300/50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 focus:outline-none flex items-center"
                >
                    Ruang Lingkup
                </button>
            </nav>
        </div>

        {{-- Konten Tab --}}
        <div class="mt-8 transition-all duration-300">
            
            {{-- Tab Alur --}}
            <div x-show="tab === 'alur'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-green-950 uppercase tracking-tight">Alur Sertifikasi Produk</h2>
                    </div>
                    
                    @if($alurProduk && $alurProduk->image)
                        <div class="flex justify-center bg-gray-50 rounded-2xl p-4">
                            <img src="{{ asset('storage/' . $alurProduk->image) }}" alt="Alur Sertifikasi" class="max-w-full h-auto rounded-xl shadow-lg border-2 border-white">
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 py-24 text-center">
                            <p class="text-gray-400 font-medium italic">Data alur sertifikasi belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Sertifikat --}}
            <div x-show="tab === 'sertifikat'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-green-950 uppercase tracking-tight">Sertifikat Akreditasi LSPro</h2>
                    </div>
                    
                    @if($sertifikats->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($sertifikats as $sert)
                                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300 text-center">
                                    <img src="{{ asset('storage/' . $sert->image) }}" class="w-full h-auto rounded-xl shadow-inner border border-gray-200 transition duration-500 hover:scale-[1.01]">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 py-24 text-center">
                            <p class="text-gray-400 font-medium italic">Gambar sertifikat belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Ruang Lingkup --}}
            <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($ruangLingkup as $item)
                        <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-gray-100 flex flex-col group hover:-translate-y-2 transition duration-500">
                            @if($item->image)
                                <div class="h-64 overflow-hidden relative p-4 bg-gray-50">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-700">
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        {{-- Footer/Back Link --}}
        <div class="mt-24 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center px-8 py-3 bg-white text-green-900 font-bold rounded-2xl shadow-lg border border-gray-100 hover:bg-green-50 transition duration-300 group"> 
                <svg class="w-5 h-5 mr-3 transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda 
            </a>
        </div>
    </div>

</body>
</html>
