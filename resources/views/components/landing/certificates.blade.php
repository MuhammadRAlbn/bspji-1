@props([
    'certificateBgImage',
    'certificateItems',
])

{{-- 
<section id="sertifikat" class="relative overflow-hidden border-y border-slate-300 bg-slate-50 py-12 md:pb-16 md:pt-16">

    <div class="relative mx-auto max-w-6xl px-6 lg:px-0">
        <div class="mb-12 max-w-4xl md:mb-16" data-aos="fade-up">
            <div class="mb-2 flex items-center gap-2">
                <span class="text-[10px] text-orange-600">■</span>
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Sertifikat</span>
            </div>
            <h2 class="mb-6 text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">
                Sertifikat Akreditasi Layanan Kami
            </h2>
        </div>

        @if ($sertifikats->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-slate-600">
                Data sertifikat belum tersedia.
            </div>
        @else
            <div class="flex flex-wrap justify-center gap-x-4 gap-y-10 md:gap-x-5 md:gap-y-16">
                @foreach ($sertifikats as $index => $sertifikat)
                    @php
                        $image = $sertifikat->gambar ? Storage::url($sertifikat->gambar) : null;
                        $title = $sertifikat->nama_sertifikat ?: 'Sertifikat';
                    @endphp
                    @if ($image)
                        <button type="button" data-certificate-trigger data-src="{{ $image }}"
                            data-title="{{ $title }}"
                            class="certificate-card group text-left transition-all duration-300 hover:-translate-y-1"
                            data-aos="fade-up" data-aos-delay="{{ 50 + ($index % 8) * 50 }}">
                            <div class="certificate-media relative aspect-4/3">
                                <img src="{{ $image }}" alt="{{ $title }}"
                                    class="h-full w-full object-cover object-top transition-transform duration-700 group-hover:scale-105">
                            </div>
                            <div class="certificate-title-wrap">
                                <h3 class="certificate-title text-base font-semibold text-slate-900">{{ $title }}</h3>
                            </div>
                        </button>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</section>
--}}

<section id="sertifikat-2" class="relative w-full overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ $certificateBgImage }}" alt="" class="h-full w-full object-cover" aria-hidden="true">
        <div class="absolute inset-0 bg-black/30 lg:hidden"></div>
        <div class="absolute inset-0 hidden bg-linear-to-r from-black/60 via-black/30 to-transparent lg:block"></div>
    </div>

    <div class="relative z-10 grid min-h-[700px] grid-cols-1 lg:grid-cols-[42%_58%]">
        {{-- Left side: dark overlay + text --}}
        <div class="relative flex flex-col justify-center px-8 py-16 md:px-12 lg:px-16 lg:py-24">
            <div class="relative z-10 max-w-lg" data-aos="fade-right" data-aos-duration="1000">
                <div class="mb-3 flex items-center gap-2">
                    <span class="text-[10px] text-orange-400">■</span>
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-orange-400">Akreditasi</span>
                </div>
                <h2 class="mb-6 text-3xl font-semibold leading-[1.15] tracking-tight text-white md:text-4xl lg:text-[42px]">
                    Sertifikat Akreditasi Layanan Kami
                </h2>
                <p class="mb-8 text-base leading-relaxed text-white/80 md:text-lg">
                    Seluruh layanan yang kami sediakan telah terakreditasi oleh lembaga yang berwenang, menjamin mutu dan keandalan hasil pengujian, kalibrasi, serta sertifikasi yang kami berikan.
                </p>
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 backdrop-blur-sm">
                        <i data-lucide="shield-check" class="h-5 w-5 text-orange-400"></i>
                    </span>
                    <span class="text-sm font-medium text-white/70">Terjamin & Terpercaya</span>
                </div>
            </div>
        </div>

        {{-- Right side: 3x3 certificate grid --}}
        <div class="relative flex items-center justify-center px-6 py-12 md:px-10 lg:pl-8 lg:pr-20 lg:py-16">
            @if ($certificateItems->isEmpty())
                <div class="w-full rounded-2xl border border-dashed border-white/30 bg-white/10 p-8 text-center text-white/70 backdrop-blur-sm">
                    Data sertifikat belum tersedia.
                </div>
            @else
                <div class="mx-auto grid w-full max-w-md grid-cols-2 gap-4 sm:max-w-xl sm:grid-cols-3 md:gap-6 lg:max-w-[85%]">
                    @foreach ($certificateItems->take(9) as $index => $certificate)
                        <button type="button" data-certificate-trigger data-certificate-variant="compact" data-src="{{ $certificate['image_url'] }}"
                            data-title="{{ $certificate['title'] }}"
                            class="group text-center transition-all duration-300 hover:-translate-y-1"
                            data-aos="fade-up" data-aos-delay="{{ 80 + ($index % 9) * 60 }}">
                            <div class="relative aspect-4/3 overflow-hidden rounded-xl border border-white/20 bg-white shadow-[0_8px_24px_-8px_rgba(0,0,0,0.5)]">
                                <img src="{{ $certificate['image_url'] }}" alt="{{ $certificate['title'] }}"
                                    class="h-full w-full object-cover object-top transition-transform duration-700 group-hover:scale-105">
                            </div>
                            <div class="mt-3 px-1">
                                <h3 class="line-clamp-2 text-[13.5px] font-semibold leading-tight text-white drop-shadow-md">{{ $certificate['title'] }}</h3>
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
