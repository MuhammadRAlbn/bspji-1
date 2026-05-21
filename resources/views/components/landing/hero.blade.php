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
            'type' => 'image',
            'src' => asset('header_pengujian.webp'),
            'alt' => 'Aktivitas layanan pengujian BSPJI Banda Aceh',
            'kicker' => 'Layanan Pengujian',
            'title' => 'Pengujian Mutu untuk Keputusan Industri yang Lebih Pasti',
            'description' => 'Dukungan laboratorium dan tenaga teknis untuk memastikan produk memenuhi kebutuhan standar mutu.',
            'cta_label' => 'Lihat Layanan',
            'cta_url' => '#layanan',
        ],
        [
            'type' => 'image',
            'src' => asset('images/imagelab.webp'),
            'alt' => 'Fasilitas laboratorium BSPJI Banda Aceh',
            'kicker' => 'Fasilitas Teknis',
            'title' => 'Laboratorium dan Pendampingan untuk Industri yang Tumbuh',
            'description' => 'Akses informasi cepat terkait fasilitas, layanan, dan dukungan teknis bagi pelaku industri.',
            'cta_label' => 'Kenali Profil Kami',
            'cta_url' => '#profil',
        ],
        [
            'type' => 'image',
            'src' => asset('images/udara1.jpeg'),
            'alt' => 'Pemantauan alat pengujian udara',
            'kicker' => 'Informasi Cepat',
            'title' => 'Solusi Standardisasi dari Pengujian hingga Sertifikasi',
            'description' => 'Temukan jalur layanan yang sesuai untuk kebutuhan standardisasi, konsultasi, dan sertifikasi produk.',
            'cta_label' => 'Mulai Konsultasi',
            'cta_url' => '#whatsapp-cta',
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
                    playsinline>
                    <source src="{{ $slide['src'] }}" type="video/webm">
                </video>
            @else
                <img
                    src="{{ $slide['src'] }}"
                    alt="{{ $slide['alt'] }}"
                    class="absolute inset-0 h-full w-full object-cover transition-opacity duration-700 ease-out"
                    style="opacity: {{ $index === 0 ? '.85' : '0' }};"
                    :style="activeSlide === {{ $index }} ? 'opacity: .85;' : 'opacity: 0;'">
            @endif
        @endforeach

        <div class="absolute inset-0 bg-linear-to-t from-black via-black/45 to-black/10"></div>
        <div class="absolute inset-y-0 left-0 w-full bg-linear-to-r from-black/70 via-black/20 to-transparent"></div>

        <div class="relative z-20 mx-auto flex h-full w-full max-w-[1430px] flex-col justify-end px-6 pb-28 lg:px-8 2xl:px-0">
            <div class="grid w-full items-end" data-aos="fade-up" data-aos-duration="1000">
            @foreach ($heroSlides as $index => $slide)
                <div
                    class="col-start-1 row-start-1 max-w-3xl transition-opacity duration-500 ease-out"
                    style="opacity: {{ $index === 0 ? '1' : '0' }}; visibility: {{ $index === 0 ? 'visible' : 'hidden' }};"
                    :style="activeSlide === {{ $index }} ? 'opacity: 1; visibility: visible;' : 'opacity: 0; visibility: hidden;'"
                    :class="activeSlide === {{ $index }} ? 'pointer-events-auto' : 'pointer-events-none'"
                    :aria-hidden="activeSlide !== {{ $index }}">
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
