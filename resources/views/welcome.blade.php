<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dummy Landing Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 antialiased font-sans">
    <x-layouts.partials.navbar />

    <main class="max-w-5xl mx-auto px-4 pt-32 pb-10 space-y-12">
        <section>
            <h1 class="text-3xl font-bold mb-6">dummy section profil</h1>

            @if ($sectionProfils->isEmpty())
                <div class="bg-white border rounded-lg p-6">
                    <p>Belum ada data Section Profil dari admin panel.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($sectionProfils as $profil)
                        <article class="bg-white border rounded-lg p-4">
                            <img
                                src="{{ Storage::url($profil->foto) }}"
                                alt="Foto section profil"
                                class="w-full h-56 object-contain bg-gray-50 rounded"
                            >
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section>
            <h1 class="text-3xl font-bold mb-6">dummy section sipintu</h1>

            @if (! $sectionSipintu)
                <div class="bg-white border rounded-lg p-6">
                    <p>Belum ada data Section Sipintu dari admin panel.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <article class="bg-white border rounded-lg p-4">
                        <h2 class="font-semibold mb-3">Gambar Mobile</h2>
                        @if ($sectionSipintu->gambar_mobile)
                            <img
                                src="{{ Storage::url($sectionSipintu->gambar_mobile) }}"
                                alt="Gambar mobile sipintu"
                                class="w-full h-72 object-contain bg-gray-50 rounded"
                            >
                        @else
                            <p class="text-sm text-gray-500">Gambar mobile belum diisi.</p>
                        @endif
                    </article>

                    <article class="bg-white border rounded-lg p-4">
                        <h2 class="font-semibold mb-3">Gambar Desktop</h2>
                        @if ($sectionSipintu->gambar_desktop)
                            <img
                                src="{{ Storage::url($sectionSipintu->gambar_desktop) }}"
                                alt="Gambar desktop sipintu"
                                class="w-full h-72 object-contain bg-gray-50 rounded"
                            >
                        @else
                            <p class="text-sm text-gray-500">Gambar desktop belum diisi.</p>
                        @endif
                    </article>
                </div>
            @endif
        </section>

        <section>
            <h1 class="text-3xl font-bold mb-6">dummy section layanan</h1>

            @if ($sectionLayanans->isEmpty())
                <div class="bg-white border rounded-lg p-6">
                    <p>Belum ada data Section Layanan dari admin panel.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($sectionLayanans as $layanan)
                        <article class="bg-white border rounded-lg p-4">
                            @if ($layanan->gambar)
                                <img
                                    src="{{ Storage::url($layanan->gambar) }}"
                                    alt="{{ $layanan->nama_layanan }}"
                                    class="w-full h-48 object-cover bg-gray-50 rounded mb-4"
                                >
                            @endif
                            <h2 class="text-xl font-semibold mb-2 capitalize">{{ $layanan->nama_layanan }}</h2>
                            <div class="text-gray-600 prose prose-sm max-w-none">
                                {!! $layanan->detail !!}
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section>
            <h1 class="text-3xl font-bold mb-6">dummy logo mitra</h1>

            @if ($logos->isEmpty())
                <div class="bg-white border rounded-lg p-6">
                    <p>Belum ada data Logo Mitra dari admin panel.</p>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center">
                    @foreach ($logos as $logo)
                        <article class="bg-white border rounded-lg p-4 flex items-center justify-center h-32">
                            <img
                                src="{{ Storage::url($logo->gambar) }}"
                                alt="Logo Mitra"
                                class="max-w-full max-h-full object-contain filter grayscale hover:grayscale-0 transition-all duration-300"
                            >
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section>
            <h1 class="text-3xl font-bold mb-6">dummy gambar pelengkap</h1>

            @if ($pelengkaps->isEmpty())
                <div class="bg-white border rounded-lg p-6">
                    <p>Belum ada data Gambar Pelengkap dari admin panel.</p>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($pelengkaps as $pelengkap)
                        <article class="bg-white border rounded-lg p-4">
                            <img
                                src="{{ Storage::url($pelengkap->gambar) }}"
                                alt="Gambar Pelengkap"
                                class="w-full h-auto rounded object-cover"
                            >
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section>
            <h1 class="text-3xl font-bold mb-6">dummy sertifikat</h1>

            @if ($sertifikats->isEmpty())
                <div class="bg-white border rounded-lg p-6">
                    <p>Belum ada data Sertifikat dari admin panel.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($sertifikats as $sertifikat)
                        <article class="bg-white border rounded-lg p-4 flex flex-col items-center">
                            @if ($sertifikat->gambar)
                                <img
                                    src="{{ Storage::url($sertifikat->gambar) }}"
                                    alt="{{ $sertifikat->nama_sertifikat }}"
                                    class="w-full h-64 object-contain bg-gray-50 rounded mb-4"
                                >
                            @endif
                            <h2 class="text-lg font-semibold text-center">{{ $sertifikat->nama_sertifikat }}</h2>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section>
            <h1 class="text-3xl font-bold mb-6">dummy section testimoni</h1>

            @if ($testimonis->isEmpty())
                <div class="bg-white border rounded-lg p-6">
                    <p>Belum ada data Testimoni dari admin panel.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($testimonis as $testimoni)
                        <article class="bg-white border rounded-xl p-6 shadow-sm flex flex-col">
                            <div class="flex items-center gap-4 mb-6">
                                @if ($testimoni->gambar_pelanggan)
                                    <img 
                                        src="{{ Storage::url($testimoni->gambar_pelanggan) }}" 
                                        alt="{{ $testimoni->nama }}"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-primary/10"
                                    >
                                @else
                                    <div class="w-14 h-14 rounded-full bg-primary/5 flex items-center justify-center font-bold text-primary">
                                        {{ substr($testimoni->nama, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-gray-900 leading-tight">{{ $testimoni->nama }}</h3>
                                    <p class="text-sm text-gray-500">{{ $testimoni->jabatan }} @ {{ $testimoni->nama_perusahaan }}</p>
                                </div>
                            </div>
                            <blockquote class="text-gray-600 italic leading-relaxed grow">
                                &ldquo;{{ $testimoni->pesan }}&rdquo;
                            </blockquote>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</body>
</html>
