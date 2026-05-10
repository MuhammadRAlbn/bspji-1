@props(['variant' => 'default'])

@php
    $isTransparent = $variant === 'transparent';

    $routeOrHash = static fn(string $name): string => \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';

    $profilMenu = [
        ['label' => 'Sejarah Singkat', 'url' => $routeOrHash('sejarah-singkat.index')],
        ['label' => 'Moto dan Visi', 'url' => $routeOrHash('visi-misi.index')],
        ['label' => 'Tupoksi', 'url' => $routeOrHash('tugas-fungsi.index')],
        ['label' => 'Struktur', 'url' => $routeOrHash('struktur-organisasi.index')],
        ['label' => 'Profil Pejabat', 'url' => $routeOrHash('profil-pejabat.index')],
    ];

    $pelayananMenu = [
        ['label' => 'Pengujian', 'url' => $routeOrHash('pengujian.index')],
        ['label' => 'Kalibrasi', 'url' => $routeOrHash('kalibrasi.index')],
        ['label' => 'Sertifikasi Produk', 'url' => $routeOrHash('sertifikasi-produk.index')],
        ['label' => 'Lembaga Pemeriksa Halal', 'url' => $routeOrHash('lph.index')],
        ['label' => 'Lembaga Sertifikasi Industri Hijau', 'url' => $routeOrHash('lsih.index')],
        ['label' => 'Verifikasi TKDN', 'url' => $routeOrHash('tkdn.index')],
        ['label' => 'Pelatihan Teknis', 'url' => $routeOrHash('pelatihan-teknis.index')],
        ['label' => 'Konsultasi', 'url' => $routeOrHash('konsultasi-pendampingan.index')],
    ];

    $informasiPublikMenu = [
        ['label' => 'Unit Pelayanan Publik (UPP)', 'url' => $routeOrHash('upp.index')],
        // ['label' => 'Zona Integritas', 'url' => $routeOrHash('zona-integritas.index')],
        ['label' => 'Informasi Publik', 'url' => $routeOrHash('informasi-publik.index')],
        ['label' => 'PPID', 'url' => $routeOrHash('ppid.index')],
    ];

    $tautanMenu = [
        ['label' => 'SIPPN Menpan RB', 'url' => 'https://sippn.menpan.go.id'],
        ['label' => 'Lapor (Layanan Aspirasi dan Pengaduan Online Rakyat) Kemenpan RB', 'url' => 'https://www.lapor.go.id'],
        ['label' => 'Kementerian Perindustrian', 'url' => 'https://kemenperin.go.id'],
        ['label' => 'Badan Standardisasi dan Kebijakan Jasa Industri', 'url' => 'https://bskji.kemenperin.go.id'],
        ['label' => 'Sistem Informasi Industri Nasional (SIINas)', 'url' => 'https://siinas.kemenperin.go.id'],
        ['label' => 'Online Single Submission', 'url' => 'https://oss.go.id/id'],
        ['label' => 'Jaringan Dokumentasi dan Informasi Hukum', 'url' => 'https://jdih.kemenperin.go.id'],
        ['label' => 'Login Pegawai BSPJI Banda Aceh', 'url' => 'https://pintu.bspjiaceh.id/login'],
        ['label' => 'Jejak Pendapat', 'url' => '#'],
    ];

    $mainMenu = [
        ['type' => 'link', 'label' => 'Beranda', 'url' => url('/')],
        ['type' => 'dropdown', 'key' => 'profil', 'label' => 'Profil', 'items' => $profilMenu],
        ['type' => 'dropdown', 'key' => 'pelayanan', 'label' => 'Pelayanan', 'items' => $pelayananMenu],
        ['type' => 'dropdown', 'key' => 'informasi-publik', 'label' => 'Informasi Publik', 'items' => $informasiPublikMenu],
        ['type' => 'dropdown', 'key' => 'tautan', 'label' => 'Tautan', 'items' => $tautanMenu],
        ['type' => 'link', 'label' => 'Berita', 'url' => $routeOrHash('berita.index')],
        ['type' => 'link', 'label' => 'Hubungi Kami', 'url' => $routeOrHash('hubungi-kami.index')],
    ];

    $displayMenu = $isTransparent
        ? array_values(array_filter($mainMenu, static fn(array $menu): bool => $menu['label'] !== 'Hubungi Kami'))
        : $mainMenu;
@endphp

