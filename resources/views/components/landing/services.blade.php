@props([
    'serviceItems',
])

<section id="layanan" class="bg-white pb-16 pt-24 md:pb-24 md:pt-28">
    <div class="mx-auto max-w-6xl px-6 lg:px-0">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.12fr)] lg:items-start lg:gap-14" data-aos="fade-up">
            <div>
                <p class="mb-3 text-sm font-bold uppercase tracking-normal text-[#0038b8]">
                    STANDARDISASI & PELAYANAN INDUSTRI
                </p>
                <h2 class="text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">
                    Layanan Jasa Kami
                </h2>
            </div>

            <p class="max-w-xl text-lg font-normal leading-relaxed text-slate-700 md:text-lg lg:pt-3">
                BSPJI Banda Aceh berkomitmen meningkatkan daya saing industri melalui layanan sertifikasi, kalibrasi, pengujian, serta konsultansi yang profesional dan terpercaya.
            </p>
        </div>

        @if ($serviceItems->isEmpty())
            <div class="mt-8 rounded-lg border border-dashed border-slate-300 bg-[#f2f5f9] p-8 text-slate-600">
                Data layanan belum tersedia.
            </div>
        @else
            <div class="mt-20 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 lg:gap-5">
                @foreach ($serviceItems as $index => $service)
                    <a href="{{ $service['url'] }}"
                        class="group relative flex h-[170px] flex-col justify-end overflow-hidden rounded-lg border border-[#dde4ee] bg-[#f1f4f9] p-5 text-left transition duration-300 hover:-translate-y-1 hover:border-[#cfd8e6] focus:outline-none focus:ring-2 focus:ring-[#123cad]/25 md:h-[190px]"
                        data-aos="fade-up" data-aos-delay="{{ 100 + ($index % 4) * 75 }}">
                        @if ($service['image_url'])
                            <img src="{{ $service['image_url'] }}" alt="{{ $service['name'] }}"
                                class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-linear-to-t from-slate-950/90 via-slate-950/20 to-transparent transition duration-300 group-hover:from-slate-950 group-hover:via-slate-950/30"></div>
                        @endif
                        <h3 class="relative z-10 text-sm font-bold uppercase leading-snug tracking-normal {{ $service['image_url'] ? 'text-white drop-shadow-md' : 'text-slate-950' }}">
                            {{ $service['name'] }}
                        </h3>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{--
<section id="layanan" class="pb-12 pt-24 md:pb-20 md:pt-28">
    <div class="mx-auto max-w-6xl px-6 lg:px-0">
        <div class="mb-16 flex flex-col justify-between gap-8 md:mb-14 md:flex-row md:items-end">
            <div class="max-w-2xl" data-aos="fade-up">
                <div class="mb-6 flex items-center gap-2">
                    <span class="text-[10px] text-orange-600">■</span>
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Solusi Industri</span>
                </div>
                <h2 class="section-title-identic text-gray-900">
                    Layanan Jasa Industri Kami
                </h2>
            </div>
        </div>

        @if ($sectionLayanans->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-slate-600">
                Data layanan belum tersedia.
            </div>
        @else
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                @foreach ($sectionLayanans as $index => $layanan)
                    @php
                        $slug = Str::slug($layanan->nama_layanan);
                        $serviceUrl = $serviceRouteMap[$slug] ?? '#';
                    @endphp
                    <a href="{{ $serviceUrl }}"
                        class="flex min-h-[180px] items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-6 py-8 text-center shadow-[0_2px_10px_-6px_rgba(15,23,42,0.45)] transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:bg-white hover:shadow-[0_18px_35px_-28px_rgba(15,23,42,0.75)] focus:outline-none focus:ring-2 focus:ring-slate-900/20"
                        data-aos="fade-up" data-aos-delay="{{ 100 + ($index % 4) * 75 }}">
                        <h3 class="text-lg font-semibold leading-snug tracking-tight text-slate-900">
                            {{ $layanan->nama_layanan }}
                        </h3>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
--}}
