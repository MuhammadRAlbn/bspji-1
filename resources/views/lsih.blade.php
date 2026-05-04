<x-layouts.app title="Laboratorium Sentral Ilmu Hayati - BSPJI Banda Aceh">
<div x-data="{ tab: 'ruang-lingkup' }">
    <header class="relative mb-8 flex h-[300px] w-full items-center overflow-hidden text-white sm:mx-auto sm:mt-5 sm:mb-10 sm:h-[360px] sm:w-[96%] sm:rounded-[25px] md:mt-5 md:h-[400px]">
        <img
            src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&q=80&w=2070"
            alt="Laboratorium Sentral Ilmu Hayati"
            class="absolute inset-0 -z-10 h-full w-full object-cover brightness-[0.7]"
        >
        <div class="mx-auto w-full max-w-[1400px] px-5 text-left sm:px-8 md:px-20">
            <h1 class="text-[2.25rem] font-bold tracking-[-0.03em] sm:text-[3rem] md:text-[4.5rem]">
                Laboratorium Sentral Ilmu Hayati (LSIH)
            </h1>
        </div>
    </header>

    <main class="mx-auto grid max-w-[1400px] grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:sticky lg:top-24 lg:grid-cols-1">
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
                @click="tab = 'alur'"
                :class="tab === 'alur' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-in-out hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'alur' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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

            {{-- Tab Ruang Lingkup --}}
            <div x-show="tab === 'ruang-lingkup'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 gap-12">
                    @forelse($ruangLingkup as $item)
                        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 group">
                            @if($item->image)
                                <div class="p-8 flex justify-center bg-white">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="max-w-full h-auto rounded-2xl shadow-lg group-hover:scale-[1.01] transition duration-700">
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data ruang lingkup belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab Alur --}}
            <div x-show="tab === 'alur'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 gap-12">
                    @forelse($alur as $item)
                        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 group">
                            @if($item->image)
                                <div class="p-8 flex justify-center bg-white">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="max-w-full h-auto rounded-2xl shadow-lg group-hover:scale-[1.01] transition duration-700">
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data alur belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab Tarif --}}
            <div x-show="tab === 'tarif'" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="grid grid-cols-1 gap-12">
                    @forelse($tarif as $item)
                        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 group">
                            @if($item->image)
                                <div class="p-8 flex justify-center bg-white">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="max-w-full h-auto rounded-2xl shadow-lg group-hover:scale-[1.01] transition duration-700">
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white rounded-3xl shadow-xl p-24 text-center border border-gray-100">
                            <p class="text-gray-400 font-medium italic">Data tarif belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </article>
    </main>
</div>
</x-layouts.app>
