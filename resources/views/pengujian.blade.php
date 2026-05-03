<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengujian</title>
    <meta
        name="description"
        content="Halaman layanan pengujian profesional dengan standar internasional."
    >
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @livewireScriptConfig
</head>
<body
    x-data="{
        tab: 'sertifikasi',
        scopeQuery: '',
        selectedLab: '',
        lightboxOpen: false,
        lightboxImage: '',
        lightboxAlt: '',
        labMenuItems: @js(
            collect($labOptions)
                ->map(fn ($label, $value) => ['value' => $value, 'label' => $label])
                ->values()
                ->all()
        ),
        scopeItems: @js(
            $ruangLingkupan->values()->map(fn ($item) => [
                'lab' => $item->lab,
                'lab_label' => \App\Models\RuangLingkup::getLabLabel($item->lab),
                'komoditi' => $item->komoditi ?? '-',
                'ruang_lingkup_html' => $item->ruang_lingkup,
                'ruang_lingkup_text' => trim(strip_tags((string) $item->ruang_lingkup)),
            ])->all()
        ),
        openLightbox(image, alt) {
            this.lightboxImage = image;
            this.lightboxAlt = alt;
            this.lightboxOpen = true;
        },
        closeLightbox() {
            this.lightboxOpen = false;
        },
        get filteredScopeItems() {
            const query = this.scopeQuery.trim().toLowerCase();

            return this.scopeItems.filter((item) => {
                const matchesLab = !this.selectedLab || item.lab === this.selectedLab;

                if (!matchesLab) {
                    return false;
                }

                if (!query) {
                    return true;
                }

                return `${item.lab_label} ${item.komoditi} ${item.ruang_lingkup_text}`
                    .toLowerCase()
                    .includes(query);
            });
        }
    }"
    :class="lightboxOpen ? 'overflow-hidden' : 'overflow-x-hidden'"
    class="overflow-x-hidden bg-white font-sans text-[#1d1d1f] antialiased leading-relaxed"
