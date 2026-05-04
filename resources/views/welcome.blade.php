@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $routeOrHash = static fn(string $name): string => Route::has($name) ? route($name) : '#';

    $profileFallbacks = [
        'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=1000',
        'https://images.unsplash.com/photo-1513828583688-c52646db42da?auto=format&fit=crop&q=80&w=700',
        'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=900',
    ];

    $profils = $sectionProfils ?? collect();
    $profileImages = collect(range(0, 2))->map(function (int $index) use ($profils, $profileFallbacks) {
        $item = $profils->get($index);
        return $item?->foto ? Storage::url($item->foto) : $profileFallbacks[$index];
    });

    $sipintuDesktopImage = $sectionSipintu?->gambar_desktop
        ? Storage::url($sectionSipintu->gambar_desktop)
        : 'https://images.unsplash.com/photo-1518773553398-650c184e0bb3?auto=format&fit=crop&q=80&w=1200';
    $sipintuMobileImage = $sectionSipintu?->gambar_mobile
        ? Storage::url($sectionSipintu->gambar_mobile)
        : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&q=80&w=800';

    $serviceRouteMap = [
        'pengujian' => $routeOrHash('pengujian.index'),
        'kalibrasi' => $routeOrHash('kalibrasi.index'),
        'kalibrasi-alat' => $routeOrHash('kalibrasi.index'),
        'sertifikasi-produk' => $routeOrHash('sertifikasi-produk.index'),
        'sertifikasi-halal' => $routeOrHash('lph.index'),
        'lembaga-pemeriksa-halal' => $routeOrHash('lph.index'),
        'industri-hijau' => $routeOrHash('lsih.index'),
        'lsih' => $routeOrHash('lsih.index'),
        'verifikasi-tkdn' => $routeOrHash('tkdn.index'),
        'tkdn' => $routeOrHash('tkdn.index'),
        'pelatihan-teknis' => $routeOrHash('pelatihan-teknis.index'),
        'konsultasi-industri' => $routeOrHash('konsultasi-pendampingan.index'),
        'konsultasi-pendampingan' => $routeOrHash('konsultasi-pendampingan.index'),
    ];

    $serviceIconMap = [
        'sertifikasi-produk' => 'shield-check',
        'sertifikasi-halal' => 'badge-check',
        'lembaga-pemeriksa-halal' => 'badge-check',
        'kalibrasi' => 'gauge',
        'kalibrasi-alat' => 'gauge',
        'industri-hijau' => 'leaf',
        'lsih' => 'leaf',
        'pengujian' => 'flask-conical',
        'verifikasi-tkdn' => 'factory',
        'tkdn' => 'factory',
        'konsultasi-industri' => 'users',
        'konsultasi-pendampingan' => 'users',
        'pelatihan-teknis' => 'graduation-cap',
    ];

    $logosCollection = $logos->values();
    $firstLogoGroupCount = (int) ceil(max(1, $logosCollection->count()) / 2);
    $firstLogoGroup = $logosCollection->slice(0, $firstLogoGroupCount)->values();
    $secondLogoGroup = $logosCollection->slice($firstLogoGroupCount)->values();
    if ($secondLogoGroup->isEmpty()) {
        $secondLogoGroup = $firstLogoGroup;
    }

    $showcaseImage = $pelengkaps->first()?->gambar
        ? Storage::url($pelengkaps->first()->gambar)
        : 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1200&auto=format&fit=crop';

    $faqImages = $pelengkaps->take(4)->map(fn($pelengkap) => Storage::url($pelengkap->gambar))->values();
    $faqFallbacks = [
        'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1200&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1581093450021-4a7360e9a6b5?q=80&w=1200&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1563013544-824ae1b704d3?q=80&w=1200&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=1200&auto=format&fit=crop',
    ];
    $faqDisplayImages = collect(range(0, 3))->map(fn(int $index) => $faqImages->get($index) ?? $faqFallbacks[$index]);
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSPJI Banda Aceh - Mendorong Inovasi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        .font-ultra-light {
            font-weight: 300;
        }

        .align-left-container {
            padding-left: max(1.5rem, calc((100vw - 1280px) / 2));
        }

        .pattern-grid-lg {
            background-image:
                linear-gradient(to right, rgba(148, 163, 184, 0.2) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(148, 163, 184, 0.2) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .section-title-identic {
            font-family: 'Inter', sans-serif;
            font-size: 32px;
            line-height: 1.1;
            font-weight: 300;
            letter-spacing: -0.025em;
        }

        @media (min-width: 768px) {
            .section-title-identic {
                font-size: 48px;
            }
        }

        .logo-marquee {
            position: relative;
            overflow: hidden;
            mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            padding: 0.5rem 0;
        }

        .logo-marquee-track {
            display: flex;
            align-items: center;
            width: max-content;
            animation: logo-marquee-scroll 28s linear infinite;
        }

        .logo-marquee-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-right: 1rem;
            flex-shrink: 0;
        }

        .logo-chip {
            width: 160px;
            height: 72px;
            border-radius: 1rem;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.65rem;
        }

        .logo-chip img {
            max-width: 100%;
            max-height: 48px;
            object-fit: contain;
        }

        .certificate-card {
            display: block;
            flex: 0 0 calc(50% - 1rem);
            max-width: calc(50% - 1rem);
        }

        @media (min-width: 640px) {
            .certificate-card {
                flex: 0 0 calc(33.33% - 1.25rem);
                max-width: calc(33.33% - 1.25rem);
            }
        }

        @media (min-width: 1024px) {
            .certificate-card {
                flex: 0 0 calc(20% - 1.25rem);
                max-width: calc(20% - 1.25rem);
            }
        }

        .certificate-media {
            border-radius: 0.875rem;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow:
                0 10px 28px -20px rgba(15, 23, 42, 0.55),
                0 22px 40px -36px rgba(15, 23, 42, 0.55);
        }

        .certificate-title-wrap {
            min-height: 56px;
            padding: 0.85rem 0.2rem 0;
            display: flex;
            align-items: flex-start;
        }

        .certificate-title {
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .numbers-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 1rem 1rem 0.75rem;
            box-shadow: 0 12px 30px -28px rgba(15, 23, 42, 0.55);
        }

        .numbers-chart {
            width: 100%;
            height: 320px;
        }

        .numbers-chart svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .map-distribution-card {
            background: #ffffff;
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow:
                0 2px 8px rgba(15, 23, 42, 0.06),
                0 14px 34px -16px rgba(15, 23, 42, 0.2),
                0 28px 60px -30px rgba(15, 23, 42, 0.24);
        }

        #customer-distribution-map {
            width: 100%;
            height: 520px;
            border-radius: 1rem;
            overflow: hidden;
            background: linear-gradient(180deg, #93c5fd 0%, #bfdbfe 52%, #dcfce7 100%);
        }

        #customer-distribution-map .leaflet-control-zoom a {
            color: #0f172a;
        }

        .customer-map-tooltip {
            background: #ffffff;
            border: none;
            font-size: 12px;
            line-height: 1.35;
            color: #1f2937;
            border-radius: 0.75rem;
            padding: 8px 12px;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.1), 0 2px 4px -2px rgba(15, 23, 42, 0.1);
        }

        .customer-map-tooltip::before {
            border-top-color: #ffffff !important;
        }

        .customer-map-bullet {
            width: 10px;
            height: 10px;
            border-radius: 9999px;
            display: inline-block;
        }

        .logo-marquee:hover .logo-marquee-track {
            animation-play-state: paused;
        }

        @keyframes logo-marquee-scroll {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        @keyframes logo-marquee-scroll-reverse {
            from { transform: translateX(-50%); }
            to { transform: translateX(0); }
        }

        .marquee-reverse {
            animation: logo-marquee-scroll-reverse 28s linear infinite !important;
        }

        @media (max-width: 640px) {
            .logo-chip {
                width: 140px;
                height: 72px;
            }

            .logo-chip img {
                max-height: 48px;
            }

            .logo-marquee-track {
                animation-duration: 22s;
            }

            .numbers-chart {
                height: 290px;
            }

            #customer-distribution-map {
                height: 380px;
            }
        }
    </style>