<nav @if ($isTransparent) x-data="{
        mobileOpen: false,
        mobileDropdown: null,
        lastScrollY: 0,
        isHidden: false,
        isSolid: false,
        updateNavbar() {
            const currentScrollY = Math.max(window.scrollY || 0, 0);
            const heroLimit = Math.max(window.innerHeight - 120, 160);
            const transparentLimit = Math.max(window.innerHeight - 220, 260);
            const scrollingDown = currentScrollY > this.lastScrollY;

            if (currentScrollY <= transparentLimit) {
                this.isSolid = false;
            } else if (currentScrollY > heroLimit || !scrollingDown) {
                this.isSolid = true;
            }

            this.isHidden = !this.mobileOpen && scrollingDown && currentScrollY > 120;
            this.lastScrollY = currentScrollY;
        },
        init() {
            this.lastScrollY = Math.max(window.scrollY || 0, 0);
            this.updateNavbar();
            window.addEventListener('scroll', () => this.updateNavbar(), { passive: true });
            window.addEventListener('resize', () => this.updateNavbar());
        }
    }" :class="[
        isHidden ? '-translate-y-full' : 'translate-y-0',
        isSolid ? 'text-slate-900' : 'text-white'
]" class="fixed inset-x-0 top-0 z-50 transition-all duration-300 ease-out" @else
    x-data="{ mobileOpen: false, mobileDropdown: null }"
    class="fixed inset-x-0 top-0 z-100 border-b border-slate-200/70 bg-white/90 text-slate-900 shadow-sm backdrop-blur-xl"
