<x-layouts.app title="Layanan Kalibrasi">
<div x-data="{ tab: 'sertifikasi' }">
    <header class="relative mb-8 flex h-[300px] w-full items-center overflow-hidden text-white sm:mx-auto sm:mt-5 sm:mb-10 sm:h-[360px] sm:w-[96%] sm:rounded-[25px] md:mt-5 md:h-[400px]">
        <img
            src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80&w=2070"
            alt="Layanan Kalibrasi"
            class="absolute inset-0 -z-10 h-full w-full object-cover brightness-[0.7]"
        >
        <div class="mx-auto w-full max-w-[1400px] px-5 text-left sm:px-8 md:px-20">
            <h1 class="text-[2.25rem] font-bold tracking-[-0.03em] sm:text-[3rem] md:text-[4.5rem]">
                Layanan Kalibrasi
            </h1>
        </div>
    </header>

    <div class="mx-auto grid max-w-[1400px] grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1">
            <button
                type="button"
                @click="tab = 'sertifikasi'"
                :class="tab === 'sertifikasi' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'sertifikasi' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75m5.25 2.814c0 4.285-2.924 8.032-7.087 9.063a1.38 1.38 0 0 1-.326.037 1.38 1.38 0 0 1-.326-.037C8.348 20.596 5.424 16.85 5.424 12.564V7.902c0-.67.423-1.267 1.056-1.491l5.25-1.867a1.37 1.37 0 0 1 .913 0l5.25 1.867c.633.224 1.056.82 1.056 1.49v4.663Z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Sertifikasi</span>
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
                @click="tab = 'alur-kalibrasi'"
                :class="tab === 'alur-kalibrasi' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'alur-kalibrasi' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 15.75 19.5 19.5m0 0-3.75 3.75M19.5 19.5H9A6.75 6.75 0 0 1 2.25 12.75V10.5A6.75 6.75 0 0 1 9 3.75h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Alur</span>
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
        </div>

        <article class="min-h-[70vh] pb-20 sm:pb-[150px]">
            
            {{-- Tab Alur Kalibrasi --}}
            <div x-show="tab === 'alur-kalibrasi'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-indigo-950 uppercase tracking-tight">Alur Layanan Kalibrasi</h2>
                    </div>
                    
                    @if($alurKalibrasi && $alurKalibrasi->image)
                        <div class="flex justify-center bg-gray-50 rounded-2xl p-4">
                            <img src="{{ asset('storage/' . $alurKalibrasi->image) }}" alt="Alur Kalibrasi" class="max-w-full h-auto rounded-xl shadow-lg border-2 border-white">
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 py-24 text-center">
                            <p class="text-gray-400 font-medium italic">Data alur layanan belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab Sertifikasi --}}
            <div x-show="tab === 'sertifikasi'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-10">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-indigo-950 uppercase tracking-tight">Sertifikat Akreditasi</h2>
                    </div>
                    
                    @if($sertifikasis->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($sertifikasis as $sert)
                                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
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
                    @forelse($ruangLingkupan as $item)
                        <div class="bg-white rounded-4xl shadow-xl overflow-hidden border border-gray-100 flex flex-col group hover:-translate-y-2 transition duration-500">
                            @if($item->image)
                                <div class="h-52 overflow-hidden relative">
                                    <div class="absolute inset-0 bg-indigo-900/10 group-hover:bg-transparent transition duration-500 z-10"></div>
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                </div>
                            @endif
                            <div class="p-8 grow">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-full uppercase tracking-widest mb-3 inline-block">Scope</span>
                                <h3 class="text-2xl font-extrabold text-indigo-950 mb-6 leading-tight">{{ $item->title }}</h3>
                                <ul class="space-y-4">
                                    @foreach($item->details ?? [] as $detail)
                                        <li class="flex items-start">
                                            <div class="p-1 bg-green-100 rounded-full mr-3 mt-0.5">
                                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <span class="text-gray-600 text-sm font-medium leading-relaxed">{{ is_array($detail) ? ($detail['name'] ?? '-') : $detail }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab Tarif --}}
            <div x-show="tab === 'tarif'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($ruangLingkupan as $item)
                        <div class="bg-white rounded-4xl shadow-xl overflow-hidden border border-gray-100 flex flex-col group hover:shadow-indigo-900/5 transition duration-500">
                            @if($item->image)
                                <div class="h-32 overflow-hidden relative">
                                    <div class="absolute inset-0 bg-gray-900/40 z-10"></div>
                                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover blur-[1px] opacity-60">
                                    <div class="absolute inset-0 z-20 flex items-center justify-center">
                                        <h4 class="text-white font-extrabold text-center px-4 tracking-wide uppercase text-sm">{{ $item->title }}</h4>
                                    </div>
                                </div>
                            @endif
                            <div class="p-8 grow bg-white">
                                <div class="space-y-3">
                                    @foreach($item->details ?? [] as $detail)
                                        @if(is_array($detail))
                                            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-md transition duration-200">
                                                <span class="text-gray-700 text-xs font-bold leading-snug pr-3">{{ $detail['name'] ?? '-' }}</span>
                                                <span class="text-indigo-700 text-sm font-extrabold whitespace-nowrap bg-white px-3 py-1.5 rounded-lg shadow-sm border border-gray-100">Rp {{ number_format($detail['price'] ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data daftar tarif belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </article>
    </div>
</div>
</x-layouts.app>