</head>

<body class="overflow-x-hidden bg-white text-gray-900 antialiased">
    <x-layouts.partials.navbar />

    <main>
        <div class="relative flex h-screen w-full flex-col">
            <header class="relative h-full w-full grow overflow-hidden bg-black group">
                <video class="absolute inset-0 h-full w-full object-cover opacity-80" autoplay muted loop playsinline>
                    <source src="{{ asset('video/videocrop.webm') }}" type="video/webm">
                </video>
                <div class="absolute inset-0 bg-linear-to-t from-black via-black/20 to-black/10"></div>

                <div class="relative z-20 mx-auto flex h-full w-full max-w-[1430px] flex-col justify-end px-6 pb-24 lg:px-0">
                    <div class="max-w-3xl" data-aos="fade-up" data-aos-duration="1000">
                        <h1 class="mb-6 text-4xl leading-[1.1] tracking-tighter text-white md:text-[72px]">
                            Mendorong Inovasi,<br>Memperkuat Industri.
                        </h1>
                        <p class="mb-10 max-w-xl text-lg font-ultra-light leading-relaxed text-white/80 md:text-xl">
                            BSPJI Aceh hadir sebagai mitra strategis untuk meningkatkan daya saing industri melalui
                            standardisasi dan layanan jasa teknis yang terpercaya.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="#layanan"
                                class="rounded-full border border-white/20 bg-white/10 px-8 py-3 text-sm font-semibold text-white backdrop-blur-md transition-all hover:bg-white/20">
                                Jelajahi Layanan Kami
                            </a>
                            <a href="#app-showcase"
                                class="group flex items-center bg-transparent px-8 py-3 text-sm font-semibold text-white transition-all">
                                Daftar akun SIPINTU
                                <i data-lucide="arrow-right"
                                    class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <section id="profil" class="overflow-hidden bg-white py-24">
            <div class="mx-auto max-w-7xl px-6 lg:px-0">
                <div class="flex flex-col items-center gap-16 md:gap-28 lg:flex-row">
                    <div class="relative h-[500px] w-full md:h-[650px] lg:w-1/2">
                        <div class="absolute left-0 top-10 z-10 h-[350px] w-4/5 md:h-[450px]" data-aos="fade-right"
                            data-aos-duration="1000">
                            <img src="{{ $profileImages[0] }}" alt="Kegiatan 1"
                                class="h-full w-full rounded-2xl border-4 border-white object-cover shadow-xl">
                        </div>

                        <div class="absolute right-0 top-0 z-20 h-[200px] w-2/5" data-aos="fade-down" data-aos-delay="300"
                            data-aos-duration="1000">
                            <img src="{{ $profileImages[1] }}" alt="Kegiatan 2"
                                class="h-full w-full rounded-2xl border-4 border-white object-cover shadow-2xl">
                        </div>

                        <div class="absolute bottom-4 right-4 z-30 h-[250px] w-1/2 md:h-[300px]" data-aos="fade-up"
                            data-aos-delay="500" data-aos-duration="1000">
                            <img src="{{ $profileImages[2] }}" alt="Kegiatan 3"
                                class="h-full w-full rounded-2xl border-4 border-white object-cover shadow-2xl">
                        </div>

                        <div class="absolute -bottom-8 left-10 -z-10 h-24 w-24 rounded-full bg-gray-100" data-aos="zoom-in"
                            data-aos-delay="700"></div>
                    </div>

                    <div class="w-full md:w-1/2" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
                        <div class="mb-10 flex items-center gap-2">
                            <span class="text-[15px] text-gray-900">■</span>
                            <span class="text-sm font-bold uppercase tracking-[0.3em] text-gray-900">Profil</span>
                        </div>

                        <h2 class="mb-8 text-2xl font-ultra-light leading-[1.2] text-gray-900 md:text-[40px]">
                            BSPJI Banda Aceh adalah unit pelayanan teknis di bawah <span
                                class="font-semibold text-gray-800">Kementerian Perindustrian</span> yang berdedikasi
                            tinggi.
                        </h2>

                        <p class="mb-12 text-lg font-ultra-light leading-relaxed text-gray-600 md:text-xl">
                            Sebagai perpanjangan tangan negara, kami bertugas membangun kemandirian industri nasional
                            melalui standardisasi, pengujian laboratorium, dan optimalisasi teknologi industri guna
                            meningkatkan nilai tambah produk lokal Aceh maupun di luar Aceh.
                        </p>

                        <a href="{{ $routeOrHash('sejarah-singkat.index') }}"
                            class="inline-block rounded-full border border-gray-300 px-10 py-3 text-sm font-medium text-gray-800 transition-all duration-500 hover:border-gray-900 hover:bg-gray-900 hover:text-white">
                            Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </section>

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

            <div class="relative mx-auto h-full w-full max-w-7xl px-6 lg:px-0">
                <div class="relative flex h-full flex-col items-center lg:flex-row">
                    <div class="z-20 w-full py-12 lg:w-5/12 lg:py-0" data-aos="fade-right">
                        <h2 class="mb-4 text-3xl font-medium leading-tight tracking-tight text-white/95 sm:text-4xl lg:text-5xl">
                            <span class="text-white">SIPINTU</span>
                        </h2>

                        <p class="mb-8 max-w-md text-base font-light text-white/80 sm:text-lg">
                            Sistem Informasi Pelayanan Industri Terpadu (SIPINTU) BSPJI Banda Aceh ada untuk memudahkan
                            pelanggan mengakses semua layanan. Cukup satu akun untuk semua layanan.
                        </p>

                        <div class="flex flex-wrap gap-3">
                            <a href="#"
                                class="flex items-center gap-2 rounded-full bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/35 transition-all hover:bg-blue-700">
                                <i data-lucide="log-in" class="h-4 w-4"></i> Login
                            </a>
                            <a href="#"
                                class="flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-6 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition-all hover:bg-white/20">
                                <i data-lucide="user-plus" class="h-4 w-4"></i> Daftar
                            </a>
                        </div>

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
                    </div>
                </div>
            </div>
        </section>

        <section id="layanan" class="pb-12 pt-24 md:pb-20 md:pt-28">
            <div class="mx-auto max-w-7xl px-6 lg:px-0">
                <div class="mb-16 flex flex-col justify-between gap-8 md:mb-14 md:flex-row md:items-end">
                    <div class="max-w-2xl" data-aos="fade-up">
                        <div class="mb-6 flex items-center gap-2">
                            <span class="text-[10px] text-orange-600">■</span>
                            <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Solusi Industri</span>
                        </div>
                        <h2 class="section-title-identic text-gray-900">
                            Layanan Jasa Industri Kami
                        </h2>
                    </div>
                </div>

                @if ($sectionLayanans->isEmpty())
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-slate-600">
                        Data layanan belum tersedia.
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($sectionLayanans as $index => $layanan)
                            @php
                                $slug = Str::slug($layanan->nama_layanan);
                                $serviceUrl = $serviceRouteMap[$slug] ?? '#';
                                $serviceIcon = $serviceIconMap[$slug] ?? 'briefcase-business';
                                $serviceSummary = Str::of(strip_tags((string) $layanan->detail))->squish()->limit(160);
                            @endphp
                            <div class="group flex h-full flex-col" data-aos="fade-up" data-aos-delay="{{ 100 + ($index % 4) * 100 }}">
                                <div
                                    class="mb-6 h-60 overflow-hidden rounded-3xl border border-slate-200 shadow-[0_12px_45px_-12px_rgba(0,0,0,0.12)]">
                                    @if ($layanan->gambar)
                                        <img src="{{ Storage::url($layanan->gambar) }}" alt="{{ $layanan->nama_layanan }}"
                                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div
                                            class="flex h-full w-full items-center justify-center bg-linear-to-br from-slate-200 via-slate-100 to-slate-200 text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">
                                            {{ Str::limit($layanan->nama_layanan, 18, '') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex grow flex-col px-1">
                                    <div class="mb-3 flex items-center gap-3">
                                        <div class="text-orange-600">
                                            <i data-lucide="{{ $serviceIcon }}" class="h-6 w-6 text-orange-600"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 transition-colors group-hover:text-orange-600">
                                            {{ $layanan->nama_layanan }}
                                        </h3>
                                    </div>
                                    <p class="mb-6 ml-1 grow text-sm font-light leading-relaxed text-gray-500">
                                        {{ $serviceSummary ?: 'Detail layanan akan segera diperbarui.' }}
                                    </p>
                                    <div class="mt-auto">
                                        <a href="{{ $serviceUrl }}"
                                            class="inline-flex items-center gap-2 rounded-full border border-gray-900 px-5 py-2.5 text-sm font-bold text-gray-900 transition-all duration-300 hover:bg-gray-900 hover:text-white">
                                            Selengkapnya
                                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section id="logo-pelanggan" class="overflow-hidden rounded-bl-3xl rounded-br-3xl border-b border-gray-200 bg-white py-16 md:py-24">
            <div class="mx-auto max-w-7xl px-6 lg:px-0">
                <div class="grid grid-cols-1 items-start gap-12 lg:grid-cols-2 lg:gap-20">
                    <div class="order-2 lg:order-1" data-aos="fade-right">
                        <div class="mb-6 flex items-center gap-2">
                            <span class="text-[10px] text-orange-600">■</span>
                            <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Dipercaya Pelanggan</span>
                        </div>
                        <p class="mb-8 max-w-md text-2xl leading-relaxed text-gray-800">
                            Kami bangga telah menjadi mitra strategis bagi berbagai pelaku industri.
                        </p>

                        @if ($logosCollection->isEmpty())
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm text-slate-500">
                                Logo mitra belum tersedia.
                            </div>
                        @else
                            <div class="space-y-2">
                                <div class="logo-marquee">
                                    <div class="logo-marquee-track">
                                        <div class="logo-marquee-group">
                                            @foreach ($firstLogoGroup as $logo)
                                                <div class="logo-chip border border-slate-400/70">
                                                    <img src="{{ Storage::url($logo->gambar) }}" alt="Logo Mitra">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="logo-marquee-group" aria-hidden="true">
                                            @foreach ($firstLogoGroup as $logo)
                                                <div class="logo-chip border border-slate-400/70">
                                                    <img src="{{ Storage::url($logo->gambar) }}" alt="Logo Mitra">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="logo-marquee">
                                    <div class="logo-marquee-track marquee-reverse">
                                        <div class="logo-marquee-group">
                                            @foreach ($secondLogoGroup as $logo)
                                                <div class="logo-chip border border-slate-400/70">
                                                    <img src="{{ Storage::url($logo->gambar) }}" alt="Logo Mitra">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="logo-marquee-group" aria-hidden="true">
                                            @foreach ($secondLogoGroup as $logo)
                                                <div class="logo-chip border border-slate-400/70">
                                                    <img src="{{ Storage::url($logo->gambar) }}" alt="Logo Mitra">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="order-1 lg:order-2" data-aos="fade-left">
                        <div class="relative">
                            <div class="relative overflow-hidden rounded-[40px]">
                                <img src="{{ $showcaseImage }}" alt="Modern Industrial Facility Showcase"
                                    class="h-[400px] w-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="sertifikat" class="relative overflow-hidden bg-white py-16 md:pb-32 md:pt-24">
            <div class="relative mx-auto max-w-7xl px-6 lg:px-0">
                <div class="mb-12 max-w-4xl md:mb-16" data-aos="fade-up">
                    <div class="mb-6 flex items-center gap-2">
                        <span class="text-[10px] text-orange-600">■</span>
                        <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Sertifikat</span>
                    </div>
                    <h2 class="section-title-identic mb-6 text-gray-900">
                        Sertifikat Akreditasi Layanan Kami
                    </h2>
                </div>

                @if ($sertifikats->isEmpty())
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-slate-600">
                        Data sertifikat belum tersedia.
                    </div>
                @else
                    <div class="flex flex-wrap justify-center gap-x-4 gap-y-10 md:gap-x-5 md:gap-y-16">
                        @foreach ($sertifikats as $index => $sertifikat)
                            @php
                                $image = $sertifikat->gambar ? Storage::url($sertifikat->gambar) : null;
                                $title = $sertifikat->nama_sertifikat ?: 'Sertifikat';
                            @endphp
                            @if ($image)
                                <button type="button" data-certificate-trigger data-src="{{ $image }}"
                                    data-title="{{ $title }}"
                                    class="certificate-card group text-left transition-all duration-300 hover:-translate-y-1"
                                    data-aos="fade-up" data-aos-delay="{{ 50 + ($index % 8) * 50 }}">
                                    <div class="certificate-media relative aspect-4/3">
                                        <img src="{{ $image }}" alt="{{ $title }}"
                                            class="h-full w-full object-cover object-top transition-transform duration-700 group-hover:scale-105">
                                    </div>
                                    <div class="certificate-title-wrap">
                                        <h3 class="certificate-title text-base font-semibold text-slate-900">{{ $title }}</h3>
                                    </div>
                                </button>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <div id="certificateLightbox" class="fixed inset-0 z-120 hidden" aria-hidden="true">
                <div id="certificateLightboxBackdrop" class="absolute inset-0 bg-black/90"></div>
                <div class="relative z-10 flex min-h-full items-center justify-center p-2 md:p-6">
                    <p id="certificateLightboxTitle" class="sr-only">Sertifikat</p>
                    <button type="button" id="certificateLightboxClose"
                        class="absolute right-3 top-3 text-white/90 transition-colors hover:text-white md:right-6 md:top-6"
                        aria-label="Tutup lightbox">
                        <i data-lucide="x" class="h-7 w-7"></i>
                    </button>
                    <img id="certificateLightboxImage" src="" alt=""
                        class="h-auto max-h-[92vh] w-auto max-w-[96vw] object-contain">
                </div>
            </div>
        </section>

        <section id="perusahaan-dalam-angka" class="bg-white py-24 md:pb-16 md:pt-3">
            <div class="mx-auto max-w-7xl px-6 lg:px-0">
                <div class="mb-12 flex flex-col justify-between gap-8 lg:flex-row lg:items-end md:mb-16" data-aos="fade-up">
                    <div class="max-w-2xl">
                        <div class="mb-6 flex items-center gap-2">
                            <span class="text-[10px] text-orange-600">■</span>
                            <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Data Kinerja</span>
                        </div>
                        <h2 class="section-title-identic text-gray-900">
                            Perusahaan dalam Angka
                        </h2>
                    </div>
                    <div class="lg:max-w-sm lg:pb-2">
                        <p class="text-base font-light leading-relaxed text-gray-600 md:text-lg">
                            Visualisasi data kinerja utama menggunakan diagram batang ringan untuk memudahkan pembacaan tren.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:gap-6 lg:grid-cols-2">
                    <article class="numbers-card" data-aos="fade-up" data-aos-delay="50">
                        <div class="mb-2 flex items-start justify-between gap-3 px-2 pt-1">
                            <h3 class="text-base font-semibold text-gray-900 md:text-lg">Survey Persepsi Kualitas Pelayanan (SPKP)</h3>
                            <span class="rounded-full bg-orange-100 px-2.5 py-1 text-[11px] font-semibold text-orange-700">Skala 0-4</span>
                        </div>
                        <div id="chart-spkp" class="numbers-chart"></div>
                    </article>
                    <article class="numbers-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="mb-2 flex items-start justify-between gap-3 px-2 pt-1">
                            <h3 class="text-base font-semibold text-gray-900 md:text-lg">Survey Persepsi Anti Korupsi</h3>
                            <span class="rounded-full bg-orange-100 px-2.5 py-1 text-[11px] font-semibold text-orange-700">Skala 0-4</span>
                        </div>
                        <div id="chart-anti-korupsi" class="numbers-chart"></div>
                    </article>
                    <article class="numbers-card" data-aos="fade-up" data-aos-delay="150">
                        <div class="mb-2 flex items-start justify-between gap-3 px-2 pt-1">
                            <h3 class="text-base font-semibold text-gray-900 md:text-lg">Jumlah Pelanggan</h3>
                            <span class="rounded-full bg-orange-100 px-2.5 py-1 text-[11px] font-semibold text-orange-700">Skala 0-600</span>
                        </div>
                        <div id="chart-jumlah-pelanggan" class="numbers-chart"></div>
                    </article>
                    <article class="numbers-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="mb-2 flex items-start justify-between gap-3 px-2 pt-1">
                            <h3 class="text-base font-semibold text-gray-900 md:text-lg">Persentase Standar Pelayanan Minimum</h3>
                            <span class="rounded-full bg-orange-100 px-2.5 py-1 text-[11px] font-semibold text-orange-700">Skala 0-100</span>
                        </div>
                        <div id="chart-spm" class="numbers-chart"></div>
                    </article>
                </div>

                <div class="mt-12 md:mt-20" data-aos="fade-up" data-aos-delay="120">
                    <div class="mb-10 grid grid-cols-[1fr_auto_1fr] items-center gap-4 md:mb-12">
                        <div aria-hidden="true"></div>
                        <h3 class="text-center text-2xl font-ultra-light text-gray-900 md:text-3xl">Ringkasan Layanan</h3>
                        <span
                            class="justify-self-end inline-flex items-center rounded-full border border-slate-200 bg-orange-500 px-3 py-1.5 text-xs font-semibold tracking-[0.08em] text-white shadow-sm md:px-4 md:text-sm">
                            2020 - 2026
                        </span>
                    </div>

                    <div
                        class="grid grid-cols-1 gap-x-6 gap-y-8 rounded-[40px] border border-slate-300 bg-white px-8 py-16 shadow-[10px_10px_20px_-5px_rgba(0,0,0,0.17)] sm:grid-cols-2 lg:grid-cols-5 lg:gap-y-16 md:px-12">
                        <article class="text-center">
                            <p class="text-xl tracking-wide text-gray-700">Sertifikasi Produk</p>
                            <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">1.248</p>
                        </article>
                        <article class="text-center">
                            <p class="text-xl tracking-wide text-gray-700">Sertifikasi Halal</p>
                            <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">986</p>
                        </article>
                        <article class="text-center">
                            <p class="text-xl tracking-wide text-gray-700">Kalibrasi Alat</p>
                            <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">1.732</p>
                        </article>
                        <article class="text-center">
                            <p class="text-xl tracking-wide text-gray-700">Industri Hijau</p>
                            <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">642</p>
                        </article>
                        <article class="text-center">
                            <p class="text-xl tracking-wide text-gray-700">Pengujian</p>
                            <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">2.120</p>
                        </article>
                        <article class="text-center lg:col-start-2">
                            <p class="text-xl tracking-wide text-gray-700">Verifikasi TKDN</p>
                            <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">895</p>
                        </article>
                        <article class="text-center lg:col-start-3">
                            <p class="text-xl tracking-wide text-gray-700">Konsultasi Industri</p>
                            <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">734</p>
                        </article>
                        <article class="text-center lg:col-start-4">
                            <p class="text-xl tracking-wide text-gray-700">Pelatihan Teknis</p>
                            <p class="mt-2 text-[45px] font-semibold leading-none text-gray-900">1.184</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section id="peta-pelanggan" class="bg-white py-24 md:pb-28 md:pt-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-0">
                <div class="mb-10 md:mb-14" data-aos="fade-up">
                    <div class="grid grid-cols-1 items-start gap-6 md:gap-8 lg:grid-cols-12">
                        <div class="lg:col-span-7">
                            <div class="mb-6 flex items-center gap-2">
                                <span class="text-[10px] text-orange-600">■</span>
                                <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Customer Intelligence</span>
                            </div>
                            <h2 class="section-title-identic text-gray-900">Peta Penyebaran Pelanggan</h2>
                        </div>
                        <div class="lg:col-span-5">
                            <p class="text-base font-light leading-relaxed text-gray-800 md:text-lg lg:pt-2">
                                Visualisasi interaktif sebaran pelanggan pada wilayah Indonesia. Arahkan kursor ke titik kota/kabupaten untuk melihat jumlah pelanggan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:gap-6 xl:grid-cols-[minmax(0,1.7fr)_minmax(300px,1fr)]">
                    <article class="map-distribution-card self-start p-3 md:p-4" data-aos="fade-up" data-aos-delay="40">
                        <div id="customer-distribution-map" class="relative z-0"></div>
                    </article>

                    <aside class="map-distribution-card flex flex-col gap-6 p-5 md:p-6" data-aos="fade-up" data-aos-delay="90">
                        <div class="grid grid-cols-2 gap-3">
                            <article class="rounded-2xl border-none bg-linear-to-br from-orange-500 to-orange-600 p-5 shadow-lg shadow-orange-200/50">
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-white/80">Total</p>
                                <p id="map-total-customers" class="mt-1 text-4xl font-bold text-white">0</p>
                                <p class="mt-1 text-xs text-white/70">Pelanggan Terdaftar</p>
                            </article>
                            <article class="rounded-2xl border-none bg-linear-to-br from-blue-500 to-blue-600 p-5 shadow-lg shadow-blue-200/50">
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-white/80">Coverage</p>
                                <p id="map-total-coverage" class="mt-1 text-4xl font-bold text-white">0</p>
                                <p class="mt-1 text-xs text-white/70">Kota & Kabupaten</p>
                            </article>
                        </div>

                        <article class="rounded-2xl border-none bg-linear-to-br from-slate-600 to-slate-700 p-5 shadow-lg shadow-slate-200/60">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-white/80">Tanpa Lokasi</p>
                            <p id="map-total-no-location" class="mt-1 text-4xl font-bold text-white">{{ number_format((int) ($customerWithoutLocation ?? 0), 0, ',', '.') }}</p>
                            <p class="mt-1 text-xs text-white/70">Pelanggan Belum Terpetakan</p>
                        </article>

                        <div class="rounded-2xl border border-slate-200 p-4">
                            <h3 class="mb-3 text-sm font-semibold text-slate-900">Legend Jumlah Pelanggan</h3>
                            <ul class="space-y-2 text-sm text-slate-600">
                                <li class="flex items-center gap-2"><span class="customer-map-bullet bg-orange-700"></span>Tinggi (>= 90)</li>
                                <li class="flex items-center gap-2"><span class="customer-map-bullet bg-orange-500"></span>Menengah (45 - 89)</li>
                                <li class="flex items-center gap-2"><span class="customer-map-bullet bg-orange-300"></span>Dasar (&lt; 45)</li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <section class="relative overflow-hidden bg-slate-50 pb-14 text-slate-200/80 pattern-grid-lg lg:pb-16 align-left-container"
            x-data="{
                currentIndex: 0,
                totalCards: 0,
                maxIndex: 0,
                init() {
                    this.totalCards = this.$refs.track.children.length;
                    this.calculateMaxIndex();
                    window.addEventListener('resize', () => this.calculateMaxIndex());
                },
                calculateMaxIndex() {
                    const container = this.$refs.sliderViewport;
                    const track = this.$refs.track;
                    if (!container || !track || !track.children.length) return;
                    const card = track.children[0];
                    const gap = 24;
                    const cardWidth = card.offsetWidth + gap;
                    const visibleCards = Math.floor(container.offsetWidth / cardWidth);
                    this.maxIndex = Math.max(0, this.totalCards - visibleCards);
                    if (this.currentIndex > this.maxIndex) this.currentIndex = this.maxIndex;
                },
                getTranslateX() {
                    const track = this.$refs.track;
                    if (!track || !track.children.length) return '0px';
                    const card = track.children[0];
                    const gap = 24;
                    return '-' + (this.currentIndex * (card.offsetWidth + gap)) + 'px';
                },
                scrollNext() { if (this.currentIndex < this.maxIndex) this.currentIndex++; },
                scrollPrev() { if (this.currentIndex > 0) this.currentIndex--; }
            }">
            <div class="relative z-20 flex flex-col gap-10 lg:flex-row lg:gap-20">
                <div class="w-full shrink-0 pr-6 lg:w-[380px] lg:pr-0">
                    <div class="flex flex-col pt-12">
                        <div>
                            <h2 class="section-title-identic mb-6 text-[#1c1e21] lg:mb-8">
                                Testimoni Pelanggan
                            </h2>
                            <p class="max-w-sm text-[16px] leading-relaxed text-gray-600 md:text-[17px]">
                                Kepercayaan Anda adalah prioritas kami dalam mendukung kemajuan industri nasional.
                            </p>
                        </div>
                        <div class="mt-10 flex gap-4">
                            <button @click="scrollPrev"
                                :class="currentIndex === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100'"
                                class="flex h-11 w-11 items-center justify-center rounded-full border border-black/20 text-[#1c1e21] transition-all active:scale-90">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </button>
                            <button @click="scrollNext"
                                :class="currentIndex >= maxIndex ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100'"
                                class="flex h-11 w-11 items-center justify-center rounded-full border border-black/20 text-[#1c1e21] transition-all active:scale-90">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div x-ref="sliderViewport" class="grow overflow-hidden">
                    <div x-ref="track" :style="'transform: translateX(' + getTranslateX() + ')'"
                        class="flex gap-6 pb-12 pt-12 transition-transform duration-500 ease-[cubic-bezier(0.25,0.1,0.25,1)]">
                        @forelse ($testimonis as $testimoni)
                            <div class="relative h-[460px] min-w-[82%] snap-start overflow-hidden rounded-[40px] border border-gray-400 bg-white p-8 shadow-[10px_0_20px_-6px_rgba(0,0,0,0.12)] md:h-[500px] md:min-w-[440px] md:p-10">
                                <div class="relative z-10 flex h-full flex-col">
                                    <div class="mb-8 flex items-center gap-5">
                                        @if ($testimoni->gambar_pelanggan)
                                            <div class="h-16 w-16 overflow-hidden rounded-2xl shadow-md">
                                                <img src="{{ Storage::url($testimoni->gambar_pelanggan) }}" alt="{{ $testimoni->nama }}"
                                                    class="h-full w-full object-cover">
                                            </div>
                                        @else
                                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-xl font-bold text-blue-700 shadow-md">
                                                {{ Str::substr($testimoni->nama, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-900">{{ $testimoni->nama }}</h4>
                                            <p class="text-sm font-medium text-blue-600">{{ $testimoni->jabatan }}</p>
                                            <p class="text-xs font-medium text-gray-400">{{ $testimoni->nama_perusahaan }}</p>
                                        </div>
                                    </div>

                                    <p class="text-[16px] italic leading-relaxed text-gray-600 md:text-[18px]">
                                        "{{ $testimoni->pesan }}"
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="relative h-[460px] min-w-[82%] snap-start overflow-hidden rounded-[40px] border border-gray-400 bg-white p-8 shadow-[10px_0_20px_-6px_rgba(0,0,0,0.12)] md:h-[500px] md:min-w-[440px] md:p-10">
                                <p class="text-[16px] italic leading-relaxed text-gray-600 md:text-[18px]">
                                    "Testimoni akan muncul setelah data ditambahkan pada admin panel."
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <x-zona-integritas.section
            :dokumens-by-kode="$zonaIntegritasDokumens"
            :grafik-ikms="$zonaIntegritasGrafikIkms" />

        <section id="faq" class="border-t border-gray-50 bg-white py-24">
            <div class="mx-auto max-w-7xl px-6" x-data="{ activeItems: [1], currentImage: 1, toggle(id) { if (this.activeItems.includes(id)) { this.activeItems = this.activeItems.filter(i => i !== id); } else { this.activeItems.push(id); this.currentImage = id; }}}">
                <div class="mb-16" data-aos="fade-up">
                    <div class="mb-4 flex items-center gap-2">
                        <span class="text-[10px] text-orange-600">■</span>
                        <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">FAQ</span>
                    </div>
                    <h2 class="section-title-identic mb-6 text-gray-900">Pertanyaan yang Sering Diajukan</h2>
                </div>
                <div class="grid grid-cols-1 items-start gap-16 lg:grid-cols-2">
                    <div class="space-y-0">
                        @foreach ([
                            ['id' => 1, 'q' => 'Apa itu SIPINTU dan bagaimana cara mendaftarnya?', 'a' => 'SIPINTU (Sistem Informasi Pelayanan Industri Terpadu) adalah platform digital terintegrasi BSPJI Banda Aceh untuk memudahkan pelanggan mengakses seluruh layanan jasa teknis. Cara mendaftarnya sangat mudah: klik tombol Daftar, isi biodata perusahaan, dan verifikasi email.'],
                            ['id' => 2, 'q' => 'Berapa lama waktu yang dibutuhkan untuk kalibrasi alat?', 'a' => 'Waktu pengerjaan kalibrasi standar adalah 3 hingga 5 hari kerja setelah alat diterima dan administrasi diselesaikan. Durasi dapat bervariasi tergantung jenis alat dan kompleksitas kalibrasi.'],
                            ['id' => 3, 'q' => 'Apakah BSPJI melayani sertifikasi produk SNI?', 'a' => 'Ya, BSPJI Banda Aceh melalui Lembaga Sertifikasi Produk melayani sertifikasi produk untuk penggunaan tanda SNI dan terus memperluas ruang lingkup akreditasi.'],
                            ['id' => 4, 'q' => 'Bagaimana cara melacak status pengujian saya?', 'a' => 'Anda dapat melacak status pengujian melalui fitur Cek Order di halaman beranda dengan nomor berita acara, atau login ke akun SIPINTU untuk melihat detail progress.'],
                        ] as $faq)
                            <div class="border-b border-gray-300 py-6">
                                <button @click="toggle({{ $faq['id'] }})" class="group flex w-full items-center justify-between text-left">
                                    <h3 :class="activeItems.includes({{ $faq['id'] }}) ? 'text-[#00a19c]' : 'text-[#333333]'" class="pr-8 text-xl font-semibold transition-colors duration-300">
                                        {{ $faq['q'] }}
                                    </h3>
                                    <div :class="activeItems.includes({{ $faq['id'] }}) ? 'bg-[#1a3a8a] rotate-180' : 'bg-[#00a19c]'" class="grid h-8 w-8 shrink-0 place-items-center rounded-full text-white transition-all duration-500">
                                        <i x-show="!activeItems.includes({{ $faq['id'] }})" data-lucide="plus" class="h-4 w-4" stroke-width="3"></i>
                                        <i x-show="activeItems.includes({{ $faq['id'] }})" data-lucide="minus" class="h-4 w-4" stroke-width="3"></i>
                                    </div>
                                </button>
                                <div x-show="activeItems.includes({{ $faq['id'] }})" class="mt-4 pr-12 text-gray-600">
                                    <p class="leading-relaxed">{{ $faq['a'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="sticky top-32 hidden lg:block">
                        <div class="relative aspect-square overflow-hidden rounded-[3rem] border-8 border-gray-50 shadow-2xl">
                            <img src="{{ $faqDisplayImages[0] }}" x-show="currentImage === 1" class="absolute inset-0 h-full w-full object-cover" alt="FAQ 1">
                            <img src="{{ $faqDisplayImages[1] }}" x-show="currentImage === 2" class="absolute inset-0 h-full w-full object-cover" alt="FAQ 2">
                            <img src="{{ $faqDisplayImages[2] }}" x-show="currentImage === 3" class="absolute inset-0 h-full w-full object-cover" alt="FAQ 3">
                            <img src="{{ $faqDisplayImages[3] }}" x-show="currentImage === 4" class="absolute inset-0 h-full w-full object-cover" alt="FAQ 4">
                            <div class="absolute inset-0 bg-linear-to-t from-black/20 to-transparent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-layouts.partials.footer />
    </main>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
            if (window.AOS) {
                window.AOS.init({ once: true, offset: 200 });
            }

            const certificateLightbox = document.getElementById('certificateLightbox');
            const certificateLightboxImage = document.getElementById('certificateLightboxImage');
            const certificateLightboxTitle = document.getElementById('certificateLightboxTitle');
            const certificateLightboxClose = document.getElementById('certificateLightboxClose');
            const certificateLightboxBackdrop = document.getElementById('certificateLightboxBackdrop');
            const certificateTriggers = document.querySelectorAll('[data-certificate-trigger]');

            if (certificateLightbox && certificateLightboxImage && certificateLightboxTitle) {
                const openCertificateLightbox = (imageSrc, imageTitle, imageAlt) => {
                    certificateLightboxImage.src = imageSrc;
                    certificateLightboxImage.alt = imageAlt || imageTitle || 'Sertifikat';
                    certificateLightboxTitle.textContent = imageTitle || 'Sertifikat';
                    certificateLightbox.classList.remove('hidden');
                    certificateLightbox.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('overflow-hidden');
                };
                const closeCertificateLightbox = () => {
                    certificateLightbox.classList.add('hidden');
                    certificateLightbox.setAttribute('aria-hidden', 'true');
                    certificateLightboxImage.src = '';
                    certificateLightboxImage.alt = '';
                    document.body.classList.remove('overflow-hidden');
                };
                certificateTriggers.forEach((trigger) => {
                    trigger.addEventListener('click', () => {
                        openCertificateLightbox(trigger.dataset.src, trigger.dataset.title, trigger.querySelector('img')?.alt);
                    });
                });
                certificateLightboxClose?.addEventListener('click', closeCertificateLightbox);
                certificateLightboxBackdrop?.addEventListener('click', closeCertificateLightbox);
            }

            const customerDistributionData = @json($customerDistribution ?? []);
            const customerWithoutLocation = Number(@json($customerWithoutLocation ?? 0));

            const formatIndonesiaNumber = (value) => new Intl.NumberFormat('id-ID').format(value);
            const markerColorByCustomerCount = (count) => {
                if (count >= 90) return '#c2410c';
                if (count >= 45) return '#ea580c';
                return '#fdba74';
            };

            const mapContainer = document.getElementById('customer-distribution-map');
            if (mapContainer && typeof L !== 'undefined') {
                const map = L.map(mapContainer, {
                    scrollWheelZoom: false,
                    zoomControl: true,
                    minZoom: 4,
                    maxZoom: 9
                });

                const preferredBasemap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Tiles &copy; Esri',
                    maxZoom: 19
                });
                const fallbackBasemap = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 19
                });

                let hasSwitchedToFallback = false;
                preferredBasemap.on('tileerror', () => {
                    if (hasSwitchedToFallback) return;
                    hasSwitchedToFallback = true;
                    if (map.hasLayer(preferredBasemap)) {
                        map.removeLayer(preferredBasemap);
                    }
                    fallbackBasemap.addTo(map);
                });
                preferredBasemap.addTo(map);

                customerDistributionData.forEach((point) => {
                    L.circleMarker([point.lat, point.lng], {
                        radius: Math.max(7, Math.min(18, 7 + (point.customers / 18))),
                        weight: 1.4,
                        color: '#ffffff',
                        fillColor: markerColorByCustomerCount(point.customers),
                        fillOpacity: 0.9
                    }).bindTooltip(
                        `<strong>${point.region}</strong><br>${formatIndonesiaNumber(point.customers)} pelanggan`,
                        {
                            className: 'customer-map-tooltip',
                            direction: 'top',
                            sticky: true,
                            offset: [0, -9],
                            opacity: 1
                        }
                    ).addTo(map);
                });

                if (customerDistributionData.length > 0) {
                    const mapBounds = L.latLngBounds(customerDistributionData.map((point) => [point.lat, point.lng]));
                    map.fitBounds(mapBounds, { padding: [30, 30], maxZoom: 7 });
                } else {
                    map.setView([4.6951, 96.8205], 8);
                }

                const totalCustomers = customerDistributionData.reduce((total, point) => total + point.customers, 0);
                const totalCoverage = customerDistributionData.length;
                const totalCustomersElement = document.getElementById('map-total-customers');
                const totalCoverageElement = document.getElementById('map-total-coverage');
                const totalNoLocationElement = document.getElementById('map-total-no-location');
                if (totalCustomersElement) totalCustomersElement.textContent = formatIndonesiaNumber(totalCustomers);
                if (totalCoverageElement) totalCoverageElement.textContent = formatIndonesiaNumber(totalCoverage);
                if (totalNoLocationElement) totalNoLocationElement.textContent = formatIndonesiaNumber(customerWithoutLocation);
            }

            const formatChartTick = (value, maxValue) => {
                if (maxValue <= 4) {
                    return Number.isInteger(value) ? String(value) : value.toFixed(1).replace('.', ',');
                }
                return new Intl.NumberFormat('id-ID').format(Math.round(value));
            };

            const renderBarChart = (config) => {
                const container = document.getElementById(config.targetId);
                if (!container) return;

                const svgWidth = 760;
                const svgHeight = 340;
                const margin = {
                    top: 18,
                    right: 16,
                    bottom: config.labels.length > 10 ? 78 : 54,
                    left: 54
                };
                const plotWidth = svgWidth - margin.left - margin.right;
                const plotHeight = svgHeight - margin.top - margin.bottom;
                const plotBottom = margin.top + plotHeight;
                const slotWidth = plotWidth / config.labels.length;
                const barWidth = Math.max(10, Math.min(34, slotWidth * 0.58));
                const gradientId = `bar-gradient-${config.targetId}`;
                const denseLabels = config.labels.length > 10;

                const ticks = [];
                for (let tick = config.min; tick <= config.max + config.step / 2; tick += config.step) {
                    ticks.push(Number(tick.toFixed(4)));
                }

                const tickMarkup = ticks.map((tickValue) => {
                    const ratio = (tickValue - config.min) / (config.max - config.min || 1);
                    const y = plotBottom - ratio * plotHeight;
                    return `
                        <line x1="${margin.left}" y1="${y}" x2="${margin.left + plotWidth}" y2="${y}" stroke="#e2e8f0" stroke-width="1" />
                        <text x="${margin.left - 10}" y="${y + 4}" text-anchor="end" fill="#64748b" font-size="11">${formatChartTick(tickValue, config.max)}</text>
                    `;
                }).join('');

                const barMarkup = config.values.map((rawValue, index) => {
                    const value = Math.max(config.min, Math.min(config.max, rawValue));
                    const ratio = (value - config.min) / (config.max - config.min || 1);
                    const barHeight = ratio * plotHeight;
                    const xCenter = margin.left + slotWidth * index + slotWidth / 2;
                    const x = xCenter - barWidth / 2;
                    const y = plotBottom - barHeight;
                    const xLabel = denseLabels
                        ? `<text x="${xCenter}" y="${plotBottom + 22}" transform="rotate(-34 ${xCenter} ${plotBottom + 22})" text-anchor="end" fill="#475569" font-size="10">${config.labels[index]}</text>`
                        : `<text x="${xCenter}" y="${plotBottom + 20}" text-anchor="middle" fill="#475569" font-size="10">${config.labels[index]}</text>`;
                    return `
                        <rect x="${x}" y="${y}" width="${barWidth}" height="${barHeight}" rx="5" fill="url(#${gradientId})" stroke="${config.stroke}" stroke-width="1.2" />
                        ${xLabel}
                    `;
                }).join('');

                container.innerHTML = `
                    <svg viewBox="0 0 ${svgWidth} ${svgHeight}" aria-hidden="true" focusable="false">
                        <defs>
                            <linearGradient id="${gradientId}" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="${config.color}" />
                                <stop offset="100%" stop-color="${config.stroke}" />
                            </linearGradient>
                        </defs>
                        <line x1="${margin.left}" y1="${margin.top}" x2="${margin.left}" y2="${plotBottom}" stroke="#cbd5e1" stroke-width="1.2" />
                        <line x1="${margin.left}" y1="${plotBottom}" x2="${margin.left + plotWidth}" y2="${plotBottom}" stroke="#cbd5e1" stroke-width="1.2" />
                        ${tickMarkup}
                        ${barMarkup}
                    </svg>
                `;
            };

            [
                { targetId: 'chart-spkp', labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'], values: [3.1, 3.2, 3.3, 3.4, 3.5, 3.6, 3.7], min: 0, max: 4, step: 0.5, color: '#3b82f6', stroke: '#2563eb' },
                { targetId: 'chart-anti-korupsi', labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'], values: [3.0, 3.2, 3.3, 3.4, 3.6, 3.7, 3.8], min: 0, max: 4, step: 0.5, color: '#10b981', stroke: '#059669' },
                { targetId: 'chart-jumlah-pelanggan', labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'], values: [210, 255, 300, 360, 420, 490, 560], min: 0, max: 600, step: 50, color: '#f59e0b', stroke: '#d97706' },
                { targetId: 'chart-spm', labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'], values: [78, 80, 81, 83, 85, 87, 89, 90, 92, 93, 94, 95], min: 0, max: 100, step: 20, color: '#ef4444', stroke: '#dc2626' }
            ].forEach(renderBarChart);
        });
    </script>
</body>

</html>
