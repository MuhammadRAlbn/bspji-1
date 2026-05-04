@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $featuredPejabats = $pejabats->take(2);
    $supportPejabats = $pejabats->slice(2)->values();
    $sectionTitles = collect([
        'sejarah' => 'Tonggak Sejarah',
        'motto' => 'Moto, Visi, & Misi',
        'tugas' => 'Tugas dan Fungsi',
        'struktur' => 'Struktur Organisasi',
        'profil' => 'Profil Pejabat',
    ]);
    $pathTabs = $tabs->mapWithKeys(fn ($tab, $key) => [parse_url(route($tab['route']), PHP_URL_PATH) => $key]);
    $profileModalData = $pejabats->mapWithKeys(function ($pejabat) {
        return [
            $pejabat->id => [
                'image' => $pejabat->foto ? Storage::url($pejabat->foto) : null,
                'name' => $pejabat->nama,
                'title' => $pejabat->jabatan,
                'unit' => 'Profil Pejabat',
                'detailHtml' => $pejabat->detail,
            ],
        ];
    });
@endphp

<x-layouts.app title="Tentang Kami - BSPJI Banda Aceh"
    x-data="profilePage"
    data-active-tab="{{ $activeTab }}"
    data-content-titles='@json($sectionTitles, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
    data-path-tabs='@json($pathTabs, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
    data-profiles-id="profile-page-profiles"
    x-effect="document.body.classList.toggle('overflow-hidden', lightboxOpen)">
    <script type="application/json" id="profile-page-profiles">@json($profileModalData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)</script>

    <section
        class="relative mx-auto mt-8 flex h-[360px] w-[95%] flex-col justify-center overflow-hidden rounded-[2rem] shadow-2xl md:h-[450px] md:w-[96%] md:rounded-[2.5rem]">
        <div class="absolute inset-0">
            <img src="{{ $heroImage }}" alt="BSPJI Banda Aceh" class="h-full w-full object-cover object-[center_65%]" fetchpriority="high">
            <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/60 to-black/10"></div>
        </div>

        <div class="relative z-10 mx-auto w-full max-w-7xl px-6 md:px-12">
            <nav class="mb-4 flex items-center gap-2 text-sm text-slate-300" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="transition hover:text-white">Home</a>
                <span class="text-xs">&rsaquo;</span>
                <span class="font-semibold text-white">Tentang Kami</span>
            </nav>

            <h1 class="mb-6 text-4xl font-bold leading-tight text-white md:text-6xl">Tentang Kami</h1>
            <p class="max-w-2xl text-base font-light leading-relaxed text-slate-200 md:text-xl">
                Telusuri sejarah perjalanan, moto, visi, misi, tugas, struktur organisasi, dan profil pejabat BSPJI Banda Aceh.
            </p>
        </div>
    </section>

    <div class="relative z-20 -mt-8 flex justify-center px-4">
        <nav
            class="no-scrollbar inline-flex max-w-full gap-x-2 overflow-x-auto rounded-full border border-slate-100 bg-white p-2 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] md:gap-x-6"
            aria-label="Navigasi profil">
            @foreach ($tabs as $key => $tab)
                <a href="{{ route($tab['route']) }}"
                    @click.prevent="setTab(@js($key), '{{ route($tab['route']) }}')"
                    :class="activeTab === @js($key) ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-800 hover:bg-slate-50 hover:text-slate-950'"
                    class="rounded-full px-4 py-2.5 text-sm font-semibold whitespace-nowrap transition-all duration-300 md:px-10 md:text-base"
                    :aria-selected="activeTab === @js($key)"
                    role="tab">
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </nav>
    </div>

    <main id="profil-content" class="min-h-screen bg-white pb-20 pt-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-12">
            <div class="mb-8 md:mb-10">
                <p class="mb-3 text-xs font-bold uppercase tracking-[0.24em] text-red-600">Tentang Kami</p>
                <h2 class="border-l-4 border-red-600 pl-4 text-2xl font-bold text-slate-900 md:text-3xl"
                    x-text="contentTitle()">
                    {{ $sectionTitles[$activeTab] ?? 'Profil' }}
                </h2>
            </div>

            <section x-show="activeTab === 'sejarah'" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                role="tabpanel">
                @if ($sejarahSingkats->isEmpty())
                    <div class="rounded-[2rem] border border-slate-200 bg-white p-8 text-center text-slate-500 shadow-sm">
                        Belum ada data sejarah singkat yang ditambahkan.
                    </div>
                @else
                    <div class="relative ml-4 space-y-12 border-l-2 border-slate-200 md:ml-10">
                        @foreach ($sejarahSingkats as $index => $sejarah)
                            <article class="relative pl-8 md:pl-12">
                                <div
                                    @class([
                                        'absolute -left-[9px] top-0 h-5 w-5 rounded-full border-4 border-white shadow-sm',
                                        'bg-red-600' => $index === 0,
                                        'bg-slate-400' => $index !== 0,
                                    ])>
                                </div>

                                <span
                                    @class([
                                        'mb-1 block text-sm font-bold uppercase tracking-widest',
                                        'text-red-600' => $index === 0,
                                        'text-slate-500' => $index !== 0,
                                    ])>
                                    {{ $sejarah->tahun }}
                                </span>

                                <h3 class="text-xl font-bold text-slate-900">{{ $sejarah->judul }}</h3>
                                <div class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600 md:text-base">
                                    {!! nl2br(e($sejarah->detail)) !!}
                                </div>

                                <div class="mt-4 h-[200px] w-[300px] max-w-full overflow-hidden rounded-xl border border-slate-200 bg-slate-100 shadow-sm">
                                    @if ($sejarah->gambar)
                                        <img src="{{ Storage::url($sejarah->gambar) }}" alt="{{ $sejarah->judul }}" loading="lazy" decoding="async"
                                            class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-slate-900 via-slate-700 to-red-700 px-6 text-center text-sm font-bold uppercase tracking-[0.22em] text-white">
                                            {{ $sejarah->tahun }}
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>

            <section x-show="activeTab === 'motto'" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                role="tabpanel">
                <div class="grid gap-8 lg:grid-cols-12">
                    <div class="lg:col-span-5 xl:col-span-4">
                        <article class="relative flex h-full flex-col overflow-hidden rounded-[2rem] border border-[#d7f1f4] bg-white p-6 shadow-md">
                            <div class="absolute -left-14 -top-14 h-40 w-40 rounded-full border border-[#d7f1f4]"></div>
                            <div class="absolute -left-10 -top-10 h-32 w-32 rounded-full border border-[#d7f1f4]"></div>
                            <div class="absolute -right-16 -top-12 h-44 w-44 rounded-full border border-[#d7f1f4]"></div>

                            <div class="relative">
                                <p class="mb-2 text-sm font-semibold uppercase tracking-[0.16em] text-[#1ab6c5]">
                                    Moto Pelayanan
                                </p>
                                <h3 class="mb-8 text-4xl font-black uppercase leading-none text-[#12afc0] md:text-5xl">
                                    Pasti Bisa
                                </h3>

                                <div class="space-y-8">
                                    <div>
                                        <p class="mb-3 text-xs font-medium uppercase tracking-[0.14em] text-slate-400">
                                            Layanan
                                        </p>
                                        <div class="space-y-2">
                                            @foreach ([
                                                'P' => 'Prima',
                                                'A' => 'Akuntabel',
                                                'S' => 'Siap',
                                                'T' => 'Transparan',
                                                'I' => 'Inovatif',
                                            ] as $letter => $word)
                                                <div class="flex items-center gap-3 text-lg text-slate-700">
                                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center bg-[#12afc0] text-sm font-black text-white">{{ $letter }}</span>
                                                    <span><strong class="font-semibold">{{ $word }}</strong></span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <p class="mb-3 text-xs font-medium uppercase tracking-[0.14em] text-slate-400">
                                            Petugas Pelayanan
                                        </p>
                                        <div class="space-y-2">
                                            <div class="flex items-center gap-3 text-lg text-slate-700">
                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center bg-[#12afc0] text-sm font-black text-white">B</span>
                                                <span><strong class="font-semibold">Berorientasi</strong> Pelayanan</span>
                                            </div>
                                            <div class="flex items-center gap-3 text-lg text-slate-700">
                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center bg-[#12afc0] text-sm font-black text-white">I</span>
                                                <span><strong class="font-semibold">Integritas</strong></span>
                                            </div>
                                            <div class="flex items-center gap-3 text-lg text-slate-700">
                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center bg-[#12afc0] text-sm font-black text-white">S</span>
                                                <span><strong class="font-semibold">Suportif</strong></span>
                                            </div>
                                            <div class="flex items-center gap-3 text-lg text-slate-700">
                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center bg-[#12afc0] text-sm font-black text-white">A</span>
                                                <span><strong class="font-semibold">Adaptif</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="space-y-6 lg:col-span-7 xl:col-span-8">
                        <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-md md:p-10">
                            <p class="mb-4 text-sm font-bold uppercase tracking-[0.2em] text-red-600">Visi</p>
                            <div class="text-sm leading-relaxed text-slate-600 md:text-lg md:font-light [&_p]:mb-3">
                                {!! $visiMisi?->visi ?: '<p>Data visi belum tersedia.</p>' !!}
                            </div>
                        </article>

                        <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-md md:p-10">
                            <p class="mb-4 text-sm font-bold uppercase tracking-[0.2em] text-red-600">Misi</p>
                            <div
                                class="text-sm leading-relaxed text-slate-600 md:text-lg md:font-light [&_li]:mb-3 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_ul]:list-disc [&_ul]:pl-5">
                                {!! $visiMisi?->misi ?: '<p>Data misi belum tersedia.</p>' !!}
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section x-show="activeTab === 'tugas'" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                role="tabpanel">
                @if (! $tugasFungsi)
                    <div class="rounded-[2rem] border border-slate-200 bg-white p-8 text-center text-slate-500 shadow-sm">
                        Data Tugas dan Fungsi belum tersedia.
                    </div>
                @else
                    <div class="grid gap-6 lg:grid-cols-2">
                        <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm md:p-8">
                            <p class="mb-4 text-xs font-bold uppercase tracking-[0.24em] text-red-600">Tugas</p>
                            <div
                                class="text-sm leading-relaxed text-slate-600 md:text-base [&_li]:mb-2 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_ul]:list-disc [&_ul]:pl-5">
                                {!! $tugasFungsi->tugas ?: '<p>Data tugas belum tersedia.</p>' !!}
                            </div>
                        </article>

                        <article class="rounded-[2rem] border border-slate-200 bg-slate-900 p-6 text-white shadow-sm md:p-8">
                            <p class="mb-4 text-xs font-bold uppercase tracking-[0.24em] text-red-300">Fungsi</p>
                            <div
                                class="text-sm leading-relaxed text-slate-200 md:text-base [&_li]:mb-2 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_ul]:list-disc [&_ul]:pl-5">
                                {!! $tugasFungsi->fungsi ?: '<p>Data fungsi belum tersedia.</p>' !!}
                            </div>
                        </article>
                    </div>
                @endif
            </section>

            <section x-show="activeTab === 'struktur'" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                role="tabpanel">
                @if (! $strukturOrganisasi || ! $strukturOrganisasi->image_path)
                    <div class="rounded-[2rem] border border-slate-200 bg-white p-8 text-center text-slate-500 shadow-sm">
                        Data Struktur Organisasi belum tersedia.
                    </div>
                @else
                    <div class="rounded-[2rem] overflow-hidden border border-slate-200 bg-white shadow-sm">
                        <img src="{{ Storage::url($strukturOrganisasi->image_path) }}" alt="Struktur Organisasi" loading="lazy" decoding="async"
                            class="w-full h-auto object-cover">
                    </div>
                @endif
            </section>

            <section x-show="activeTab === 'profil'" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                role="tabpanel">
                @if ($pejabats->isEmpty())
                    <div class="rounded-[2rem] border border-slate-200 bg-white p-8 text-center text-slate-500 shadow-sm">
                        Data profil pejabat belum tersedia.
                    </div>
                @else
                    <div class="mb-8 grid gap-6 md:mb-10 xl:grid-cols-2">
                        @foreach ($featuredPejabats as $pejabat)
                            <article class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                                <div class="grid md:grid-cols-[0.95fr_1.05fr]">
                                    <button type="button"
                                        class="group relative min-h-[280px] bg-slate-100 text-left sm:min-h-[340px] md:min-h-[360px]"
                                        @click="openProfile({{ $pejabat->id }})"
                                        aria-label="Lihat profil {{ $pejabat->nama }}">
                                        @if ($pejabat->foto)
                                            <img src="{{ Storage::url($pejabat->foto) }}" alt="{{ $pejabat->nama }}" loading="lazy" decoding="async"
                                                class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center bg-slate-100 text-slate-300">
                                                <svg class="h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-slate-950/35 to-transparent"></div>
                                    </button>

                                    <div class="p-5 sm:p-6 md:p-8">
                                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.22em] text-red-600">Pejabat Utama</p>
                                        <h3 class="text-xl font-bold leading-tight text-slate-900 sm:text-2xl">{{ $pejabat->nama }}</h3>
                                        <p class="mt-3 text-sm font-semibold text-emerald-600">{{ $pejabat->jabatan }}</p>
                                        <p class="mt-5 text-sm leading-relaxed text-slate-600">
                                            {{ Str::limit(strip_tags($pejabat->detail), 220) }}
                                        </p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($supportPejabats->isNotEmpty())
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">
                            @foreach ($supportPejabats as $pejabat)
                                <article class="rounded-[1.75rem] border border-slate-200 bg-white p-4 shadow-sm">
                                    <div class="flex items-start gap-4 sm:block">
                                        <button type="button"
                                            class="group mb-0 aspect-[4/5] w-28 shrink-0 overflow-hidden rounded-[1.25rem] bg-slate-100 sm:mb-4 sm:w-full"
                                            @click="openProfile({{ $pejabat->id }})"
                                            aria-label="Lihat profil {{ $pejabat->nama }}">
                                            @if ($pejabat->foto)
                                                <img src="{{ Storage::url($pejabat->foto) }}" alt="{{ $pejabat->nama }}" loading="lazy" decoding="async"
                                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-slate-300">
                                                    <svg class="h-14 w-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </button>

                                        <div class="min-w-0">
                                            <p class="mb-2 text-[11px] font-bold uppercase tracking-[0.18em] text-red-600">Profil Pejabat</p>
                                            <h3 class="text-base font-bold leading-snug text-slate-900">{{ $pejabat->nama }}</h3>
                                            <p class="mt-2 text-sm font-semibold text-emerald-600">{{ $pejabat->jabatan }}</p>
                                            <p class="mt-3 hidden text-sm leading-relaxed text-slate-600 sm:block">
                                                {{ Str::limit(strip_tags($pejabat->detail), 120) }}
                                            </p>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                @endif
            </section>
        </div>
    </main>

    <div x-show="lightboxOpen" x-cloak x-transition.opacity @keydown.escape.window="closeProfile()"
        class="fixed inset-0 z-[120] flex items-center justify-center bg-slate-950/80 p-4 backdrop-blur-sm"
        style="display: none;" role="dialog" aria-modal="true">
        <button type="button" class="absolute inset-0 cursor-default" @click="closeProfile()" aria-label="Tutup modal"></button>

        <section
            class="relative grid max-h-[90vh] w-full max-w-5xl overflow-hidden rounded-[2rem] bg-white shadow-2xl md:grid-cols-[0.9fr_1.1fr]">
            <button type="button"
                class="absolute right-4 top-4 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-slate-900 shadow transition hover:bg-white"
                @click="closeProfile()" aria-label="Tutup profil">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="relative min-h-[320px] bg-slate-100 md:min-h-[620px]">
                <template x-if="lightboxData.image">
                    <img :src="lightboxData.image" :alt="lightboxData.name || 'Profil pejabat'"
                        class="absolute inset-0 h-full w-full object-cover">
                </template>
                <template x-if="!lightboxData.image">
                    <div class="absolute inset-0 flex items-center justify-center text-slate-300">
                        <svg class="h-28 w-28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0" />
                        </svg>
                    </div>
                </template>
            </div>

            <div class="overflow-y-auto p-6 sm:p-8 md:p-10">
                <p class="mb-3 text-xs font-bold uppercase tracking-[0.22em] text-red-600" x-text="lightboxData.unit || 'Profil Pejabat'"></p>
                <h3 class="text-2xl font-bold leading-tight text-slate-900 md:text-4xl" x-text="lightboxData.name || ''"></h3>
                <p class="mt-3 text-base font-semibold text-emerald-600" x-text="lightboxData.title || ''"></p>
                <div
                    class="mt-6 text-sm leading-relaxed text-slate-600 md:text-base [&_li]:mb-2 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_ul]:list-disc [&_ul]:pl-5"
                    x-html="lightboxData.detailHtml || '<p>Detail profil belum tersedia.</p>'"></div>
            </div>
        </section>
    </div>
</x-layouts.app>
