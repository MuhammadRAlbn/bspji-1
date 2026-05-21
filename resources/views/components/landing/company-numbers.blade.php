<section id="perusahaan-dalam-angka" class="bg-white py-12 md:pb-16 md:pt-16">
    <div class="mx-auto max-w-6xl px-6 lg:px-0">
        <div class="mb-12 flex flex-col justify-between gap-8 lg:flex-row lg:items-end md:mb-16" data-aos="fade-up">
            <div class="max-w-2xl">
                <div class="mb-2 flex items-center gap-2">
                    <span class="text-[10px] text-orange-600">■</span>
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Data Kinerja</span>
                </div>
                <h2 class="text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">
                    Perusahaan dalam Angka
                </h2>
            </div>
            <div class="lg:max-w-sm lg:pb-2">
                <p class="text-justify text-lg leading-relaxed text-gray-700/95 md:text-lg">
                    Visualisasi data kinerja utama menggunakan diagram batang ringan untuk memudahkan pembacaan tren.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:gap-6 lg:grid-cols-2">
            {{-- 
            <article class="numbers-card" data-aos="fade-up" data-aos-delay="50">
                <div class="mb-2 flex items-start justify-between gap-3 px-2 pt-1">
                    <h3 class="text-base font-semibold text-gray-900 md:text-lg">Survey Persepsi Kualitas Pelayanan (SPKP)</h3>
                    <span class="rounded-full bg-orange-100 px-2.5 py-1 text-[11px] font-semibold text-orange-700">Skala 0-4</span>
                </div>
                <div id="chart-spkp" class="numbers-chart"></div>
            </article>
            <article class="numbers-card" data-aos="fade-up" data-aos-delay="100">
                <div class="mb-2 flex items-start justify-between gap-3 px-2 pt-1">
                    <h3 class="text-base font-semibold text-gray-900 md:text-lg">Survey Persepsi Anti Korupsi</h3>
                    <span class="rounded-full bg-orange-100 px-2.5 py-1 text-[11px] font-semibold text-orange-700">Skala 0-4</span>
                </div>
                <div id="chart-anti-korupsi" class="numbers-chart"></div>
            </article>
            --}}
            <article class="numbers-card" data-aos="fade-up" data-aos-delay="150">
                <div class="mb-2 flex items-start justify-between gap-3 px-2 pt-1">
                    <h3 class="text-base font-semibold text-gray-900 md:text-lg">Jumlah Pelanggan</h3>
                    <span class="rounded-full bg-orange-100 px-2.5 py-1 text-[11px] font-semibold text-orange-700">Skala 0-600</span>
                </div>
                <div id="chart-jumlah-pelanggan" class="numbers-chart"></div>
            </article>
            <article class="numbers-card" data-aos="fade-up" data-aos-delay="200">
                <div class="mb-2 flex items-start justify-between gap-3 px-2 pt-1">
                    <h3 class="text-base font-semibold text-gray-900 md:text-lg">Persentase Standar Pelayanan Minimum</h3>
                    <span class="rounded-full bg-orange-100 px-2.5 py-1 text-[11px] font-semibold text-orange-700">Skala 0-100</span>
                </div>
                <div id="chart-spm" class="numbers-chart"></div>
            </article>
        </div>

        {{--
        <div class="mt-24 md:mt-40" data-aos="fade-up" data-aos-delay="120">
            <div class="relative mb-14" data-aos="fade-up">
                <div class="text-center">
                    <div class="mb-6 flex items-center justify-center gap-2">
                        <span class="text-[10px] text-orange-600">■</span>
                        <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Statistik Layanan</span>
                    </div>
                    <h2 class="section-title-identic text-gray-900">
                        Ringkasan Layanan
                    </h2>
                    <div class="mt-6 md:hidden">
                        <span
                            class="inline-flex items-center rounded-full border border-slate-200 bg-orange-500 px-3 py-1.5 text-xs font-semibold tracking-[0.08em] text-white shadow-sm">
                            2020 - 2026
                        </span>
                    </div>
                </div>
                <div class="absolute bottom-1 right-0 hidden md:block">
                    <span
                        class="inline-flex items-center rounded-full border border-slate-200 bg-orange-500 px-4 py-1.5 text-sm font-semibold tracking-[0.08em] text-white shadow-sm">
                        2020 - 2026
                    </span>
                </div>
            </div>

            <div
                class="grid grid-cols-1 gap-x-6 gap-y-8 rounded-3xl border border-slate-300/80 bg-white px-8 py-16 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.4)] sm:grid-cols-2 lg:grid-cols-5 lg:gap-y-16 md:px-12">
                <article class="text-center">
                    <p class="text-xl tracking-wide text-gray-700">Sertifikasi Produk</p>
                    <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">1.248</p>
                </article>
                <article class="text-center">
                    <p class="text-xl tracking-wide text-gray-700">Sertifikasi Halal</p>
                    <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">986</p>
                </article>
                <article class="text-center">
                    <p class="text-xl tracking-wide text-gray-700">Kalibrasi Alat</p>
                    <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">1.732</p>
                </article>
                <article class="text-center">
                    <p class="text-xl tracking-wide text-gray-700">Industri Hijau</p>
                    <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">642</p>
                </article>
                <article class="text-center">
                    <p class="text-xl tracking-wide text-gray-700">Pengujian</p>
                    <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">2.120</p>
                </article>
                <article class="text-center lg:col-start-2">
                    <p class="text-xl tracking-wide text-gray-700">Verifikasi TKDN</p>
                    <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">895</p>
                </article>
                <article class="text-center lg:col-start-3">
                    <p class="text-xl tracking-wide text-gray-700">Konsultasi Industri</p>
                    <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">734</p>
                </article>
                <article class="text-center lg:col-start-4">
                    <p class="text-xl tracking-wide text-gray-700">Pelatihan Teknis</p>
                    <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">1.184</p>
                </article>
            </div>
        </div>
        --}}
    </div>
</section>
