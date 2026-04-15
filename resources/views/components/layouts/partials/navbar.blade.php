@php
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
        ['label' => 'Informasi Publik', 'url' => $routeOrHash('informasi-publik.index')],
        ['label' => 'PPID', 'url' => $routeOrHash('ppid.index')],
    ];

    $tautanMenu = [
        ['label' => 'Berita', 'url' => '#'],
        ['label' => 'SIPPN', 'url' => '#'],
        ['label' => 'Lapor', 'url' => '#'],
    ];

    $mainMenu = [
        ['type' => 'link', 'label' => 'Beranda', 'url' => url('/')],
        ['type' => 'dropdown', 'key' => 'profil', 'label' => 'Profil', 'items' => $profilMenu],
        ['type' => 'dropdown', 'key' => 'pelayanan', 'label' => 'Pelayanan', 'items' => $pelayananMenu],
        ['type' => 'dropdown', 'key' => 'informasi-publik', 'label' => 'Informasi Publik', 'items' => $informasiPublikMenu],
        ['type' => 'dropdown', 'key' => 'tautan', 'label' => 'Tautan', 'items' => $tautanMenu],
        ['type' => 'link', 'label' => 'Hubungi Kami', 'url' => '#'],
    ];
@endphp

<nav x-data="{ mobileOpen: false, mobileDropdown: null }"
    class="fixed inset-x-0 top-0 z-100 border-b border-slate-200/70 bg-white/90 backdrop-blur-xl shadow-sm">
    <div class="mx-auto flex h-20 w-full max-w-6xl items-center gap-16 px-4 sm:px-6 lg:px-0">
        <div class="flex shrink-0 items-center pr-2">
            <a href="{{ url('/') }}" class="group inline-flex items-center rounded-xl p-1 transition hover:bg-slate-50">
                <img src="{{ asset('images/profil/logobalai.png') }}" alt="Logo BSPJI Banda Aceh"
                    class="block h-[70px] w-auto max-w-none object-contain">
            </a>
        </div>

        <div class="hidden min-w-0 flex-1 items-center justify-center lg:flex">
            <ul
                class="flex w-full items-center justify-center gap-1 rounded-full border border-slate-200/80 bg-white/85 p-1.5 shadow-sm">
                @foreach ($mainMenu as $menu)
                    @if ($menu['type'] === 'link')
                        <li>
                            <a href="{{ $menu['url'] }}"
                                class="inline-flex items-center whitespace-nowrap rounded-full px-2.5 py-2 text-md font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 xl:px-3">
                                {{ $menu['label'] }}
                            </a>
                        </li>
                    @else
                        <li x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                            <button type="button" @click="open = !open"
                                class="inline-flex items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-2 text-md font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 xl:px-3">
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
                                x-transition:leave-end="opacity-0 translate-y-1"
                                class="absolute left-1/2 top-full mt-2 w-64 -translate-x-1/2 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl"
                                style="display: none;">
                                <div class="p-2">
                                    @foreach ($menu['items'] as $item)
                                        <a href="{{ $item['url'] }}"
                                            class="block rounded-xl px-3 py-2 text-md font-medium text-slate-700 transition hover:bg-slate-100 hover:text-slate-900">
                                            {{ $item['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="flex shrink-0 items-center justify-end gap-2 pl-2">
            <a href="#"
                class="hidden items-center rounded-full bg-slate-900 px-6 py-2 text-sm font-bold text-white shadow-md transition hover:bg-slate-800 lg:inline-flex">
                SiPINTU
            </a>
            <button type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 transition hover:bg-slate-100 lg:hidden"
                @click="mobileOpen = !mobileOpen" aria-label="Buka menu navigasi">
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
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="border-t border-slate-200 bg-white/95 px-4 py-5 shadow-xl backdrop-blur lg:hidden sm:px-6"
        style="display: none;">
        <div class="space-y-2">
            @foreach ($mainMenu as $menu)
                @if ($menu['type'] === 'link')
                    <a href="{{ $menu['url'] }}"
                        class="block rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-900"
                        @click="mobileOpen = false; mobileDropdown = null">
                        {{ $menu['label'] }}
                    </a>
                @else
                    <div class="rounded-xl border border-slate-200">
                        <button type="button"
                            class="flex w-full items-center justify-between px-4 py-3 text-left text-sm font-semibold text-slate-700"
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
                        <div x-show="mobileDropdown === '{{ $menu['key'] }}'"
                            class="space-y-1 border-t border-slate-200 bg-slate-50/60 p-2" style="display: none;">
                            @foreach ($menu['items'] as $item)
                                <a href="{{ $item['url'] }}"
                                    class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-white hover:text-slate-900"
                                    @click="mobileOpen = false; mobileDropdown = null">
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</nav>