>
    <header class="relative mb-8 flex h-[300px] w-full items-center overflow-hidden text-white sm:mx-auto sm:mt-5 sm:mb-10 sm:h-[360px] sm:w-[96%] sm:rounded-[25px] md:mt-5 md:h-[400px]">
        <img
            src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=2070"
            alt="Pengujian Hero"
            class="absolute inset-0 -z-10 h-full w-full object-cover brightness-[0.7]"
        >
        <div class="mx-auto w-full max-w-[1400px] px-5 text-left sm:px-8 md:px-20">
            <h1 class="text-[2.25rem] font-bold tracking-[-0.03em] sm:text-[3rem] md:text-[4.5rem]">
                Pengujian
            </h1>
        </div>
    </header>

    <main class="mx-auto grid max-w-[1400px] grid-cols-1 items-start gap-8 px-4 sm:px-5 md:px-10 lg:grid-cols-[280px_1fr] lg:gap-[60px]">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:sticky lg:top-10 lg:grid-cols-1">
            <button
                type="button"
                @click="tab = 'sertifikasi'"
                :class="tab === 'sertifikasi' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'sertifikasi' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75m5.25 2.814c0 4.285-2.924 8.032-7.087 9.063a1.38 1.38 0 0 1-.326.037 1.38 1.38 0 0 1-.326-.037C8.348 20.596 5.424 16.85 5.424 12.564V7.902c0-.67.423-1.267 1.056-1.491l5.25-1.867a1.37 1.37 0 0 1 .913 0l5.25 1.867c.633.224 1.056.82 1.056 1.49v4.663Z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Sertifikasi</span>
            </button>

            <button
                type="button"
                @click="tab = 'ruang-lingkup'"
                :class="tab === 'ruang-lingkup' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'ruang-lingkup' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.75h4.5m-7.386 2.25h10.272c.53 0 1.02.28 1.286.736l2.226 3.818a1.5 1.5 0 0 1 0 1.51l-2.226 3.818a1.5 1.5 0 0 1-1.286.736H6.864a1.5 1.5 0 0 1-1.286-.736l-2.226-3.818a1.5 1.5 0 0 1 0-1.51l2.226-3.818A1.5 1.5 0 0 1 6.864 6ZM9 9.75h6m-6 3h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Ruang Lingkup</span>
            </button>

            <button
                type="button"
                @click="tab = 'alur'"
                :class="tab === 'alur' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'alur' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 15.75 19.5 19.5m0 0-3.75 3.75M19.5 19.5H9A6.75 6.75 0 0 1 2.25 12.75V10.5A6.75 6.75 0 0 1 9 3.75h3" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Alur</span>
            </button>

            <button
                type="button"
                @click="tab = 'tarif'"
                :class="tab === 'tarif' ? 'border-gray-400 bg-slate-800 text-white shadow-[0_8px_20px_rgba(0,0,0,0.06)]' : 'border-black/30 bg-white text-[#1d1d1f]'"
                class="group flex scale-100 items-center gap-[15px] rounded-[12px] border px-5 py-4 text-left transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] hover:scale-[1.02]"
            >
                <svg class="h-5 w-5 shrink-0" :class="tab === 'tarif' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14.25 6.75 12m0 0L9 9.75M6.75 12h10.5m3.75-6.75v13.5A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V5.25A2.25 2.25 0 0 1 5.25 3h13.5A2.25 2.25 0 0 1 21 5.25Z" />
                </svg>
                <span class="text-base font-semibold sm:text-[1.05rem]">Tarif</span>
            </button>
        </div>

        <article class="min-h-[70vh] pb-20 sm:pb-[150px]">
            <section x-show="tab === 'sertifikasi'" x-transition.opacity.duration.300ms>
                <div class="mx-auto max-w-4xl space-y-6">
                    @if($sertifikasi && $sertifikasi->image)
                        <div class="flex justify-start">
                            <a
                                href="{{ asset('storage/' . $sertifikasi->image) }}"
                                download
                                class="inline-flex items-center gap-2 rounded-xl border border-black/25 px-4 py-2 text-sm font-semibold text-slate-800 transition-all active:scale-95"
                            >
                                <svg class="h-4 w-4 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0 4-4m-4 4-4-4m-4 7.5A1.5 1.5 0 0 0 5.5 20h13a1.5 1.5 0 0 0 1.5-1.5V18" />
                                </svg>
                                Download Sertifikat Akreditasi
                            </a>
                        </div>

                        <button
                            type="button"
                            @click="openLightbox('{{ asset('storage/' . $sertifikasi->image) }}', 'Sertifikat Akreditasi')"
                            class="group relative block w-full max-w-[720px] cursor-pointer overflow-hidden rounded-[24px] text-left sm:w-[85%] lg:w-[70%]"
                        >
                            <img
                                src="{{ asset('storage/' . $sertifikasi->image) }}"
                                alt="Sertifikat Akreditasi"
                                class="h-auto w-full object-contain transition-transform duration-700 group-hover:scale-105"
                            >
                            <div class="absolute bottom-6 left-6 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                <span class="rounded-full bg-slate-800 px-4 py-2 text-sm font-bold text-white shadow-sm">
                                    Klik untuk memperbesar
                                </span>
                            </div>
                        </button>
                    @else
                        <div class="rounded-[30px] border border-dashed border-black/15 bg-[#fbfbfd] px-6 py-20 text-center">
                            <p class="font-medium text-slate-400">Gambar sertifikat belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </section>

            <section x-show="tab === 'ruang-lingkup'" x-transition.opacity.duration.300ms style="display: none;">
                <div class="mx-auto max-w-5xl space-y-6">
                    <p class="max-w-3xl text-sm leading-relaxed text-slate-600 md:text-base">
                        Informasi ruang lingkup pengujian dapat difilter berdasarkan lab dan tetap bisa dicari cepat
                        melalui komoditi maupun uraian ruang lingkup.
                    </p>

                    <form @submit.prevent class="space-y-4 rounded-2xl border border-black/20 bg-[#fbfbfd] p-4 sm:p-6">
                        <div class="space-y-3">
                            <label class="block text-sm font-bold uppercase tracking-wider text-[#1d1d1f]">
                                Pilih lab
                            </label>
                            <div class="flex flex-wrap gap-3">
                                <button
                                    type="button"
                                    @click="selectedLab = ''"
                                    :class="selectedLab === '' ? 'bg-slate-800 text-white border-slate-800' : 'bg-white text-slate-700 border-black/15'"
                                    class="rounded-full border px-4 py-2 text-sm font-semibold transition-all"
                                >
                                    Semua Lab
                                </button>

                                <template x-for="lab in labMenuItems" :key="lab.value">
                                    <button
                                        type="button"
                                        @click="selectedLab = lab.value"
                                        :class="selectedLab === lab.value ? 'bg-slate-800 text-white border-slate-800' : 'bg-white text-slate-700 border-black/15'"
                                        class="rounded-full border px-4 py-2 text-sm font-semibold transition-all"
                                        x-text="lab.label"
                                    ></button>
                                </template>
                            </div>
                        </div>

                        <label class="block text-sm font-bold uppercase tracking-wider text-[#1d1d1f]">
                            Cari ruang lingkup pengujian
                        </label>
                        <div class="flex flex-col gap-4 md:flex-row">
                            <div class="relative flex-1">
                                <input
                                    x-model="scopeQuery"
                                    type="text"
                                    placeholder="Masukkan lab, komoditi, atau kata kunci ruang lingkup"
                                    class="w-full rounded-xl border border-black/20 bg-white px-4 py-3 pr-10 transition-all focus:outline-none focus:ring-2 focus:ring-slate-200"
                                >
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-800 px-8 py-3 font-bold text-white transition-all active:scale-95 md:w-auto"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                </svg>
                                Cari
                            </button>
                        </div>
                    </form>

                    <div class="overflow-hidden rounded-2xl border border-black/20 bg-white shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse text-left">
                                <thead>
                                    <tr class="border-b border-black/20 bg-slate-50">
                                        <th class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-[#1d1d1f] sm:px-6 sm:text-sm">No</th>
                                        <th class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-[#1d1d1f] sm:px-6 sm:text-sm">Lab</th>
                                        <th class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-[#1d1d1f] sm:px-6 sm:text-sm">Komoditi / Produk</th>
                                        <th class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-[#1d1d1f] sm:px-6 sm:text-sm">Ruang Lingkup Pengujian</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-black/10" x-show="filteredScopeItems.length">
                                    <template x-for="(item, index) in filteredScopeItems" :key="`${item.komoditi}-${index}`">
                                        <tr class="transition-colors hover:bg-slate-50/50">
                                            <td class="px-4 py-4 text-sm text-[#86868b] sm:px-6" x-text="index + 1"></td>
                                            <td class="px-4 py-4 text-sm font-medium text-[#1d1d1f] sm:px-6" x-text="item.lab_label"></td>
                                            <td class="px-4 py-4 text-sm font-medium text-[#1d1d1f] sm:px-6" x-text="item.komoditi || '-'"></td>
                                            <td class="px-4 py-4 text-sm leading-relaxed text-[#86868b] sm:px-6" x-html="item.ruang_lingkup_html || '-'"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <div x-show="!filteredScopeItems.length" class="px-6 py-16 text-center">
                            <p class="font-medium text-slate-400">Data ruang lingkup yang Anda cari belum ditemukan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section x-show="tab === 'alur'" x-transition.opacity.duration.300ms style="display: none;">
                <div class="mx-auto max-w-5xl space-y-6">
                    @if($alurPengujian && $alurPengujian->image)
                        <button
                            type="button"
                            @click="openLightbox('{{ asset('storage/' . $alurPengujian->image) }}', 'Alur Pelayanan Pengujian')"
                            class="group relative block w-full cursor-pointer overflow-hidden rounded-[30px] border border-black/15 text-left shadow-xl"
                        >
                            <img
                                src="{{ asset('storage/' . $alurPengujian->image) }}"
                                alt="Alur Pelayanan Pengujian"
                                class="h-auto w-full object-cover transition-transform duration-700 group-hover:scale-[1.01]"
                            >
                        </button>
                    @else
                        <div class="rounded-[30px] border border-dashed border-black/15 bg-[#fbfbfd] px-6 py-20 text-center">
                            <p class="font-medium text-slate-400">Gambar alur layanan belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </section>

            <section x-show="tab === 'tarif'" x-transition.opacity.duration.300ms style="display: none;">
                <div class="mx-auto max-w-5xl space-y-8">
                    <div class="rounded-[24px] border border-black/10 bg-slate-50 p-5 sm:rounded-[30px] sm:p-8">
                        <p class="text-justify text-sm leading-relaxed text-slate-700 md:text-base">
                            BSPJI Banda Aceh menggunakan standar biaya yang mengacu pada
                            <strong>Peraturan Pemerintah Republik Indonesia Nomor 54 Tahun 2021</strong>
                            tentang Jenis dan Tarif atas Jenis Penerimaan Negara Bukan Pajak yang berlaku pada
                            Kementerian Perindustrian,
                            <strong>Peraturan Menteri Keuangan Nomor 108/PMK.02/2022 Tahun 2022</strong>
                            tentang Jenis dan Tarif atas Jenis Penerimaan Negara Bukan Pajak yang bersifat volatil yang
                            berlaku pada Kementerian Perindustrian dan
                            <strong>Peraturan Menteri Perindustrian Republik Indonesia Nomor 19 Tahun 2021</strong>
                            tentang Besaran, Persyaratan, dan Tata Cara Pengenaan Tarif Tertentu atas Jenis
                            Penerimaan Negara Bukan Pajak yang Berlaku pada Kementerian Perindustrian.
                        </p>
                    </div>

                    @livewire('tarif-pengujian')
                </div>
            </section>
        </article>
    </main>

    <div
        x-show="lightboxOpen"
        x-transition.opacity.duration.300ms
        @click="closeLightbox()"
        @keydown.escape.window="closeLightbox()"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4 backdrop-blur-sm md:p-10"
        style="display: none;"
    >
        <button
            type="button"
            @click.stop="closeLightbox()"
            class="absolute top-6 right-6 z-[110] text-white transition-colors hover:text-gray-300"
            aria-label="Tutup lightbox"
        >
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <img
            :src="lightboxImage"
            :alt="lightboxAlt"
            @click.stop
            class="max-h-full max-w-full rounded-lg shadow-2xl"
        >
    </div>
</body>
</html>
