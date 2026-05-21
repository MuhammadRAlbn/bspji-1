@props([
    'profileImages',
    'sejarahUrl' => '#',
])

<section id="profil" class="overflow-hidden bg-white py-24">
    <div class="mx-auto max-w-6xl px-6 lg:px-0">
        <div class="flex flex-col items-center gap-16 md:gap-28 lg:flex-row">
            <div class="relative h-[450px] w-full md:h-[550px] lg:w-1/2">
                <div class="absolute left-0 top-10 z-10 h-[300px] w-[70%] md:h-[380px]" data-aos="fade-right"
                    data-aos-duration="1000">
                    <img src="{{ $profileImages[0] }}" alt="Kegiatan 1"
                        class="h-full w-full rounded-2xl border-4 border-white object-cover shadow-xl">
                </div>

                <div class="absolute right-4 top-0 z-20 h-[170px] w-[35%]" data-aos="fade-down" data-aos-delay="300"
                    data-aos-duration="1000">
                    <img src="{{ $profileImages[1] }}" alt="Kegiatan 2"
                        class="h-full w-full rounded-2xl border-4 border-white object-cover shadow-2xl">
                </div>

                <div class="absolute bottom-4 right-10 z-30 h-[220px] w-[45%] md:h-[260px]" data-aos="fade-up"
                    data-aos-delay="500" data-aos-duration="1000">
                    <img src="{{ $profileImages[2] }}" alt="Kegiatan 3"
                        class="h-full w-full rounded-2xl border-4 border-white object-cover shadow-2xl">
                </div>

                <div class="absolute -bottom-8 left-10 -z-10 h-24 w-24 rounded-full bg-gray-100" data-aos="zoom-in"
                    data-aos-delay="700"></div>
            </div>

            <div class="w-full md:w-1/2" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
                <div class="mb-2 flex items-center gap-2">
                    <span class="text-[15px] text-gray-900">■</span>
                    <span class="text-sm font-bold uppercase tracking-[0.3em] text-gray-900">Profil</span>
                </div>

                <h2 class="mb-8 text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">
                    Unit pelayanan teknis di bawah <span
                        class="font-semibold text-gray-800">Kementerian Perindustrian</span>
                </h2>

                <p class="mb-12 text-justify text-lg leading-relaxed text-gray-700/95 md:text-lg">
                    Sebagai perpanjangan tangan dari kementerian perindustrian, Kami mempunyai tugas untuk melaksanakan standardisasi industri, optimalisasi pemanfaatan teknologi industri, industri hijau, dan pelayanan jasa industri berlandaskan potensi sumber daya daerah.
                </p>

                <a href="{{ $sejarahUrl }}"
                    class="group inline-flex items-center gap-2 rounded-full border border-gray-500 px-10 py-3 text-sm font-medium text-gray-800 transition-all duration-500 hover:border-gray-900 hover:bg-gray-900 hover:text-white">
                    Selengkapnya
                    <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    </div>
</section>