@endif>
    <div @if ($isTransparent)
        class="mx-auto flex h-28 w-full items-center justify-between gap-6 px-5 transition-all duration-300 sm:px-8 lg:px-10"
    @else class="mx-auto flex h-20 w-full max-w-6xl items-center gap-16 px-4 sm:px-6 lg:px-0" @endif>
        <div class="flex shrink-0 items-center pr-2">
            <a href="{{ url('/') }}"
                class="{{ $isTransparent ? 'group inline-flex items-center p-0 transition hover:opacity-85' : 'group inline-flex items-center rounded-xl p-1 transition hover:bg-slate-50' }}">
                @if ($isTransparent)
                    <span class="relative inline-block h-[100px] sm:h-[110px]">
                        <img src="{{ asset('images/profil/logobalai.png') }}" alt="Logo BSPJI Banda Aceh"
                            :class="isSolid ? 'opacity-100' : 'opacity-0'"
                            class="block h-full w-auto max-w-none object-contain transition-opacity duration-300">
                        <img src="{{ asset('images/profil/logowhite.webp') }}" alt="" aria-hidden="true"
                            :class="isSolid ? 'opacity-0' : 'opacity-100'"
                            class="absolute left-0 top-0 block h-full w-auto max-w-none object-contain transition-opacity duration-300">
                    </span>
                @else
                    <img src="{{ asset('images/profil/logobalai.png') }}" alt="Logo BSPJI Banda Aceh"
                        class="block h-[70px] w-auto max-w-none object-contain">
                @endif
            </a>
        </div>

        <div
            class="{{ $isTransparent ? 'ml-auto hidden min-w-0 shrink-0 items-center justify-end xl:flex' : 'hidden min-w-0 flex-1 items-center justify-center lg:flex' }}">
            <ul @if ($isTransparent)
                :class="isSolid ? 'border-slate-300 bg-white/90 shadow-lg shadow-slate-950/10' : 'border-white/25 bg-neutral-950/60 shadow-2xl shadow-black/25'"
                class="flex items-center gap-1.5 rounded-full border p-1.5 backdrop-blur-xl transition-all duration-300"
            @else class="flex w-full items-center justify-center gap-4" @endif>
                @foreach ($displayMenu as $menu)
                    @if ($menu['type'] === 'link')
                        <li>
                            <a href="{{ $menu['url'] }}" @if ($isTransparent)
                                :class="isSolid ? 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' : 'text-white/90 hover:bg-white/10 hover:text-white'"
                                class="inline-flex items-center whitespace-nowrap rounded-full px-4 py-2.5 text-base font-medium transition xl:px-5"
                            @else
                                    class="inline-flex items-center whitespace-nowrap px-1 py-2 text-md font-semibold text-slate-700 transition hover:text-slate-900 xl:px-2"
                                @endif>
                                {{ $menu['label'] }}
                            </a>
                        </li>
                    @else
                        <li x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                            <button type="button" @click="open = !open" @if ($isTransparent)
                                :class="isSolid ? 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' : 'text-white/90 hover:bg-white/10 hover:text-white'"
                                class="inline-flex items-center gap-1 whitespace-nowrap rounded-full px-4 py-2.5 text-base font-medium transition xl:px-5"
                            @else
                                    class="inline-flex items-center gap-1 whitespace-nowrap px-1 py-2 text-md font-semibold text-slate-700 transition hover:text-slate-900 xl:px-2"
                                @endif>
                                <span>{{ $menu['label'] }}</span>
                                <svg class="h-4 w-4 transition-transform duration-150" :class="open ? 'rotate-180' : ''"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1" @if ($isTransparent)
                                    :class="isSolid ? 'border-slate-200 bg-white text-slate-900 shadow-xl' : 'border-white/15 bg-slate-950/85 text-white shadow-2xl shadow-black/25'"
                                    class="absolute left-1/2 top-full mt-2 w-80 -translate-x-1/2 overflow-hidden rounded-2xl border backdrop-blur-xl sm:w-[450px]"
                                @else
                                    class="absolute left-1/2 top-full mt-2 w-80 -translate-x-1/2 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl sm:w-[450px]"
                                @endif style="display: none;">
                                <div class="p-2">
                                    @foreach ($menu['items'] as $item)
                                        <a href="{{ $item['url'] }}" @if ($isTransparent)
                                            :class="isSolid ? 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' : 'text-white/80 hover:bg-white/10 hover:text-white'"
                                        class="block rounded-xl px-3 py-2 text-md font-medium transition" @else
                                                class="block rounded-xl px-3 py-2 text-md font-medium text-slate-700 transition hover:bg-slate-100 hover:text-slate-900"
                                            @endif>
                                            {{ $item['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
                @if ($isTransparent)
                    <li class="pl-3">
                        <a href="#"
                            :class="isSolid ? 'bg-slate-900 text-white hover:bg-slate-800' : 'bg-white text-slate-950 hover:bg-white/90'"
                            class="inline-flex items-center whitespace-nowrap rounded-full px-6 py-2.5 text-sm font-bold uppercase shadow-lg shadow-black/20 transition">
                            SIPINTU
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="flex shrink-0 items-center justify-end gap-2 pl-2">
            <a href="#"
                class="{{ $isTransparent ? 'hidden' : 'hidden items-center rounded-full bg-slate-900 px-6 py-2 text-sm font-bold text-white shadow-md transition hover:bg-slate-800 lg:inline-flex' }}">
                SiPINTU
            </a>
            <button type="button" @if ($isTransparent)
                :class="isSolid ? 'border-slate-200 bg-white/90 text-slate-900 hover:bg-white' : 'border-white/25 bg-neutral-950/55 text-white hover:bg-neutral-950/70'"
                class="inline-flex h-11 w-11 items-center justify-center rounded-full border shadow-lg shadow-black/20 backdrop-blur-xl transition xl:hidden"
            @else
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 transition hover:bg-slate-100 lg:hidden"
                @endif @click="mobileOpen = !mobileOpen" aria-label="Buka menu navigasi">
                <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                <svg x-show="mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" @if ($isTransparent)
            :class="isSolid ? 'border-slate-200 bg-white/95 text-slate-900 shadow-xl' : 'border-white/10 bg-slate-950/85 text-white shadow-2xl shadow-black/25'"
        class="border-t px-4 py-5 backdrop-blur-xl xl:hidden sm:px-6" @else
        class="border-t border-slate-200 bg-white/95 px-4 py-5 shadow-xl backdrop-blur lg:hidden sm:px-6" @endif
        style="display: none;">
        <div class="space-y-2">
            @foreach ($displayMenu as $menu)
                @if ($menu['type'] === 'link')
                    <a href="{{ $menu['url'] }}" @if ($isTransparent)
                        :class="isSolid ? 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' : 'text-white/85 hover:bg-white/10 hover:text-white'"
                    class="block rounded-xl px-4 py-3 text-sm font-semibold transition" @else
                            class="block rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-900"
                        @endif @click="mobileOpen = false; mobileDropdown = null">
                        {{ $menu['label'] }}
                    </a>
                @else
                    <div @if ($isTransparent)
                        :class="isSolid ? 'border-slate-200 bg-slate-50/70' : 'border-white/10 bg-white/5'"
                    class="rounded-xl border" @else class="rounded-xl border border-slate-200" @endif>
                        <button type="button" @if ($isTransparent) :class="isSolid ? 'text-slate-700' : 'text-white/85'"
                        class="flex w-full items-center justify-between px-4 py-3 text-left text-sm font-semibold" @else
                                class="flex w-full items-center justify-between px-4 py-3 text-left text-sm font-semibold text-slate-700"
                            @endif
                            @click="mobileDropdown = mobileDropdown === '{{ $menu['key'] }}' ? null : '{{ $menu['key'] }}'">
                            <span>{{ $menu['label'] }}</span>
                            <svg class="h-4 w-4 transition-transform duration-150"
                                :class="mobileDropdown === '{{ $menu['key'] }}' ? 'rotate-180' : ''" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="mobileDropdown === '{{ $menu['key'] }}'" @if ($isTransparent)
                            :class="isSolid ? 'border-slate-200 bg-white/50' : 'border-white/10 bg-black/10'"
                        class="space-y-1 border-t p-2" @else class="space-y-1 border-t border-slate-200 bg-slate-50/60 p-2"
                            @endif style="display: none;">
                            @foreach ($menu['items'] as $item)
                                <a href="{{ $item['url'] }}" @if ($isTransparent)
                                    :class="isSolid ? 'text-slate-700 hover:bg-white hover:text-slate-950' : 'text-white/75 hover:bg-white/10 hover:text-white'"
                                class="block rounded-lg px-3 py-2 text-sm font-medium transition" @else
                                        class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-white hover:text-slate-900"
                                    @endif @click="mobileOpen = false; mobileDropdown = null">
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
            @if ($isTransparent)
                <a href="#"
                    :class="isSolid ? 'bg-slate-900 text-white hover:bg-slate-800' : 'bg-white text-slate-950 hover:bg-white/90'"
                    class="block rounded-full px-4 py-3 text-center text-sm font-extrabold uppercase transition"
                    @click="mobileOpen = false; mobileDropdown = null">
                    SIPINTU
                </a>
            @endif
        </div>
    </div>
</nav>