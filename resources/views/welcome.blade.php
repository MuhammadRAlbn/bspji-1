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

    $certificateBgImage = $profileImages->first() ?? $profileFallbacks[0];

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

        .testimonials-carousel {
            --testimonial-card-width: min(82vw, 336px);
            --testimonial-card-gap: 20px;
            clip-path: inset(-32px -120vw -32px 0);
        }

        @media (min-width: 640px) {
            .testimonials-carousel {
                --testimonial-card-width: 340px;
                --testimonial-card-gap: 28px;
            }
        }

        @media (min-width: 1024px) {
            .testimonials-carousel {
                --testimonial-card-width: 330px;
                --testimonial-card-gap: 44px;
            }
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
            justify-content: center;
        }

        .certificate-title {
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-align: center;
        }

        .numbers-card {
            background: #ffffff;
            border: 1px solid #cbd5e1cc;
            border-radius: 1.5rem;
            padding: 1.25rem 1.25rem 1rem;
            box-shadow: 0 2px 10px -4px rgba(0, 0, 0, 0.4);
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
            border: 1px solid #cbd5e1cc;
            border-radius: 1.5rem;
            box-shadow: 0 2px 10px -4px rgba(0, 0, 0, 0.4);
        }

        #customer-distribution-map {
            width: 100%;
            height: 450px;
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
    <x-layouts.partials.navbar variant="transparent" />

    <main>
        <div class="relative flex h-screen w-full flex-col">
            <header class="relative h-full w-full grow overflow-hidden bg-black group">
                <video class="absolute inset-0 h-full w-full object-cover opacity-80" autoplay muted loop playsinline>
                    <source src="{{ asset('video/videocrop.webm') }}" type="video/webm">
                </video>
                <div class="absolute inset-0 bg-linear-to-t from-black via-black/20 to-black/10"></div>

                <div class="relative z-20 mx-auto flex h-full w-full max-w-[1430px] flex-col justify-end px-6 pb-28 lg:px-0">
                    <div class="max-w-3xl" data-aos="fade-up" data-aos-duration="1000">
                        <h1 class="mb-6 text-3xl leading-[1.1] tracking-tight text-white md:text-5xl">
                            Mewujudkan Industri Nasional yang Mandiri dan Berdaya Saing
                        </h1>
                        <!-- <p class="mb-10 max-w-xl text-lg font-ultra-light leading-relaxed text-white/80 md:text-xl">
                            BSPJI Aceh hadir sebagai mitra strategis untuk meningkatkan daya saing industri melalui
                            standardisasi dan layanan jasa teknis yang terpercaya.
                        </p> -->
                        <div class="flex flex-wrap gap-4">
                            <a href="#layanan"
                                class="rounded-full border border-white/20 bg-white/10 px-8 py-3 text-md font-semibold text-white backdrop-blur-md transition-all hover:bg-white/20">
                                Jelajahi Layanan Kami
                            </a>
                            <!-- <a href="#app-showcase"
                                class="group flex items-center bg-transparent px-8 py-3 text-sm font-semibold text-white transition-all">
                                Daftar akun SIPINTU
                                <i data-lucide="arrow-right"
                                    class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                            </a> -->
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <section id="profil" class="overflow-hidden bg-white py-24">
            <div class="mx-auto max-w-6xl px-6 lg:px-0">
                <div class="flex flex-col items-center gap-16 md:gap-28 lg:flex-row">
                    <div class="relative h-[450px] w-full md:h-[550px] lg:w-1/2">
                        <div class="absolute left-0 top-10 z-10 h-[300px] w-[70%] md:h-[380px]" data-aos="fade-right"
                            data-aos-duration="1000">
                            <img src="{{ $profileImages[0] }}" alt="Kegiatan 1"
                                class="h-full w-full rounded-2xl border-4 border-white object-cover shadow-xl">
                        </div>

                        <div class="absolute right-4 top-0 z-20 h-[170px] w-[35%]" data-aos="fade-down" data-aos-delay="300"
                            data-aos-duration="1000">
                            <img src="{{ $profileImages[1] }}" alt="Kegiatan 2"
                                class="h-full w-full rounded-2xl border-4 border-white object-cover shadow-2xl">
                        </div>

                        <div class="absolute bottom-4 right-10 z-30 h-[220px] w-[45%] md:h-[260px]" data-aos="fade-up"
                            data-aos-delay="500" data-aos-duration="1000">
                            <img src="{{ $profileImages[2] }}" alt="Kegiatan 3"
                                class="h-full w-full rounded-2xl border-4 border-white object-cover shadow-2xl">
                        </div>

                        <div class="absolute -bottom-8 left-10 -z-10 h-24 w-24 rounded-full bg-gray-100" data-aos="zoom-in"
                            data-aos-delay="700"></div>
                    </div>

                    <div class="w-full md:w-1/2" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-[15px] text-gray-900">■</span>
                            <span class="text-sm font-bold uppercase tracking-[0.3em] text-gray-900">Profil</span>
                        </div>

                        <h2 class="mb-8 text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">
                            Unit pelayanan teknis di bawah <span
                                class="font-semibold text-gray-800">Kementerian Perindustrian</span>
                        </h2>

                        <p class="mb-12 text-justify text-lg leading-relaxed text-gray-700/95 md:text-lg">
                            Sebagai perpanjangan tangan dari kementerian perindustrian, Kami mempunyai tugas untuk melaksanakan standardisasi industri, optimalisasi pemanfaatan teknologi industri, industri hijau, dan pelayanan jasa industri berlandaskan potensi sumber daya daerah.
                        </p>

                        <a href="{{ $routeOrHash('sejarah-singkat.index') }}"
                            class="group inline-flex items-center gap-2 rounded-full border border-gray-500 px-10 py-3 text-sm font-medium text-gray-800 transition-all duration-500 hover:border-gray-900 hover:bg-gray-900 hover:text-white">
                            Selengkapnya
                            <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
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

        <section id="layanan" class="bg-white pb-16 pt-24 md:pb-24 md:pt-28">
            <div class="mx-auto max-w-6xl px-6 lg:px-0">
                <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.12fr)] lg:items-start lg:gap-14" data-aos="fade-up">
                    <div>
                        <p class="mb-3 text-sm font-bold uppercase tracking-normal text-[#0038b8]">
                            STANDARDISASI & PELAYANAN INDUSTRI
                        </p>
                        <h2 class="text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">
                            Layanan Jasa Kami
                        </h2>
                    </div>

                    <p class="max-w-xl text-lg font-normal leading-relaxed text-slate-700 md:text-lg lg:pt-3">
                        BSPJI Banda Aceh berkomitmen meningkatkan daya saing industri melalui layanan sertifikasi, kalibrasi, pengujian, serta konsultansi yang profesional dan terpercaya.
                    </p>
                </div>

                @if ($sectionLayanans->isEmpty())
                    <div class="mt-8 rounded-lg border border-dashed border-slate-300 bg-[#f2f5f9] p-8 text-slate-600">
                        Data layanan belum tersedia.
                    </div>
                @else
                    <div class="mt-20 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 lg:gap-5">
                        @foreach ($sectionLayanans as $index => $layanan)
                            @php
                                $slug = Str::slug($layanan->nama_layanan);
                                $serviceUrl = $serviceRouteMap[$slug] ?? '#';
                            @endphp
                            <a href="{{ $serviceUrl }}"
                                class="group relative flex h-[170px] flex-col justify-end overflow-hidden rounded-lg border border-[#dde4ee] bg-[#f1f4f9] p-5 text-left transition duration-300 hover:-translate-y-1 hover:border-[#cfd8e6] focus:outline-none focus:ring-2 focus:ring-[#123cad]/25 md:h-[190px]"
                                data-aos="fade-up" data-aos-delay="{{ 100 + ($index % 4) * 75 }}">
                                @if ($layanan->gambar)
                                    <img src="{{ Storage::url($layanan->gambar) }}" alt="{{ $layanan->nama_layanan }}"
                                        class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-linear-to-t from-slate-950/90 via-slate-950/20 to-transparent transition duration-300 group-hover:from-slate-950 group-hover:via-slate-950/30"></div>
                                @endif
                                <h3 class="relative z-10 text-sm font-bold uppercase leading-snug tracking-normal {{ $layanan->gambar ? 'text-white drop-shadow-md' : 'text-slate-950' }}">
                                    {{ $layanan->nama_layanan }}
                                </h3>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        {{--
        <section id="layanan" class="pb-12 pt-24 md:pb-20 md:pt-28">
            <div class="mx-auto max-w-6xl px-6 lg:px-0">
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
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-slate-600">
                        Data layanan belum tersedia.
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                        @foreach ($sectionLayanans as $index => $layanan)
                            @php
                                $slug = Str::slug($layanan->nama_layanan);
                                $serviceUrl = $serviceRouteMap[$slug] ?? '#';
                            @endphp
                            <a href="{{ $serviceUrl }}"
                                class="flex min-h-[180px] items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-6 py-8 text-center shadow-[0_2px_10px_-6px_rgba(15,23,42,0.45)] transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:bg-white hover:shadow-[0_18px_35px_-28px_rgba(15,23,42,0.75)] focus:outline-none focus:ring-2 focus:ring-slate-900/20"
                                data-aos="fade-up" data-aos-delay="{{ 100 + ($index % 4) * 75 }}">
                                <h3 class="text-lg font-semibold leading-snug tracking-tight text-slate-900">
                                    {{ $layanan->nama_layanan }}
                                </h3>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        --}}

        <section id="logo-pelanggan" class="overflow-hidden rounded-bl-3xl rounded-br-3xl bg-white py-16 md:py-24">
            <div class="mx-auto max-w-6xl px-6 lg:px-0">
                <div class="grid grid-cols-1 items-start gap-12 lg:grid-cols-2 lg:gap-20">
                    <div class="order-2 lg:order-1" data-aos="fade-right">
                        <div class="mb-2 flex items-center gap-2">
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
                            <div class="relative overflow-hidden rounded-2xl">
                                <img src="{{ $showcaseImage }}" alt="Modern Industrial Facility Showcase"
                                    class="h-[400px] w-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="whatsapp-cta" class="relative bg-white pt-12 md:pt-16 pb-16 md:pb-24">
            <div class="mx-auto max-w-6xl px-6 lg:px-0">
                <div class="relative overflow-hidden rounded-3xl bg-[#0f172a] px-8 py-12 md:px-16 md:py-16" data-aos="fade-up">
                    
                    <div class="relative flex flex-col items-center justify-between gap-10 md:flex-row">
                        <div class="max-w-2xl text-center md:text-left">
                        <div class="mb-4 flex items-center justify-center gap-2 md:justify-start">
                                <span class="text-[10px] text-[#25D366]">■</span>
                                <span class="text-xs font-bold uppercase tracking-[0.3em] text-[#25D366]">Layanan Pelanggan</span>
                            </div>
                            <h2 class="text-2xl font-bold tracking-tight text-white md:text-3xl lg:text-4xl lg:leading-[1.2]">
                                Punya pertanyaan tentang layanan kami?
                            </h2>
                            <p class="mt-4 text-base text-slate-300 md:text-lg">
                                Tim Customer Service kami siap memberikan informasi mendetail mengenai pengujian, kalibrasi, maupun sertifikasi yang Anda butuhkan.
                            </p>
                        </div>
                        <div class="shrink-0">
                            <a href="#"
                               class="group inline-flex items-center gap-3 rounded-full bg-[#25D366] px-8 py-4 text-base font-bold text-white transition-all duration-300 hover:-translate-y-1 hover:bg-[#20bd5a] focus:outline-none">
                                <svg class="h-6 w-6 fill-current transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                                </svg>
                                Hubungi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="sertifikat" class="relative overflow-hidden border-y border-slate-300 bg-slate-50 py-12 md:pb-16 md:pt-16">

            <div class="relative mx-auto max-w-6xl px-6 lg:px-0">
                <div class="mb-12 max-w-4xl md:mb-16" data-aos="fade-up">
                    <div class="mb-2 flex items-center gap-2">
                        <span class="text-[10px] text-orange-600">■</span>
                        <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Sertifikat</span>
                    </div>
                    <h2 class="mb-6 text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">
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

        <section id="perusahaan-dalam-angka" class="bg-white py-12 md:pb-16 md:pt-16">
            <div class="mx-auto max-w-6xl px-6 lg:px-0">
                <div class="mb-12 flex flex-col justify-between gap-8 lg:flex-row lg:items-end md:mb-16" data-aos="fade-up">
                    <div class="max-w-2xl">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-[10px] text-orange-600">■</span>
                            <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Data Kinerja</span>
                        </div>
                        <h2 class="text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">
                            Perusahaan dalam Angka
                        </h2>
                    </div>
                    <div class="lg:max-w-sm lg:pb-2">
                        <p class="text-justify text-lg leading-relaxed text-gray-700/95 md:text-lg">
                            Visualisasi data kinerja utama menggunakan diagram batang ringan untuk memudahkan pembacaan tren.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:gap-6 lg:grid-cols-2">
                    {{-- 
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
                    --}}
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

                {{--
                <div class="mt-24 md:mt-40" data-aos="fade-up" data-aos-delay="120">
                    <div class="relative mb-14" data-aos="fade-up">
                        <div class="text-center">
                            <div class="mb-6 flex items-center justify-center gap-2">
                                <span class="text-[10px] text-orange-600">■</span>
                                <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Statistik Layanan</span>
                            </div>
                            <h2 class="section-title-identic text-gray-900">
                                Ringkasan Layanan
                            </h2>
                            <div class="mt-6 md:hidden">
                                <span
                                    class="inline-flex items-center rounded-full border border-slate-200 bg-orange-500 px-3 py-1.5 text-xs font-semibold tracking-[0.08em] text-white shadow-sm">
                                    2020 - 2026
                                </span>
                            </div>
                        </div>
                        <div class="absolute bottom-1 right-0 hidden md:block">
                            <span
                                class="inline-flex items-center rounded-full border border-slate-200 bg-orange-500 px-4 py-1.5 text-sm font-semibold tracking-[0.08em] text-white shadow-sm">
                                2020 - 2026
                            </span>
                        </div>
                    </div>

                    <div
                        class="grid grid-cols-1 gap-x-6 gap-y-8 rounded-3xl border border-slate-300/80 bg-white px-8 py-16 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.4)] sm:grid-cols-2 lg:grid-cols-5 lg:gap-y-16 md:px-12">
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
                --}}
            </div>
        </section>

        <section x-data="{
                activeIndex: 0,
                cardStep: 0,
                transitionEnabled: true,
                get totalCards() {
                    return this.$refs.track ? this.$refs.track.children.length : 0;
                },
                init() {
                    this.measure();
                    window.addEventListener('resize', () => this.measure());
                },
                measure() {
                    this.$nextTick(() => {
                        const card = this.$root.querySelector('[data-testimonial-card]');
                        const track = this.$root.querySelector('[data-testimonial-track]');

                        if (!card || !track) {
                            this.cardStep = 0;
                            return;
                        }

                        const trackStyle = window.getComputedStyle(track);
                        const gap = parseFloat(trackStyle.columnGap || trackStyle.gap || 0);
                        this.cardStep = card.getBoundingClientRect().width + gap;

                        if (this.activeIndex > this.maxIndex()) {
                            this.activeIndex = this.maxIndex();
                        }
                    });
                },
                maxIndex() {
                    return Math.max(0, this.totalCards - 1);
                },
                cardPosition(index) {
                    return index - this.activeIndex;
                },
                cardTone(index) {
                    const position = this.cardPosition(index);

                    if (position === 0) {
                        return 'bg-[#1839a8] text-white opacity-100 border-transparent';
                    }

                    if (position === 1) {
                        return 'bg-white text-black opacity-100 border-transparent';
                    }

                    if (position === 2) {
                        return 'bg-white/65 text-[#939393] opacity-80 border-slate-200 shadow-[0_8px_18px_rgba(15,23,42,0.12)]';
                    }

                    return 'bg-white/0 text-[#939393] opacity-0 shadow-none pointer-events-none border-transparent';
                },
                next() {
                    if (this.activeIndex >= this.maxIndex()) return;

                    this.transitionEnabled = true;
                    this.activeIndex += 1;
                },
                previous() {
                    if (this.activeIndex <= 0) return;

                    this.transitionEnabled = true;
                    this.activeIndex -= 1;
                }
            }"
            x-cloak
            @resize.window.debounce.150ms="measure()"
            class="relative isolate mb-8 mt-12 overflow-hidden bg-[#f5f8fc] py-10 sm:py-12 md:mb-10 md:mt-16 lg:mt-28 lg:min-h-[560px] lg:py-0"
            aria-labelledby="testimonials-slider-title">
            <div class="mx-auto grid w-full max-w-[1920px] grid-cols-1 lg:min-h-[560px] lg:grid-cols-[49%_51%]">
                <div class="relative h-[300px] overflow-hidden sm:h-[380px] lg:h-auto">
                    <img src="{{ asset('images/udara1.jpeg') }}"
                        alt="Petugas BSPJI Banda Aceh melakukan pemantauan alat pengujian udara"
                        class="h-full w-full object-cover object-center">
                    <div class="absolute inset-0 bg-linear-to-br from-slate-950/70 via-slate-950/25 to-white/5"></div>
                    <div class="absolute left-5 right-5 top-6 z-10 flex items-start justify-between gap-4 text-white sm:left-8 sm:right-8 sm:top-8 lg:left-10 lg:right-auto lg:top-10 lg:flex-col lg:justify-start lg:gap-5">
                        <h2 id="testimonials-slider-title" class="shrink-0 text-2xl font-semibold leading-[1.05] tracking-normal md:text-[30px] lg:whitespace-nowrap lg:text-[44px]">
                            <span class="block lg:inline">Testimoni</span>
                            <span class="block lg:inline">Pelanggan</span>
                        </h2>
                        <div class="flex items-center gap-2 sm:gap-3">
                            <button type="button"
                                @click="previous()"
                                :disabled="activeIndex === 0"
                                class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-[#9ba9bf] bg-white/95 text-[#7b8798] shadow-[0_8px_18px_rgba(15,23,42,0.18)] transition enabled:hover:border-[#1839a8] enabled:hover:text-[#1839a8] focus:outline-none disabled:opacity-60 sm:h-14 sm:w-14 lg:h-12 lg:w-12"
                                aria-label="Testimoni sebelumnya">
                                <svg class="h-7 w-7 sm:h-8 sm:w-8 lg:h-7 lg:w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M14.5 18L8.5 12L14.5 6" stroke="currentColor" stroke-width="2.7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>

                            <button type="button"
                                @click="next()"
                                :disabled="activeIndex >= maxIndex()"
                                class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-[#9ba9bf] bg-white/95 text-[#7b8798] shadow-[0_8px_18px_rgba(15,23,42,0.18)] transition enabled:hover:border-[#1839a8] enabled:hover:text-[#1839a8] focus:outline-none disabled:opacity-60 sm:h-14 sm:w-14 lg:h-12 lg:w-12"
                                aria-label="Testimoni berikutnya">
                                <svg class="h-7 w-7 sm:h-8 sm:w-8 lg:h-7 lg:w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M9.5 6L15.5 12L9.5 18" stroke="currentColor" stroke-width="2.7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="relative flex flex-col justify-center px-5 pb-10 pt-8 sm:px-8 lg:px-0 lg:pb-0 lg:pt-0">
                    <div class="pointer-events-none absolute inset-y-0 left-0 hidden w-24 bg-linear-to-r from-[#f5f8fc]/0 to-[#f5f8fc] lg:block"></div>

                    <div class="testimonials-carousel relative z-10 -mt-24 overflow-visible pl-0 pr-0 sm:-mt-28 lg:mt-0 lg:-translate-x-[19%] lg:pl-0"
                        aria-live="polite">
                        <div x-ref="track"
                            data-testimonial-track
                            class="flex will-change-transform"
                            :class="transitionEnabled ? 'transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)]' : ''"
                            :style="`gap: var(--testimonial-card-gap); transform: translate3d(-${activeIndex * cardStep}px, 0, 0);`">
                            @forelse ($testimonis as $testimoni)
                                <article data-testimonial-card
                                    class="group relative flex h-[380px] shrink-0 flex-col justify-between rounded-md border p-8 shadow-[0_14px_26px_rgba(15,23,42,0.18)] transition-[background-color,color,opacity,box-shadow,border-color] duration-500 sm:h-[420px] sm:p-10 lg:h-[450px] lg:p-12"
                                    style="width: var(--testimonial-card-width);"
                                    :class="cardTone({{ $loop->index }})"
                                    :aria-hidden="cardPosition({{ $loop->index }}) > 2 || cardPosition({{ $loop->index }}) < 0">
                                    <div class="flex h-full min-h-0 flex-col">
                                        <p class="no-scrollbar min-h-0 overflow-y-auto text-[14px] font-normal italic leading-relaxed tracking-normal sm:text-[15px]"
                                            :class="cardPosition({{ $loop->index }}) === 0 ? 'text-white' : (cardPosition({{ $loop->index }}) === 1 ? 'text-gray-700' : 'text-[#939393]')">
                                            &ldquo;{{ $testimoni->pesan }}&rdquo;
                                        </p>

                                        <div class="mt-auto flex items-center gap-5 pt-8">
                                            @if ($testimoni->gambar_pelanggan)
                                                <img src="{{ Storage::url($testimoni->gambar_pelanggan) }}" alt="{{ $testimoni->nama }}"
                                                    class="h-14 w-14 shrink-0 rounded-full border-2 object-cover shadow-sm sm:h-16 sm:w-16"
                                                    :class="cardPosition({{ $loop->index }}) === 0 ? 'border-white/20' : 'border-gray-100'">
                                            @else
                                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full border-2 text-lg font-bold shadow-sm sm:h-16 sm:w-16"
                                                    :class="cardPosition({{ $loop->index }}) === 0 ? 'border-white/20 bg-white/15 text-white' : 'border-gray-100 bg-blue-50 text-[#1839a8]'">
                                                    {{ Str::substr($testimoni->nama, 0, 1) }}
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <h4 class="text-[17px] font-bold leading-tight"
                                                    :class="cardPosition({{ $loop->index }}) === 0 ? 'text-white' : 'text-gray-900'">
                                                    {{ $testimoni->nama }}
                                                </h4>
                                                {{--
                                                <p class="mt-2 text-[13px] font-medium leading-tight"
                                                    :class="cardPosition({{ $loop->index }}) === 0 ? 'text-white/70' : 'text-gray-500'">
                                                    {{ $testimoni->jabatan }}
                                                </p>
                                                --}}
                                                <p class="mt-1 text-[13px] font-medium leading-tight"
                                                    :class="cardPosition({{ $loop->index }}) === 0 ? 'text-white/70' : 'text-gray-500'">
                                                    {{ $testimoni->nama_perusahaan }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <article data-testimonial-card
                                    class="group relative flex h-[380px] shrink-0 flex-col justify-between rounded-md border p-8 shadow-[0_14px_26px_rgba(15,23,42,0.18)] transition-[background-color,color,opacity,box-shadow,border-color] duration-500 sm:h-[420px] sm:p-10 lg:h-[450px] lg:p-12"
                                    style="width: var(--testimonial-card-width);"
                                    :class="cardTone(0)"
                                    :aria-hidden="false">
                                    <div class="flex h-full flex-col">
                                        <p class="text-[14px] font-normal italic leading-relaxed tracking-normal text-white sm:text-[15px]">
                                            &ldquo;Testimoni akan muncul setelah data ditambahkan pada admin panel.&rdquo;
                                        </p>
                                    </div>
                                </article>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="peta-pelanggan" class="bg-white pb-24 pt-16 md:pb-16 md:pt-24">
            <div class="mx-auto max-w-6xl px-6 lg:px-0">
                <div class="mb-10 md:mb-14" data-aos="fade-up">
                    <div class="grid grid-cols-1 items-start gap-6 md:gap-8 lg:grid-cols-12">
                        <div class="lg:col-span-7">
                            <div class="mb-2 flex items-center gap-2">
                                <span class="text-[10px] text-orange-600">■</span>
                                <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Customer Intelligence</span>
                            </div>
                            <h2 class="text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">Peta Penyebaran Pelanggan</h2>
                        </div>
                        <div class="lg:col-span-5">
                            <p class="text-justify text-lg leading-relaxed text-gray-700/95 md:text-lg lg:pt-2">
                                Visualisasi interaktif sebaran pelanggan pada wilayah Indonesia. Arahkan kursor ke titik kota/kabupaten untuk melihat jumlah pelanggan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:gap-6 xl:grid-cols-[minmax(0,1.7fr)_minmax(300px,1fr)]">
                    <article class="map-distribution-card self-start p-3 md:p-4" data-aos="fade-up" data-aos-delay="40">
                        <div id="customer-distribution-map" class="relative z-0"></div>
                    </article>

                    <aside class="flex flex-col gap-5 lg:pl-4" data-aos="fade-up" data-aos-delay="90">
                        <div class="rounded-2xl bg-linear-to-br from-orange-500 to-orange-600 p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.4)]">
                            <p class="mb-1 text-xs font-bold uppercase tracking-[0.22em] text-white/80">Total Pelanggan</p>
                            <div class="flex items-baseline gap-2">
                                <p id="map-total-customers" class="text-4xl font-bold tracking-tight text-white">0</p>
                                <p class="text-xs font-medium text-white/70">Pelanggan</p>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-linear-to-br from-blue-500 to-blue-600 p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.4)]">
                            <p class="mb-1 text-xs font-bold uppercase tracking-[0.22em] text-white/80">Wilayah Cakupan</p>
                            <div class="flex items-baseline gap-2">
                                <p id="map-total-coverage" class="text-4xl font-bold tracking-tight text-white">0</p>
                                <p class="text-xs font-medium text-white/70">Kab / Kota</p>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.4)]">
                            <h3 class="mb-5 text-xs font-bold uppercase tracking-[0.22em] text-slate-500">Legend Sebaran</h3>
                            <ul class="space-y-4">
                                <li class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                                    <span class="h-3 w-3 rounded-full bg-orange-700 ring-4 ring-orange-700/10"></span>
                                    Tinggi (≥ 90)
                                </li>
                                <li class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                                    <span class="h-3 w-3 rounded-full bg-orange-500 ring-4 ring-orange-500/10"></span>
                                    Menengah (45 - 89)
                                </li>
                                <li class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                                    <span class="h-3 w-3 rounded-full bg-orange-300 ring-4 ring-orange-300/10"></span>
                                    Dasar (&lt; 45)
                                </li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        {{--
            Arsip section testimoni lama:
            <x-landing.testimoni-legacy :testimonis="$testimonis" />
        --}}

        <x-zona-integritas.section :show-content="false" />

        <section id="faq" class="bg-white py-24">
            <div class="mx-auto max-w-6xl px-6" x-data="{ activeItems: [1], currentImage: 1, toggle(id) { if (this.activeItems.includes(id)) { this.activeItems = this.activeItems.filter(i => i !== id); } else { this.activeItems.push(id); this.currentImage = id; }}}">
                <div class="mb-16" data-aos="fade-up">
                    <div class="mb-2 flex items-center gap-2">
                        <span class="text-[10px] text-orange-600">■</span>
                        <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">FAQ</span>
                    </div>
                    <h2 class="mb-6 text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">Pertanyaan yang Sering Diajukan</h2>
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

        <section id="berita" class="relative overflow-hidden bg-slate-50/80 py-16 md:py-24">
            <div class="pointer-events-none absolute inset-0 opacity-40"
                style="background-image: radial-gradient(#64748b20 0.8px, transparent 0.8px); background-size: 24px 24px;">
            </div>
            <div class="mx-auto max-w-6xl px-6 lg:px-0">
                <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.12fr)] lg:items-start lg:gap-14" data-aos="fade-up">
                    <div>
                        <p class="mb-3 text-sm font-bold uppercase tracking-normal text-[#0038b8]">
                            BERITA
                        </p>
                        <h2 class="text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">
                            Berita Terkini
                        </h2>
                    </div>

                    <div class="flex flex-col gap-6 lg:pt-3">
                        <p class="max-w-xl text-lg font-normal leading-relaxed text-slate-700 md:text-lg">
                            Ikuti kabar terbaru, agenda, dan informasi layanan BSPJI Banda Aceh dalam mendukung pertumbuhan industri yang berdaya saing.
                        </p>

                        <a href="{{ $routeOrHash('berita.index') }}"
                            class="group inline-flex w-fit items-center gap-3 rounded-full border border-slate-600 px-7 py-3 text-sm font-semibold text-slate-700 transition duration-300 hover:border-slate-900 hover:bg-slate-900 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-900/20">
                            Selengkapnya
                            <i data-lucide="arrow-right" class="h-5 w-5 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>

                @if ($latestNews->isEmpty())
                    <div class="mt-12 rounded-lg border border-dashed border-slate-300 bg-[#f2f5f9] p-8 text-slate-600">
                        Berita terbaru belum tersedia.
                    </div>
                @else
                    <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 lg:gap-10">
                        @foreach ($latestNews as $index => $item)
                            @php
                                $newsImage = $item->cover_image
                                    ? asset('storage/' . $item->cover_image)
                                    : asset('images/imagelab.webp');
                            @endphp
                            <article class="group flex h-full flex-col" data-aos="fade-up" data-aos-delay="{{ 100 + ($index % 3) * 75 }}">
                                <a href="{{ route('berita.show', $item) }}"
                                    class="block overflow-hidden rounded-lg bg-[#f1f4f9] focus:outline-none focus:ring-2 focus:ring-[#123cad]/25">
                                    <img src="{{ $newsImage }}" alt="{{ $item->title }}"
                                        class="aspect-video w-full object-cover transition duration-500 group-hover:scale-105">
                                </a>

                                <div class="flex flex-1 flex-col pt-6">
                                    <p class="mb-3 text-xs font-bold uppercase tracking-[0.16em] text-[#0038b8]">
                                        {{ $item->published_at?->format('d M Y') }}
                                    </p>

                                    <h3 class="text-xl font-semibold leading-snug text-gray-900 md:text-2xl">
                                        <a href="{{ route('berita.show', $item) }}" class="transition hover:text-[#0038b8]">
                                            {{ $item->title }}
                                        </a>
                                    </h3>

                                    @if ($item->excerpt)
                                        <p class="mt-4 line-clamp-3 text-base leading-relaxed text-slate-700">
                                            {{ $item->excerpt }}
                                        </p>
                                    @endif

                                    <a href="{{ route('berita.show', $item) }}"
                                        class="group/link mt-8 inline-flex w-fit items-center gap-3 rounded-full border border-slate-600 px-7 py-3 text-sm font-semibold text-slate-700 transition duration-300 hover:border-slate-900 hover:bg-slate-900 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-900/20">
                                        Selengkapnya
                                        <i data-lucide="arrow-right" class="h-5 w-5 transition-transform group-hover/link:translate-x-1"></i>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
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
                // { targetId: 'chart-spkp', labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'], values: [3.1, 3.2, 3.3, 3.4, 3.5, 3.6, 3.7], min: 0, max: 4, step: 0.5, color: '#3b82f6', stroke: '#2563eb' },
                // { targetId: 'chart-anti-korupsi', labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'], values: [3.0, 3.2, 3.3, 3.4, 3.6, 3.7, 3.8], min: 0, max: 4, step: 0.5, color: '#10b981', stroke: '#059669' },
                { targetId: 'chart-jumlah-pelanggan', labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'], values: [210, 255, 300, 360, 420, 490, 560], min: 0, max: 600, step: 50, color: '#f59e0b', stroke: '#d97706' },
                { targetId: 'chart-spm', labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'], values: [78, 80, 81, 83, 85, 87, 89, 90, 92, 93, 94, 95], min: 0, max: 100, step: 20, color: '#ef4444', stroke: '#dc2626' }
            ].forEach(renderBarChart);
        });
    </script>
</body>

</html>
