@php
    $routeOrHash = static fn(string $name): string => Route::has($name) ? route($name) : '#';
@endphp

<footer class="relative overflow-hidden bg-slate-950 text-slate-200">
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -top-24 right-0 h-80 w-80 rounded-full bg-orange-500/10 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-10 h-72 w-72 rounded-full bg-sky-400/10 blur-3xl"></div>
    </div>
    <div class="relative mx-auto max-w-7xl px-6 py-14 md:py-16 lg:px-0">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4 md:gap-12">
            <div>
                <p class="mb-4 text-[11px] uppercase tracking-[0.24em] text-slate-400">BSPJI Banda Aceh</p>
                <h3 class="mb-3 text-2xl font-semibold leading-tight text-white">Mitra Standardisasi Industri</h3>
                <p class="text-sm leading-relaxed text-slate-400">Dummy footer untuk menampilkan gaya modern, clean, dan profesional pada bagian akhir halaman.</p>
            </div>
            <div>
                <h4 class="mb-4 text-sm font-semibold uppercase tracking-[0.18em] text-white">Layanan</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="{{ $routeOrHash('sertifikasi-produk.index') }}" class="transition-colors hover:text-white">Sertifikasi Produk</a></li>
                    <li><a href="{{ $routeOrHash('lph.index') }}" class="transition-colors hover:text-white">Sertifikasi Halal</a></li>
                    <li><a href="{{ $routeOrHash('kalibrasi.index') }}" class="transition-colors hover:text-white">Kalibrasi Alat</a></li>
                    <li><a href="{{ $routeOrHash('tkdn.index') }}" class="transition-colors hover:text-white">Verifikasi TKDN</a></li>
                </ul>
            </div>
            <div>
                <h4 class="mb-4 text-sm font-semibold uppercase tracking-[0.18em] text-white">Navigasi</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="{{ url('/') }}" class="transition-colors hover:text-white">Beranda</a></li>
                    <li><a href="{{ url('/') }}#layanan" class="transition-colors hover:text-white">Layanan Kami</a></li>
                    <li><a href="{{ url('/') }}#sertifikat" class="transition-colors hover:text-white">Sertifikat</a></li>
                    <li><a href="{{ url('/') }}#peta-pelanggan" class="transition-colors hover:text-white">Peta Pelanggan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="mb-4 text-sm font-semibold uppercase tracking-[0.18em] text-white">Kontak Dummy</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li>Jl. Industri No. 10, Banda Aceh</li>
                    <li>+62 651 123456</li>
                    <li>info@bspji-dummy.id</li>
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-3 border-t border-white/10 pt-6 md:flex-row md:items-center md:justify-between md:gap-0">
            <p class="text-xs text-slate-500">© {{ now()->year }} BSPJI Banda Aceh. All rights reserved.</p>
            <p class="text-xs text-slate-500">Designed for demo purpose.</p>
        </div>
    </div>
</footer>
