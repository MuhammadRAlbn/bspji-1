<x-layouts.app title="Berita - BSPJI Banda Aceh">
    @php
        $heroImage = asset('images/imagelab.webp');
    @endphp

    <section class="mx-auto mt-12 max-w-6xl px-6">
        <div class="max-w-3xl">
            <h1 class="text-4xl tracking-tight text-slate-800 md:text-5xl">
                Berita
            </h1>
            <p class="mt-4 text-lg text-slate-600">
                Kabar terbaru dari Balai Standardisasi dan Pelayanan Jasa Industri Banda Aceh.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-10">
        @if ($newsItems->isEmpty())
            <div class="rounded-2xl border border-slate-300 bg-white p-10 text-center shadow-sm">
                <h2 class="text-2xl font-bold text-slate-800">Belum Ada Berita</h2>
                <p class="mt-2 text-slate-500">Berita terbaru belum tersedia saat ini.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($newsItems as $item)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <a href="{{ route('berita.show', $item) }}" class="block">
                            <img
                                src="{{ $item->cover_image ? asset('storage/' . $item->cover_image) : $heroImage }}"
                                alt="{{ $item->title }}"
                                class="aspect-video w-full object-cover">
                        </a>

                        <div class="flex min-h-64 flex-col gap-4 p-5">
                            <div class="flex items-center justify-between gap-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                                <span>{{ $item->published_at?->format('d M Y') }}</span>
                                <span>{{ $item->comments_count }} komentar</span>
                            </div>

                            <div class="flex flex-1 flex-col gap-3">
                                <h2 class="text-xl font-extrabold leading-snug text-slate-800">
                                    <a href="{{ route('berita.show', $item) }}" class="transition hover:text-orange-500">
                                        {{ $item->title }}
                                    </a>
                                </h2>

                                @if ($item->excerpt)
                                    <p class="line-clamp-3 text-sm leading-6 text-slate-600">{{ $item->excerpt }}</p>
                                @endif
                            </div>

                            <a href="{{ route('berita.show', $item) }}"
                                class="inline-flex items-center text-sm font-bold text-orange-500 transition hover:text-orange-600">
                                Baca Selengkapnya
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $newsItems->links() }}
            </div>
        @endif
    </section>
</x-layouts.app>
