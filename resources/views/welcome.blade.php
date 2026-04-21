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
    </main>
</body>
</html>
