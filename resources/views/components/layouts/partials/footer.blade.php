@php
    use App\Models\News;
    $routeOrHash = static fn(string $name, array $params = []): string => Route::has($name) ? route($name, $params) : '#';

    $latestNews = News::published()->latest('published_at')->take(4)->get();
@endphp

<footer class="relative overflow-hidden bg-slate-950 text-slate-200">
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -top-24 right-0 h-80 w-80 rounded-full bg-blue-600/10 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-10 h-72 w-72 rounded-full bg-orange-500/10 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-6xl px-6 py-16 lg:px-0">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:gap-16">
            {{-- Left Column: Brand, Address, Socials --}}
            <div class="lg:col-span-5">
                <div class="flex flex-col gap-10">
                    {{-- Brand Header --}}
                    <div class="flex flex-col items-start gap-6 sm:flex-row sm:items-center">
                        <img src="{{ asset('images/profil/logowhite.webp') }}" alt="Logo BSPJI Banda Aceh"
                            class="h-24 w-auto">
                        <div class="h-px w-10 bg-white/20 sm:h-16 sm:w-px"></div>
                        <h3 class="text-base font-bold leading-tight tracking-wide text-white uppercase max-w-[250px]">
                            Balai Standardisasi dan Pelayanan Jasa Industri <span
                                class="block mt-1 text-sm font-medium text-blue-400">Banda Aceh</span>
                        </h3>
                    </div>

                    {{-- Address & Socials --}}
                    <div class="space-y-8">
                        <ul class="space-y-4 text-[15px] text-slate-400">
                            <li class="flex items-start gap-3">
                                <i data-lucide="map-pin" class="mt-0.5 h-5 w-5 shrink-0 text-blue-400"></i>
                                <span>Jl. Cut Nyak Dhien No.377, Lamtemeun Timur, Kec. Jaya Baru, Kota Banda Aceh, Prov. Aceh</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <i data-lucide="phone" class="h-5 w-5 shrink-0 text-blue-400"></i>
                                <span>(0651) 49714</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <i data-lucide="mail" class="h-5 w-5 shrink-0 text-blue-400"></i>
                                <span>bspjiaceh@gmail.com</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i data-lucide="clock" class="mt-0.5 h-5 w-5 shrink-0 text-blue-400"></i>
                                <div class="flex flex-col">
                                    <span>Sen - Kam : 07.30 - 16.00 WIB</span>
                                    <span>Jum'at : 07.30 - 16.30 WIB</span>
                                </div>
                            </li>
                        </ul>

                        {{-- <div class="flex items-center gap-4">
                            <a href="https://instagram.com" target="_blank"
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/5 text-slate-300 transition-all hover:bg-blue-600 hover:text-white hover:-translate-y-1">
                                <i data-lucide="instagram" class="h-5 w-5"></i>
                            </a>
                            <a href="https://tiktok.com" target="_blank"
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/5 text-slate-300 transition-all hover:bg-blue-600 hover:text-white hover:-translate-y-1">
                                <i data-lucide="music" class="h-5 w-5"></i>
                            </a>
                            <a href="https://youtube.com" target="_blank"
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/5 text-slate-300 transition-all hover:bg-blue-600 hover:text-white hover:-translate-y-1">
                                <i data-lucide="youtube" class="h-5 w-5"></i>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- Center Column: Navigation --}}
            <div class="lg:col-span-3">
                <h4 class="mb-8 text-xs font-bold uppercase tracking-[0.2em] text-white">Navigasi Utama</h4>
                <ul class="space-y-4 text-[15px] text-slate-400">
                    <li><a href="{{ $routeOrHash('pengujian.index', []) }}"
                            class="transition-colors hover:text-white flex items-center gap-2 group"><i
                                data-lucide="chevron-right"
                                class="h-3 w-3 text-slate-600 transition-transform group-hover:translate-x-1"></i>
                            Pengujian</a></li>
                    <li><a href="{{ $routeOrHash('kalibrasi.index', []) }}"
                            class="transition-colors hover:text-white flex items-center gap-2 group"><i
                                data-lucide="chevron-right"
                                class="h-3 w-3 text-slate-600 transition-transform group-hover:translate-x-1"></i>
                            Kalibrasi</a></li>
                    <li><a href="{{ $routeOrHash('sertifikasi-produk.index', []) }}"
                            class="transition-colors hover:text-white flex items-center gap-2 group"><i
                                data-lucide="chevron-right"
                                class="h-3 w-3 text-slate-600 transition-transform group-hover:translate-x-1"></i>
                            Sertifikasi Produk</a></li>
                    <li><a href="{{ $routeOrHash('lph.index', []) }}"
                            class="transition-colors hover:text-white flex items-center gap-2 group"><i
                                data-lucide="chevron-right"
                                class="h-3 w-3 text-slate-600 transition-transform group-hover:translate-x-1"></i>
                            Lembaga Pemeriksa Halal</a></li>
                    <li><a href="{{ $routeOrHash('lsih.index', []) }}"
                            class="transition-colors hover:text-white flex items-center gap-2 group"><i
                                data-lucide="chevron-right"
                                class="h-3 w-3 text-slate-600 transition-transform group-hover:translate-x-1"></i>
                            Lembaga Sertifikasi Industri Hijau</a></li>
                    <li><a href="{{ $routeOrHash('tkdn.index', []) }}"
                            class="transition-colors hover:text-white flex items-center gap-2 group"><i
                                data-lucide="chevron-right"
                                class="h-3 w-3 text-slate-600 transition-transform group-hover:translate-x-1"></i>
                            Verifikasi TKDN</a></li>
                    <li><a href="{{ $routeOrHash('pelatihan-teknis.index', []) }}"
                            class="transition-colors hover:text-white flex items-center gap-2 group"><i
                                data-lucide="chevron-right"
                                class="h-3 w-3 text-slate-600 transition-transform group-hover:translate-x-1"></i>
                            Pelatihan Teknis</a></li>
                    <li><a href="{{ $routeOrHash('konsultasi-pendampingan.index', []) }}"
                            class="transition-colors hover:text-white flex items-center gap-2 group"><i
                                data-lucide="chevron-right"
                                class="h-3 w-3 text-slate-600 transition-transform group-hover:translate-x-1"></i>
                            Konsultansi</a></li>
                </ul>
            </div>

            {{-- Right Column: News --}}
            <div class="lg:col-span-4">
                <h4 class="mb-8 text-xs font-bold uppercase tracking-[0.2em] text-white">Berita Terkini</h4>
                <div class="divide-y divide-white/30">
                    @forelse ($latestNews as $news)
                        <a href="{{ $routeOrHash('berita.show', ['news' => $news->slug]) }}" class="group flex gap-4 py-5 first:pt-0 last:pb-0">
                            @if($news->cover_image)
                                <div class="h-16 w-16 shrink-0 overflow-hidden rounded-lg bg-slate-800">
                                    <img src="{{ Storage::url($news->cover_image) }}" alt="{{ $news->title }}"
                                        class="h-full w-full object-cover transition-transform group-hover:scale-110">
                                </div>
                            @endif
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-blue-400">
                                    {{ $news->published_at?->translatedFormat('d M Y') }}
                                </p>
                                <h5
                                    class="line-clamp-2 text-[14px] leading-snug font-medium text-slate-300 transition-colors group-hover:text-white">
                                    {{ $news->title }}
                                </h5>
                            </div>
                        </a>
                    @empty
                        <p class="text-[14px] italic text-slate-500">Belum ada berita terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div
            class="mt-16 flex flex-col items-center justify-between gap-6 border-t border-white/5 pt-8 md:flex-row md:gap-0">
            <p class="text-[13px] text-slate-500">
                &copy; {{ now()->year }} <span class="font-medium text-slate-400">BSPJI Banda Aceh</span>. Kementerian
                Perindustrian RI.
            </p>
            <!-- <div class="flex items-center gap-6 text-[13px] text-slate-500 font-medium">
                <a href="#" class="transition-colors hover:text-slate-300">Kebijakan Privasi</a>
                <a href="#" class="transition-colors hover:text-slate-300">Syarat & Ketentuan</a>
            </div> -->
        </div>
    </div>
</footer>