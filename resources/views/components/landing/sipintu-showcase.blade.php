@props([
    'sipintuDesktopImage',
    'sipintuMobileImage',
])

<section id="app-showcase" class="relative z-30 flex min-h-[500px] w-full items-center bg-slate-950 lg:h-[60vh]">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 opacity-20"
            style="background-image: radial-gradient(#ffffff20 0.5px, transparent 0.5px); background-size: 24px 24px;">
        </div>
        <div
            class="absolute -left-20 top-1/4 h-[600px] w-[600px] animate-pulse rounded-full bg-blue-600/10 blur-[120px]">
        </div>
        <div
            class="absolute -right-20 bottom-1/4 h-[500px] w-[500px] animate-pulse rounded-full bg-orange-500/10 blur-[120px] delay-1000">
        </div>
    </div>

    <div class="relative mx-auto h-full w-full max-w-6xl px-6 lg:px-0">
        <div class="relative flex h-full flex-col items-center lg:flex-row">
            <div class="z-20 w-full py-12 lg:w-5/12 lg:py-0" data-aos="fade-right">
                <h2 class="mb-8 text-2xl font-semibold leading-[1.2] text-white md:text-[30px]">
                    SIPINTU
                </h2>

                <p class="mb-8 max-w-md text-base font-light text-white/80 sm:text-lg">
                    Sistem Informasi Pelayanan Industri Terpadu (SIPINTU) BSPJI Banda Aceh ada untuk memudahkan
                    pelanggan mengakses semua layanan. Cukup satu akun untuk semua layanan.
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="http://pintu.bspjiaceh.id/login"
                        class="flex items-center gap-2 rounded-full bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/35 transition-all hover:bg-blue-700">
                        <i data-lucide="log-in" class="h-4 w-4"></i> Login
                    </a>
                    <a href="http://pintu.bspjiaceh.id/register"
                        class="flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-6 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition-all hover:bg-white/20">
                        <i data-lucide="user-plus" class="h-4 w-4"></i> Daftar
                    </a>
                </div>

                {{--
                <div class="mt-8 max-w-md rounded-2xl backdrop-blur-md">
                    <p class="mb-3 text-xs uppercase tracking-[0.2em] text-white/65">Cek Order</p>
                    <form class="flex flex-col gap-2.5 sm:flex-row">
                        <input type="text" name="nomor-berita-acara" placeholder="Masukkan nomor berita acara"
                            class="w-full rounded-xl bg-white/95 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-500 outline-none ring-0 focus:ring-2 focus:ring-blue-400/70 sm:flex-1">
                        <button type="submit"
                            class="shrink-0 rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-900 transition-colors hover:bg-slate-100">
                            Cek
                        </button>
                    </form>
                    <p class="mt-2 text-xs text-white/65">Contoh: BA-2026-001245</p>
                </div>
                --}}
            </div>

            <div class="relative mt-8 flex h-full w-full items-center justify-center lg:mt-0 lg:w-7/12 lg:justify-end"
                data-aos="fade-up" data-aos-delay="200">
                <div class="group relative z-10 w-[400px] translate-y-8 sm:w-[500px] lg:w-[550px] lg:-translate-x-12 lg:translate-y-0">
                    <div
                        class="relative aspect-16/10 overflow-hidden rounded-t-2xl border-[6px] border-gray-700 bg-gray-800 shadow-2xl">
                        <div class="h-full w-full overflow-hidden bg-white">
                            <img src="{{ $sipintuDesktopImage }}" alt="Preview aplikasi SIPINTU pada layar laptop"
                                class="h-full w-full object-contain transition-transform duration-700 group-hover:scale-[1.03]">
                        </div>
                    </div>
                    <div
                        class="relative -left-[5%] -z-10 flex h-3 w-[110%] justify-center rounded-b-xl bg-gray-600 shadow-[0_20px_50px_rgba(0,0,0,0.5)] sm:h-4">
                        <div class="h-full w-20 rounded-b-md bg-gray-700 opacity-50"></div>
                    </div>
                </div>

                {{--
                <div
                    class="absolute -top-16 right-4 z-40 rotate-[-5deg] transform drop-shadow-2xl transition-transform duration-500 ease-out hover:rotate-0 lg:-right-4 lg:-top-24">
                    <div
                        class="relative h-[360px] w-[180px] overflow-hidden rounded-[2.5rem] border-4 border-gray-800 bg-black shadow-2xl sm:h-[400px] sm:w-[200px]">
                        <div class="relative h-full w-full overflow-hidden bg-white">
                            <img src="{{ $sipintuMobileImage }}" alt="Preview aplikasi SIPINTU pada layar smartphone"
                                class="h-full w-full object-contain">
                        </div>
                    </div>
                </div>
                --}}
            </div>
        </div>
    </div>
</section>
