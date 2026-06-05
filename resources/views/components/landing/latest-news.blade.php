@props([
    'latestNewsItems',
    'beritaIndexUrl',
])

<section id="berita" class="relative overflow-hidden bg-slate-50/80 py-16 md:py-24">
    <div class="pointer-events-none absolute inset-0 opacity-40"
        style="background-image: radial-gradient(#64748b20 0.8px, transparent 0.8px); background-size: 24px 24px;">
    </div>
    <div class="mx-auto max-w-6xl px-6 lg:px-0">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.12fr)] lg:items-start lg:gap-14" data-aos="fade-up">
            <div>
                <p class="mb-3 text-sm font-bold uppercase tracking-normal text-[#0038b8]">
                    BERITA
                </p>
                <h2 class="text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">
                    Berita Terkini
                </h2>
            </div>

            <div class="flex flex-col gap-6 lg:pt-3">
                <p class="max-w-xl text-lg font-normal leading-relaxed text-slate-700 md:text-lg">
                    Ikuti kabar terbaru, agenda, dan informasi layanan BSPJI Banda Aceh dalam mendukung pertumbuhan industri yang berdaya saing.
                </p>

                <a href="{{ $beritaIndexUrl }}"
                    class="group inline-flex w-fit items-center gap-3 rounded-full border border-slate-600 px-7 py-3 text-sm font-semibold text-slate-700 transition duration-300 hover:border-slate-900 hover:bg-slate-900 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-900/20">
                    Selengkapnya
                    <i data-lucide="arrow-right" class="h-5 w-5 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>

        @if ($latestNewsItems->isEmpty())
            <div class="mt-12 rounded-lg border border-dashed border-slate-300 bg-[#f2f5f9] p-8 text-slate-600">
                Berita terbaru belum tersedia.
            </div>
        @else
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 lg:gap-10">
                @foreach ($latestNewsItems as $index => $item)
                    <article class="group flex h-full flex-col" data-aos="fade-up" data-aos-delay="{{ 100 + ($index % 3) * 75 }}">
                        <a href="{{ $item['url'] }}"
                            class="block overflow-hidden rounded-lg bg-[#f1f4f9] focus:outline-none focus:ring-2 focus:ring-[#123cad]/25">
                            <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}" loading="lazy"
                                class="aspect-video w-full object-cover transition duration-500 group-hover:scale-105">
                        </a>

                        <div class="flex flex-1 flex-col pt-6">
                            <p class="mb-3 text-xs font-bold uppercase tracking-[0.16em] text-[#0038b8]">
                                {{ $item['published_date'] }}
                            </p>

                            <h3 class="text-xl font-semibold leading-snug text-gray-900 md:text-2xl">
                                <a href="{{ $item['url'] }}" class="transition hover:text-[#0038b8]">
                                    {{ $item['title'] }}
                                </a>
                            </h3>

                            @if ($item['excerpt'])
                                <p class="mt-4 line-clamp-3 text-base leading-relaxed text-slate-700">
                                    {{ $item['excerpt'] }}
                                </p>
                            @endif

                            <a href="{{ $item['url'] }}"
                                class="group/link mt-8 inline-flex w-fit items-center gap-3 rounded-full border border-slate-600 px-7 py-3 text-sm font-semibold text-slate-700 transition duration-300 hover:border-slate-900 hover:bg-slate-900 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-900/20">
                                Selengkapnya
                                <i data-lucide="arrow-right" class="h-5 w-5 transition-transform group-hover/link:translate-x-1"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
