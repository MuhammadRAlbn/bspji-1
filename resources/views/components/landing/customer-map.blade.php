<section id="peta-pelanggan" class="bg-white pb-24 pt-16 md:pb-16 md:pt-24">
    <div class="mx-auto max-w-6xl px-6 lg:px-0">
        <div class="mb-10 md:mb-14" data-aos="fade-up">
            <div class="grid grid-cols-1 items-start gap-6 md:gap-8 lg:grid-cols-12">
                <div class="lg:col-span-7">
                    <div class="mb-2 flex items-center gap-2">
                        <span class="text-[10px] text-orange-600">■</span>
                        <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Customer Intelligence</span>
                    </div>
                    <h2 class="text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">Peta Penyebaran Pelanggan</h2>
                </div>
                <div class="lg:col-span-5">
                    <p class="text-justify text-lg leading-relaxed text-gray-700/95 md:text-lg lg:pt-2">
                        Visualisasi interaktif sebaran pelanggan pada wilayah Indonesia. Arahkan kursor ke titik kota/kabupaten untuk melihat jumlah pelanggan.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:gap-6 xl:grid-cols-[minmax(0,1.7fr)_minmax(300px,1fr)]">
            <article class="map-distribution-card self-start p-3 md:p-4" data-aos="fade-up" data-aos-delay="40">
                <div id="customer-distribution-map" class="relative z-0"></div>
            </article>

            <aside class="flex flex-col gap-5 lg:pl-4" data-aos="fade-up" data-aos-delay="90">
                <div class="rounded-2xl bg-linear-to-br from-orange-500 to-orange-600 p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.4)]">
                    <p class="mb-1 text-xs font-bold uppercase tracking-[0.22em] text-white/80">Total Pelanggan</p>
                    <div class="flex items-baseline gap-2">
                        <p id="map-total-customers" class="text-4xl font-bold tracking-tight text-white">0</p>
                        <p class="text-xs font-medium text-white/70">Pelanggan</p>
                    </div>
                </div>

                <div class="rounded-2xl bg-linear-to-br from-blue-500 to-blue-600 p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.4)]">
                    <p class="mb-1 text-xs font-bold uppercase tracking-[0.22em] text-white/80">Wilayah Cakupan</p>
                    <div class="flex items-baseline gap-2">
                        <p id="map-total-coverage" class="text-4xl font-bold tracking-tight text-white">0</p>
                        <p class="text-xs font-medium text-white/70">Kab / Kota</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.4)]">
                    <h3 class="mb-5 text-xs font-bold uppercase tracking-[0.22em] text-slate-500">Legend Sebaran</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                            <span class="h-3 w-3 rounded-full bg-orange-700 ring-4 ring-orange-700/10"></span>
                            Tinggi (≥ 90)
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                            <span class="h-3 w-3 rounded-full bg-orange-500 ring-4 ring-orange-500/10"></span>
                            Menengah (45 - 89)
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                            <span class="h-3 w-3 rounded-full bg-orange-300 ring-4 ring-orange-300/10"></span>
                            Dasar (&lt; 45)
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
