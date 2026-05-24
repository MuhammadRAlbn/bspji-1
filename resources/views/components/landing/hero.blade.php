@php
    $heroSlides = [
        [
            'type' => 'video',
            'src' => asset('video/videocrop.webm'),
            'kicker' => 'BSPJI Banda Aceh',
            'title' => 'Mewujudkan Industri Nasional yang Mandiri dan Berdaya Saing',
            'description' => 'Mitra layanan teknis untuk standardisasi, pengujian, sertifikasi, konsultasi, dan penguatan daya saing industri.',
            'cta_label' => 'Jelajahi Layanan Kami',
            'cta_url' => '#layanan',
        ],
        [
            'type' => 'custom_wbk',
        ],
        [
            'type' => 'custom_maklumat',
        ],
    ];
@endphp

<div class="relative flex h-screen min-h-[640px] w-full flex-col">
    <header
        x-data="{
            activeSlide: 0,
            progress: 0,
            duration: 6500,
            frame: null,
            startedAt: 0,
            slideCount: {{ count($heroSlides) }},
            init() {
                this.startTimer();
            },
            startTimer() {
                this.stopTimer();
                this.startedAt = performance.now();
                this.progress = 0;
                this.tick();
            },
            stopTimer() {
                if (this.frame) {
                    cancelAnimationFrame(this.frame);
                    this.frame = null;
                }
            },
            tick() {
                const elapsed = performance.now() - this.startedAt;
                this.progress = Math.min((elapsed / this.duration) * 100, 100);

                if (this.progress >= 100) {
                    this.next();
                    return;
                }

                this.frame = requestAnimationFrame(() => this.tick());
            },
            setSlide(index) {
                this.activeSlide = index;
                this.startTimer();
            },
            next() {
                this.activeSlide = (this.activeSlide + 1) % this.slideCount;
                this.startTimer();
            },
        }"
        class="group relative h-full w-full grow overflow-hidden bg-black"
        aria-label="Informasi utama BSPJI Banda Aceh">
        @foreach ($heroSlides as $index => $slide)
            @if ($slide['type'] === 'video')
                <video
                    class="absolute inset-0 h-full w-full object-cover transition-opacity duration-700 ease-out"
                    style="opacity: {{ $index === 0 ? '.8' : '0' }};"
                    :style="activeSlide === {{ $index }} ? 'opacity: .8;' : 'opacity: 0;'"
                    autoplay
                    muted
                    loop
                    playsinline
                    preload="metadata">
                    <source src="{{ $slide['src'] }}" type="video/webm">
                </video>
            @elseif ($slide['type'] === 'image')
                <img
                    src="{{ $slide['src'] }}"
                    alt="{{ $slide['alt'] }}"
                    class="absolute inset-0 h-full w-full object-cover transition-opacity duration-700 ease-out"
                    style="opacity: {{ $index === 0 ? '.85' : '0' }};"
                    :style="activeSlide === {{ $index }} ? 'opacity: .85;' : 'opacity: 0;'"
                    @if ($index === 1) fetchpriority="high" @else loading="lazy" @endif>
            @elseif ($slide['type'] === 'custom_wbk' || $slide['type'] === 'custom_maklumat')
                <div 
                    class="absolute inset-0 h-full w-full bg-gray-900 transition-opacity duration-700 ease-out overflow-hidden"
                    style="opacity: {{ $index === 0 ? '1' : '0' }};"
                    :style="activeSlide === {{ $index }} ? 'opacity: 1;' : 'opacity: 0;'">
                    <!-- Decorative blurred blobs for dark bg -->
                    <div class="absolute -top-[20%] -left-[10%] h-[600px] w-[600px] rounded-full bg-red-900/20 blur-[100px]"></div>
                    <div class="absolute top-[20%] -right-[10%] h-[500px] w-[500px] rounded-full bg-blue-900/20 blur-[100px]"></div>
                    <!-- Subtle grid pattern -->
                    <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:32px_32px]"></div>
                </div>
            @endif
        @endforeach

        <div class="absolute inset-0 bg-linear-to-t from-black via-black/45 to-black/10 transition-opacity duration-700" :style="(activeSlide === 1 || activeSlide === 2) ? 'opacity: 0;' : 'opacity: 1;'"></div>
        <div class="absolute inset-y-0 left-0 w-full bg-linear-to-r from-black/70 via-black/20 to-transparent transition-opacity duration-700" :style="(activeSlide === 1 || activeSlide === 2) ? 'opacity: 0;' : 'opacity: 1;'"></div>

        <div class="relative z-20 mx-auto flex h-full w-full max-w-[1430px] flex-col justify-end px-6 pb-28 lg:px-8 2xl:px-0">
            <div class="grid w-full items-end" data-aos="fade-up" data-aos-duration="1000">
            @foreach ($heroSlides as $index => $slide)
                <div
                    class="col-start-1 row-start-1 w-full transition-opacity duration-500 ease-out"
                    style="opacity: {{ $index === 0 ? '1' : '0' }}; visibility: {{ $index === 0 ? 'visible' : 'hidden' }};"
                    :style="activeSlide === {{ $index }} ? 'opacity: 1; visibility: visible;' : 'opacity: 0; visibility: hidden;'"
                    :class="activeSlide === {{ $index }} ? 'pointer-events-auto' : 'pointer-events-none'"
                    :aria-hidden="activeSlide !== {{ $index }}">
                    @if ($slide['type'] === 'custom_wbk')
                        <div class="flex items-center justify-center w-full h-full pb-0 pt-0 md:pb-12 md:pt-16 mt-16 md:mt-0">
                            <!-- White Card Container -->
                            <div class="relative w-full max-w-5xl bg-white/95 backdrop-blur-xl rounded-2xl md:rounded-[2rem] shadow-2xl p-6 md:p-12 lg:p-16 border border-white/20 mx-auto transform transition-all duration-700 ease-out"
                                 :class="activeSlide === {{ $index }} ? 'translate-y-0 opacity-100 scale-100' : 'translate-y-8 opacity-0 scale-95'">
                                <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-16">
                                    <div class="w-full max-w-[140px] md:max-w-[280px] md:w-5/12 flex justify-center md:justify-end">
                                        <div class="relative group cursor-default">
                                            <div class="absolute inset-0 rounded-full bg-red-100/60 blur-3xl transition-all duration-700 group-hover:bg-red-200/80"></div>
                                            <img src="{{ asset('images/hero/WBK.png') }}" alt="Zona Integritas WBK" class="relative z-10 w-full h-auto object-contain drop-shadow-2xl transition-transform duration-700 ease-out group-hover:scale-105" />
                                        </div>
                                    </div>
                                    <div class="w-full md:w-7/12 flex flex-col justify-center text-center md:text-left">
                                        <div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-3 py-1 md:px-4 md:py-1.5 text-[10px] md:text-xs font-semibold tracking-wide text-gray-600 shadow-xs mb-3 md:mb-6 mx-auto md:mx-0 w-fit">
                                            <span class="relative flex h-2 w-2">
                                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                              <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                            </span>
                                            Fokus Utama Kami
                                        </div>
                                        <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold mb-2 md:mb-5 leading-[1.15] tracking-tight text-gray-900">
                                            Anda Memasuki<br>
                                            <span class="text-transparent bg-clip-text bg-linear-to-r from-red-600 to-red-400 drop-shadow-sm">ZONA INTEGRITAS</span>
                                        </h2>
                                        <p class="text-xs md:text-lg font-medium text-gray-600 max-w-xl mx-auto md:mx-0 leading-relaxed">
                                            BSPJI Banda Aceh Menuju Wilayah Bebas Korupsi (WBK) & Wilayah Birokrasi Bersih dan Melayani (WBBM)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($slide['type'] === 'custom_maklumat')
                        <div class="flex items-center justify-center w-full h-full pb-0 pt-0 md:pb-12 md:pt-16 mt-16 md:mt-0">
                            <!-- White Card Container -->
                            <div class="relative w-full max-w-5xl bg-white/95 backdrop-blur-xl rounded-2xl md:rounded-[2rem] shadow-2xl p-6 md:p-12 lg:p-16 border border-white/20 mx-auto transform transition-all duration-700 ease-out"
                                 :class="activeSlide === {{ $index }} ? 'translate-y-0 opacity-100 scale-100' : 'translate-y-8 opacity-0 scale-95'">
                                <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-16">
                                    <div class="w-full max-w-[140px] md:max-w-[280px] md:w-5/12 flex justify-center md:justify-end">
                                        <div class="relative group cursor-default">
                                            <div class="absolute inset-0 rounded-full bg-red-100/60 blur-3xl transition-all duration-700 group-hover:bg-red-200/80"></div>
                                            <img src="{{ asset('images/hero/maklumat.webp') }}" alt="Maklumat Pelayanan BSPJI Banda Aceh" class="relative z-10 w-full h-auto object-contain drop-shadow-2xl transition-transform duration-700 ease-out group-hover:scale-105" />
                                        </div>
                                    </div>
                                    <div class="w-full md:w-7/12 flex flex-col justify-center text-center md:text-left">
                                        <div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-3 py-1 md:px-4 md:py-1.5 text-[10px] md:text-xs font-semibold tracking-wide text-gray-600 shadow-xs mb-3 md:mb-6 mx-auto md:mx-0 w-fit">
                                            <span class="relative flex h-2 w-2">
                                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                              <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                            </span>
                                            Komitmen Kami
                                        </div>
                                        <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold mb-2 md:mb-5 leading-[1.15] tracking-tight text-gray-900">
                                            Maklumat Pelayanan<br>
                                            BSPJI BANDA ACEH
                                        </h2>
                                        <p class="text-xs md:text-lg font-medium text-gray-600 max-w-xl mx-auto md:mx-0 leading-relaxed">
                                            Kami melayani industri sepenuh hati
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="max-w-3xl">
                            <p class="mb-4 text-sm font-semibold uppercase tracking-[0.22em] text-white/70">
                                {{ $slide['kicker'] }}
                            </p>
                            <h1 class="mb-6 text-3xl leading-[1.1] tracking-tight text-white md:text-5xl">
                                {{ $slide['title'] }}
                            </h1>
                            <p class="mb-9 max-w-2xl text-base font-light leading-relaxed text-white/80 md:text-xl">
                                {{ $slide['description'] }}
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ $slide['cta_url'] }}"
                                    class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-8 py-3 text-md font-semibold text-white backdrop-blur-md transition-all hover:bg-white/20">
                                    {{ $slide['cta_label'] }}
                                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 z-30 w-full max-w-[1430px] -translate-x-1/2 px-6 lg:px-8 2xl:px-0">
            <div class="flex items-center gap-3">
                @foreach ($heroSlides as $index => $slide)
                    <button
                        type="button"
                        @click="setSlide({{ $index }})"
                        class="group/progress h-8 flex-1 rounded-full py-3 text-left focus:outline-none"
                        aria-label="Tampilkan slide {{ $index + 1 }}">
                        <span class="block h-1 overflow-hidden rounded-full bg-white/25">
                            <span
                                class="block h-full rounded-full bg-white transition-[width] duration-100 ease-linear"
                                :style="`width: ${activeSlide > {{ $index }} ? 100 : (activeSlide === {{ $index }} ? progress : 0)}%`"></span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    </header>
</div>
