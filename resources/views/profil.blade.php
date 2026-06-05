@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $featuredPejabats = collect($pejabats)->take(2);
    $supportPejabats = collect($pejabats)->slice(2)->values();
    $sectionTitles = collect([
        'sejarah' => 'Tonggak Sejarah',
        'motto' => 'Moto, Visi, & Misi',
        'tugas' => 'Tugas dan Fungsi',
        'struktur' => 'Struktur Organisasi',
        'profil' => 'Profil Pejabat',
    ]);
    $pathTabs = collect($tabs)->mapWithKeys(fn ($tab, $key) => [parse_url(route($tab['route']), PHP_URL_PATH) => $key]);
    $profileModalData = collect($pejabats)->mapWithKeys(function ($pejabat) {
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

<x-layouts.app title="Tentang Kami - BSPJI Banda Aceh" bodyClass="bg-slate-50"
    x-data="profilePage"
    data-active-tab="{{ $activeTab }}"
    data-content-titles='@json($sectionTitles, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
    data-path-tabs='@json($pathTabs, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
    data-profiles-id="profile-page-profiles"
    x-effect="document.body.classList.toggle('overflow-hidden', lightboxOpen)">
    <script type="application/json" id="profile-page-profiles">@json($profileModalData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)</script>

    <section
        class="relative flex h-[360px] w-[calc(100%-2rem)] max-w-7xl mx-auto mt-4 flex-col justify-center overflow-hidden border border-slate-700 shadow-xl rounded-3xl md:w-[calc(100%-6rem)] lg:w-full md:h-[450px] md:rounded-[2.25rem] md:mt-8">
        <div class="absolute inset-0">
            <img src="{{ asset('gbr2.webp') }}" alt="BSPJI Banda Aceh" class="h-full w-full object-cover object-[center_65%]" fetchpriority="high">
            <div class="absolute inset-0 bg-slate-900/80 md:bg-transparent md:bg-[linear-gradient(to_right,rgba(30,41,59,0.95)_0%,rgba(30,41,59,0.6)_55%,rgba(30,41,59,0)_85%)]"></div>
        </div>

        <div class="relative z-10 w-full px-6 md:px-12 lg:px-16">
            <h1 class="mb-6 text-4xl font-semibold leading-tight text-white md:text-6xl">Tentang Kami</h1>
            <p class="max-w-2xl text-base font-normal leading-relaxed text-white md:text-xl">
                Telusuri sejarah perjalanan, moto, visi, misi, tugas, struktur organisasi, dan profil pejabat BSPJI Banda Aceh.
            </p>
        </div>
    </section>

    <div class="relative z-20 -mt-8 flex justify-center px-4">
        <nav
            class="no-scrollbar inline-flex max-w-full gap-x-2 overflow-x-auto rounded-full border border-slate-300 bg-white p-2 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] md:gap-x-6"
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

    <main id="profil-content" class="min-h-screen bg-transparent pb-20 pt-16">
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
                <div class="mr-auto max-w-2xl rounded-4xl border border-slate-300 bg-white p-3 shadow-md hover:shadow-lg transition-all duration-300">
                    <img src="{{ asset('sejarah.png') }}" alt="Sejarah BSPJI Banda Aceh" loading="lazy" decoding="async"
                        class="w-full h-auto rounded-[1.75rem] object-contain">
                </div>

                {{--
                @if ($sejarahSingkats->isEmpty())
                    <div class="rounded-4xl border border-slate-300 bg-white p-8 text-center text-slate-500 shadow-sm">
                        Belum ada data sejarah singkat yang ditambahkan.
                    </div>
                @else
                    <div class="relative mx-auto max-w-5xl">
                        <!-- Timeline Vertical Line -->
                        <div class="absolute left-4 top-2 bottom-2 w-0.5 bg-slate-200 md:left-1/2 md:-translate-x-1/2"></div>

                        <div class="space-y-12 relative">
                            @foreach ($sejarahSingkats as $index => $sejarah)
                                <div class="relative w-full">
                                    <!-- Card Container -->
                                    <div class="w-full pl-10 md:pl-0 md:w-[calc(50%-2.5rem)] {{ $index % 2 === 0 ? 'md:mr-auto' : 'md:ml-auto' }}">
                                        <article class="group relative rounded-4xl border border-slate-300 bg-white p-6 shadow-md md:p-8 hover:-translate-y-1 hover:border-slate-400 hover:shadow-lg transition-all duration-300">
                                            <!-- Year -->
                                            <span class="mb-3 inline-block rounded-full bg-red-50 px-3 py-1 text-xs font-bold uppercase tracking-widest text-red-600">
                                                {{ $sejarah->tahun }}
                                            </span>

                                            <!-- Title -->
                                            <h3 class="text-xl font-bold text-slate-900 md:text-2xl">{{ $sejarah->judul }}</h3>

                                            <!-- Description (Justified) -->
                                            <div class="mt-4 text-justify text-sm leading-relaxed text-slate-950 md:text-base [&_p]:text-justify [&_p]:text-slate-950">
                                                {!! nl2br(e($sejarah->detail)) !!}
                                            </div>

                                            <!-- Image -->
                                            <div class="mt-6 aspect-video w-full overflow-hidden rounded-3xl border border-slate-300 bg-slate-100 shadow-sm" style="max-width: 450px;">
                                                @if ($sejarah->gambar)
                                                    <img src="{{ Storage::url($sejarah->gambar) }}" alt="{{ $sejarah->judul }}" loading="lazy" decoding="async"
                                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center bg-linear-to-br from-slate-900 via-slate-700 to-red-700 px-6 text-center text-sm font-bold uppercase tracking-[0.22em] text-white">
                                                        {{ $sejarah->tahun }}
                                                    </div>
                                                @endif
                                            </div>
                                        </article>
                                    </div>

                                    <!-- Central Dot/Node -->
                                    <div @class([
                                        'absolute left-[8px] top-8 h-4.5 w-4.5 rounded-full border-4 border-white shadow-md transition-all duration-300 md:left-1/2 md:-translate-x-1/2 md:top-10',
                                        'bg-red-600 scale-110' => $index === 0,
                                        'bg-slate-400' => $index !== 0,
                                    ])>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                --}}
            </section>

            <section x-show="activeTab === 'motto'" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                role="tabpanel">
                <div class="grid gap-8 lg:grid-cols-12">
                    <div class="lg:col-span-5 xl:col-span-4">
                        <article class="relative flex h-full flex-col overflow-hidden rounded-4xl border border-slate-300 bg-white p-6 shadow-md">
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
                        <article class="rounded-4xl border border-slate-300 bg-white p-8 shadow-md md:p-10">
                            <p class="mb-4 text-base md:text-lg font-bold uppercase tracking-[0.2em] text-red-600">Visi BSPJI Banda Aceh Tahun 2025 - 2029</p>
                            <div class="text-justify text-sm leading-relaxed text-slate-950 md:text-lg md:font-light [&_p]:mb-3 [&_p]:text-justify [&_p]:text-slate-950">
                                {!! $visiMisi?->visi ?: '<p>Data visi belum tersedia.</p>' !!}
                            </div>
                        </article>

                        <article class="rounded-4xl border border-slate-300 bg-white p-8 shadow-md md:p-10">
                            <p class="mb-4 text-base md:text-lg font-bold uppercase tracking-[0.2em] text-red-600">Misi BSPJI Banda Aceh Tahun 2025 - 2029</p>
                            <div
                                class="text-justify text-sm leading-relaxed text-slate-950 md:text-lg md:font-light [&_li]:mb-3 [&_li]:text-justify [&_li]:text-slate-950 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_p]:text-justify [&_p]:text-slate-950 [&_ul]:list-disc [&_ul]:pl-5">
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
                    <div class="rounded-4xl border border-slate-300 bg-white p-8 text-center text-slate-500 shadow-sm">
                        Data Tugas dan Fungsi belum tersedia.
                    </div>
                @else
                    <div class="mr-auto grid max-w-4xl grid-cols-1 gap-8">
                        <article class="group relative rounded-4xl border border-slate-300 bg-linear-to-br from-white to-slate-50/50 p-6 shadow-md transition-all duration-300 hover:-translate-y-1 hover:border-slate-400 hover:shadow-lg md:p-8">
                            <div class="absolute right-6 top-6 opacity-5 transition-transform duration-500 group-hover:rotate-12 group-hover:scale-110">
                                <svg class="h-24 w-24 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div class="relative z-10">
                                <div class="mb-6 flex items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </span>
                                    <p class="text-base md:text-lg font-bold uppercase tracking-[0.24em] text-red-600">Tugas Pokok</p>
                                </div>
                                <div class="text-justify text-sm leading-relaxed text-slate-950 md:text-base [&_li]:mb-3 [&_li]:text-justify [&_li]:text-slate-950 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_p]:text-justify [&_p]:text-slate-950 [&_ul]:list-disc [&_ul]:pl-5">
                                    {!! $tugasFungsi->tugas ?: '<p>Data tugas belum tersedia.</p>' !!}
                                </div>
                            </div>
                        </article>

                        <article class="group relative rounded-4xl border border-slate-300 bg-linear-to-br from-white to-slate-50/50 p-6 shadow-md transition-all duration-300 hover:-translate-y-1 hover:border-slate-400 hover:shadow-lg md:p-8">
                            <div class="absolute right-6 top-6 opacity-5 transition-transform duration-500 group-hover:-rotate-12 group-hover:scale-110">
                                <svg class="h-24 w-24 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="relative z-10">
                                <div class="mb-6 flex items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </span>
                                    <p class="text-base md:text-lg font-bold uppercase tracking-[0.24em] text-red-600">Fungsi Utama</p>
                                </div>
                                <div class="text-justify text-sm leading-relaxed text-slate-950 md:text-base [&_li]:mb-3 [&_li]:text-justify [&_li]:text-slate-950 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_p]:text-justify [&_p]:text-slate-950 [&_ul]:list-disc [&_ul]:pl-5">
                                    {!! $tugasFungsi->fungsi ?: '<p>Data fungsi belum tersedia.</p>' !!}
                                </div>
                            </div>
                        </article>
                    </div>
                @endif
            </section>

            <section x-show="activeTab === 'struktur'" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                role="tabpanel">
                @if (! $strukturOrganisasi || ! $strukturOrganisasi->image_path)
                    <div class="rounded-4xl border border-slate-300 bg-white p-8 text-center text-slate-500 shadow-sm">
                        Data Struktur Organisasi belum tersedia.
                    </div>
                @else
                    <div class="mr-auto max-w-2xl rounded-4xl border border-slate-300 bg-white p-3 shadow-md hover:shadow-lg transition-all duration-300">
                        <img src="{{ Storage::url($strukturOrganisasi->image_path) }}" alt="Struktur Organisasi" loading="lazy" decoding="async"
                            class="w-full h-auto rounded-[1.75rem] object-contain">
                    </div>
                @endif
            </section>

            <section x-show="activeTab === 'profil'" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                role="tabpanel">
                @if ($pejabats->isEmpty())
                    <div class="rounded-4xl border border-slate-300 bg-white p-8 text-center text-slate-500 shadow-sm">
                        Data profil pejabat belum tersedia.
                    </div>
                @else
                    <div class="mb-8 grid gap-6 md:mb-10 xl:grid-cols-2">
                        @foreach ($featuredPejabats as $pejabat)
                            <article class="overflow-hidden rounded-4xl border border-slate-300 bg-white shadow-sm">
                                <div class="grid md:grid-cols-[0.95fr_1.05fr]">
                                    <button type="button"
                                        class="group relative min-h-[280px] cursor-zoom-in bg-slate-100 text-left sm:min-h-[340px] md:min-h-[360px]"
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
                                        <div class="absolute inset-x-0 bottom-0 h-32 bg-linear-to-t from-slate-950/35 to-transparent"></div>
                                    </button>

                                    <div class="p-5 sm:p-6 md:p-8">
                                        <h3 class="text-xl font-bold leading-tight text-slate-900 sm:text-2xl">{{ $pejabat->nama }}</h3>
                                        <p class="mt-3 text-sm font-semibold text-emerald-600">{{ $pejabat->jabatan }}</p>
                                        <p class="mt-5 text-sm leading-relaxed text-slate-600 text-justify">
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
                                <article class="rounded-[1.75rem] border border-slate-300 bg-white p-2 shadow-sm">
                                    <div class="flex items-start gap-4 sm:block">
                                        <button type="button"
                                            class="group mb-0 aspect-4/5 w-28 shrink-0 cursor-zoom-in overflow-hidden rounded-[1.25rem] bg-slate-100 sm:mb-2 sm:w-full"
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

                                        <div class="min-w-0 flex-1 p-2 text-center sm:p-2 sm:pt-0">
                                            <h3 class="text-sm font-bold leading-snug text-slate-900">{{ $pejabat->nama }}</h3>
                                            <p class="mt-2 text-sm font-semibold text-emerald-600">{{ $pejabat->jabatan }}</p>
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
        class="fixed inset-0 z-120 flex items-center justify-center bg-slate-950/80 p-4 backdrop-blur-sm"
        style="display: none;" role="dialog" aria-modal="true">
        <button type="button" class="absolute inset-0 cursor-default" @click="closeProfile()" aria-label="Tutup modal"></button>

        <section
            class="relative grid max-h-[90vh] w-full max-w-5xl overflow-hidden rounded-4xl bg-white shadow-2xl grid-rows-[auto_1fr] md:grid-rows-none md:grid-cols-[0.9fr_1.1fr]">
            <button type="button"
                class="absolute right-4 top-4 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-slate-900 shadow transition hover:bg-white"
                @click="closeProfile()" aria-label="Tutup profil">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="relative h-56 bg-slate-100 md:h-auto md:min-h-[620px]">
                <template x-if="lightboxData.image">
                    <img :src="lightboxData.image" :alt="lightboxData.name || 'Profil pejabat'"
                        class="absolute inset-0 h-full w-full object-cover object-top">
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
                    class="mt-6 text-justify text-sm leading-relaxed text-slate-600 md:text-base [&_li]:mb-2 [&_ol]:list-decimal [&_ol]:pl-5 [&_p]:mb-3 [&_p]:text-justify [&_ul]:list-disc [&_ul]:pl-5"
                    x-html="lightboxData.detailHtml || '<p>Detail profil belum tersedia.</p>'"></div>
            </div>
        </section>
    </div>
</x-layouts.app>
