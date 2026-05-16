@props(['testimonis'])

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

<section class="relative overflow-hidden bg-white py-24 md:pb-32 md:pt-16 align-left-container"
    x-data="{
        currentIndex: 0,
        totalCards: 0,
        maxIndex: 0,
        init() {
            this.totalCards = this.$refs.track.children.length;
            this.calculateMaxIndex();
            window.addEventListener('resize', () => this.calculateMaxIndex());
        },
        calculateMaxIndex() {
            const container = this.$refs.sliderViewport;
            const track = this.$refs.track;
            if (!container || !track || !track.children.length) return;
            const card = track.children[0];
            const gap = 24;
            const cardWidth = card.offsetWidth + gap;
            const visibleCards = Math.floor(container.offsetWidth / cardWidth);
            this.maxIndex = Math.max(0, this.totalCards - visibleCards);
            if (this.currentIndex > this.maxIndex) this.currentIndex = this.maxIndex;
        },
        getTranslateX() {
            const track = this.$refs.track;
            if (!track || !track.children.length) return '0px';
            const card = track.children[0];
            const gap = 24;
            return '-' + (this.currentIndex * (card.offsetWidth + gap)) + 'px';
        },
        scrollNext() { if (this.currentIndex < this.maxIndex) this.currentIndex++; },
        scrollPrev() { if (this.currentIndex > 0) this.currentIndex--; }
    }">

    <div class="relative z-20 flex flex-col gap-10 lg:flex-row lg:gap-20">
        <div class="w-full shrink-0 pr-6 lg:w-[380px] lg:pr-0">
            <div class="flex flex-col pt-12">
                <div>
                    <div class="mb-2 flex items-center gap-2">
                        <span class="text-[10px] text-orange-600">■</span>
                        <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Testimoni Pelanggan</span>
                    </div>
                    <h2 class="mb-6 text-2xl font-semibold leading-[1.2] text-slate-900 md:text-[30px] lg:mb-8">
                        Testimoni Pelanggan
                    </h2>
                    <p class="text-base font-light leading-relaxed text-gray-800 md:text-lg">
                        Kepercayaan Anda adalah prioritas kami dalam mendukung kemajuan industri nasional.
                    </p>
                </div>
                <div class="mt-10 flex gap-4">
                    <button @click="scrollPrev"
                        :class="currentIndex === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100'"
                        class="flex h-11 w-11 items-center justify-center rounded-full border border-slate-300 text-slate-900 transition-all active:scale-90">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                    <button @click="scrollNext"
                        :class="currentIndex >= maxIndex ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100'"
                        class="flex h-11 w-11 items-center justify-center rounded-full border border-slate-300 text-slate-900 transition-all active:scale-90">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-ref="sliderViewport" class="grow overflow-hidden">
            <div x-ref="track" :style="'transform: translateX(' + getTranslateX() + ')'"
                class="flex gap-6 pb-12 pt-12 transition-transform duration-500 ease-[cubic-bezier(0.25,0.1,0.25,1)]">
                @forelse ($testimonis as $testimoni)
                    <div class="relative h-[460px] min-w-[82%] snap-start overflow-hidden rounded-[40px] border border-gray-200 bg-white p-8 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.45)] md:h-[500px] md:min-w-[440px] md:p-10">
                        <div class="relative z-10 flex h-full flex-col">
                            <div class="mb-8 flex items-center gap-5">
                                @if ($testimoni->gambar_pelanggan)
                                    <div class="h-16 w-16 overflow-hidden rounded-2xl shadow-md">
                                        <img src="{{ Storage::url($testimoni->gambar_pelanggan) }}" alt="{{ $testimoni->nama }}"
                                            class="h-full w-full object-cover">
                                    </div>
                                @else
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-xl font-bold text-blue-700 shadow-md">
                                        {{ Str::substr($testimoni->nama, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900">{{ $testimoni->nama }}</h4>
                                    <p class="text-sm font-medium text-blue-600">{{ $testimoni->jabatan }}</p>
                                    <p class="text-xs font-medium text-gray-400">{{ $testimoni->nama_perusahaan }}</p>
                                </div>
                            </div>

                            <p class="text-[16px] italic leading-relaxed text-gray-600 md:text-[18px]">
                                "{{ $testimoni->pesan }}"
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="relative h-[460px] min-w-[82%] snap-start overflow-hidden rounded-[40px] bg-white p-8 shadow-xl md:h-[500px] md:min-w-[440px] md:p-10">
                        <p class="text-[16px] italic leading-relaxed text-gray-600 md:text-[18px]">
                            "Testimoni akan muncul setelah data ditambahkan pada admin panel."
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
