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

            {{-- Right Column: Video Profil --}}
            <div class="lg:col-span-4" x-data="{ isPlaying: false }">
                <h4 class="mb-8 text-xs font-bold uppercase tracking-[0.2em] text-white">Video Profil</h4>
                
                <div class="relative aspect-video w-full overflow-hidden rounded-2xl border border-white/10 bg-slate-900 shadow-xl transition-all duration-300 hover:border-red-500/30 group">
                    {{-- Thumbnail Mode --}}
                    <template x-if="!isPlaying">
                        <button 
                            @click="isPlaying = true" 
                            class="absolute inset-0 flex h-full w-full flex-col items-center justify-center text-center focus:outline-none cursor-pointer"
                            aria-label="Putar Video Profil BSPJI Banda Aceh"
                        >
                            {{-- Background Thumbnail Image --}}
                            <img 
                                src="https://img.youtube.com/vi/1CRk9LeyIGo/hqdefault.jpg" 
                                alt="Thumbnail Video Profil BSPJI Banda Aceh"
                                class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                            >
                            
                            {{-- Play Button Icon --}}
                            <div class="relative z-10 flex h-14 w-14 items-center justify-center rounded-full bg-red-600 text-white shadow-lg shadow-red-500/30 transition-all duration-300 group-hover:scale-110 group-hover:bg-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                                    <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </template>

                    {{-- Iframe Mode --}}
                    <template x-if="isPlaying">
                        <iframe 
                            class="absolute inset-0 h-full w-full"
                            src="https://www.youtube-nocookie.com/embed/1CRk9LeyIGo?autoplay=1" 
                            title="YouTube video player" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            referrerpolicy="strict-origin-when-cross-origin" 
                            allowfullscreen
                        ></iframe>
                    </template>
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

    <!--Start of Tawk.to Script-->
	<script type="text/javascript">
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/63ede925474251287913a52e/1gpcldf9n';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
	})();
	</script>
	<!--End of Tawk.to Script-->
</footer>