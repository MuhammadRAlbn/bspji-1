@props([
    'dokumensByKode' => collect(),
    'grafikIkms' => collect(),
])

@php
    use App\Models\ZonaIntegritasJenisDokumen;
    use Illuminate\Support\Facades\Storage;

    $dokumenGroups = collect($dokumensByKode);
    $grafikIkms = collect($grafikIkms);
    $documentList = static fn (string $kode) => collect($dokumenGroups->get($kode, collect()));

    $menuItems = [
        ['id' => 'zona-integritas', 'label' => 'Zona Integritas', 'image' => 'zi.png'],
        ['id' => 'ikm', 'label' => 'Indeks Kepuasan Masyarakat', 'image' => 'IKM.png'],
        ['id' => 'ipk', 'label' => 'Indeks Persepsi Korupsi', 'image' => 'persepsi-korupsi.png'],
        ['id' => 'pengaduan', 'label' => 'Pengaduan', 'image' => 'pengaduan.png'],
        ['id' => 'benturan', 'label' => 'Benturan Kepentingan', 'image' => 'benturan.png'],
        ['id' => 'gratifikasi', 'label' => 'Gratifikasi', 'image' => 'gratifikasi.png'],
        ['id' => 'wbs', 'label' => 'Whistle Blower System', 'image' => 'wbs.png'],
    ];

    $benturanFormUrl = null;
    $gratifikasiFormUrl = null;
@endphp

<section id="zona-integritas" class="bg-linear-to-b from-slate-50 via-white to-white py-16 md:pb-20 md:pt-8">
    <div class="mx-auto max-w-7xl px-6 lg:px-0" x-data="{ active: 'zona-integritas', ikmTab: 'grafik', benturanTab: 'benturan-kepentingan', gratifikasiTab: 'gratifikasi', wbsTab: 'wbs' }">
        <div class="mx-auto mb-14 max-w-2xl text-center" data-aos="fade-up">
            <div class="mb-4 flex items-center justify-center gap-2">
                <span class="text-[10px] text-orange-600">&#9632;</span>
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Komitmen Kami</span>
            </div>
            <h2 class="section-title-identic mb-4 text-gray-900">Zona Integritas</h2>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7 md:gap-5">
            @foreach ($menuItems as $item)
                <button type="button"
                    @click="active = '{{ $item['id'] }}'"
                    :class="active === '{{ $item['id'] }}' ? 'border-orange-400 bg-white shadow-lg shadow-orange-100' : 'border-transparent bg-white/70 shadow-sm'"
                    class="group flex min-h-44 flex-col items-center justify-center gap-3 rounded-lg border p-3 text-center transition duration-300 hover:-translate-y-1 hover:border-orange-300 hover:bg-white"
                    data-aos="zoom-in">
                    <span class="flex h-28 w-28 items-center justify-center sm:h-32 sm:w-32">
                        <img src="{{ asset('images/icon-zona/' . $item['image']) }}" alt="{{ $item['label'] }}"
                            class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-105">
                    </span>
                    <span class="text-sm font-semibold leading-tight text-slate-800">
                        {{ $item['label'] }}
                    </span>
                </button>
            @endforeach
        </div>

        <div class="mt-10 border-t border-slate-200 pt-10" x-cloak>
            <div x-show="active === 'zona-integritas'" x-transition.opacity.duration.300ms>
                <div class="grid gap-8 lg:grid-cols-[1fr_0.85fr] lg:items-start">
                    <div>
                        <h3 class="mb-4 text-2xl font-semibold tracking-tight text-slate-950">Zona Integritas</h3>
                        <p class="text-base leading-8 text-slate-600">
                            Zona Integritas adalah komitmen BSPJI Banda Aceh untuk membangun tata kelola yang bersih,
                            akuntabel, dan berorientasi pada pelayanan publik. Komitmen ini menjadi dasar peningkatan
                            kualitas layanan serta pencegahan praktik korupsi, kolusi, dan nepotisme.
                        </p>
                    </div>
                    <x-zona-integritas.document-grid
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_ZONA_INTEGRITAS)"
                        empty-message="Belum ada dokumen Zona Integritas yang tersedia." />
                </div>
            </div>

            <div x-show="active === 'ikm'" x-transition.opacity.duration.300ms style="display: none;">
                <div class="mb-8 flex flex-wrap gap-3">
                    <button type="button" @click="ikmTab = 'grafik'"
                        :class="ikmTab === 'grafik' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        Grafik
                    </button>
                    <button type="button" @click="ikmTab = 'laporan'"
                        :class="ikmTab === 'laporan' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        Laporan IKM
                    </button>
                </div>

                <div x-show="ikmTab === 'grafik'" x-transition.opacity.duration.300ms>
                    @if ($grafikIkms->isNotEmpty())
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            @foreach ($grafikIkms as $grafik)
                                <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                                    <img src="{{ Storage::url($grafik->gambar) }}" alt="{{ $grafik->judul }}"
                                        class="h-full w-full object-contain">
                                    <figcaption class="border-t border-slate-100 px-5 py-4 text-sm font-semibold text-slate-800">
                                        {{ $grafik->judul }}
                                    </figcaption>
                                </figure>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center text-sm font-medium text-slate-500">
                            Belum ada grafik IKM yang tersedia.
                        </div>
                    @endif
                </div>

                <div x-show="ikmTab === 'laporan'" x-transition.opacity.duration.300ms style="display: none;">
                    <x-zona-integritas.document-table
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_IKM_LAPORAN)"
                        empty-message="Belum ada laporan IKM yang tersedia." />
                </div>
            </div>

            <div x-show="active === 'ipk'" x-transition.opacity.duration.300ms style="display: none;">
                <h3 class="mb-6 text-2xl font-semibold tracking-tight text-slate-950">Indeks Persepsi Korupsi</h3>
                <x-zona-integritas.document-table
                    :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_INDEKS_PERSEPSI_KORUPSI)"
                    empty-message="Belum ada dokumen Indeks Persepsi Korupsi yang tersedia." />
            </div>

            <div x-show="active === 'pengaduan'" x-transition.opacity.duration.300ms style="display: none;">
                <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                    <h3 class="mb-2 text-xl font-semibold text-slate-900">Pengaduan</h3>
                    <p class="text-sm font-medium text-slate-500">Konten pengaduan akan ditambahkan pada tahap berikutnya.</p>
                </div>
            </div>

            <div x-show="active === 'benturan'" x-transition.opacity.duration.300ms style="display: none;">
                <div class="mb-8 flex flex-wrap gap-3">
                    <button type="button" @click="benturanTab = 'benturan-kepentingan'"
                        :class="benturanTab === 'benturan-kepentingan' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        Benturan Kepentingan
                    </button>
                    <button type="button" @click="benturanTab = 'laporan'"
                        :class="benturanTab === 'laporan' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        Laporan Pelaksanaan
                    </button>
                </div>

                <div x-show="benturanTab === 'benturan-kepentingan'" x-transition.opacity.duration.300ms>
                    <div class="grid gap-8 lg:grid-cols-[1fr_0.9fr]">
                        <div class="space-y-6">
                            <div>
                                <h3 class="mb-4 text-2xl font-semibold tracking-tight text-slate-950">Benturan Kepentingan</h3>
                                <p class="text-base leading-8 text-slate-600">
                                    Benturan kepentingan adalah kondisi ketika kepentingan pribadi, kelompok, atau pihak lain
                                    berpotensi memengaruhi objektivitas pelaksanaan tugas. BSPJI Banda Aceh mendorong setiap
                                    pihak untuk melaporkan potensi benturan kepentingan agar pelayanan tetap profesional.
                                </p>
                            </div>

                            @if ($benturanFormUrl)
                                <iframe src="{{ $benturanFormUrl }}" title="Form Benturan Kepentingan"
                                    class="h-[520px] w-full rounded-lg border border-slate-200 bg-white"></iframe>
                            @else
                                <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-sm font-medium text-slate-500">
                                    Formulir Google Benturan Kepentingan belum dikonfigurasi.
                                </div>
                            @endif
                        </div>
                        <x-zona-integritas.document-grid
                            :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_BENTURAN_KEPENTINGAN)"
                            empty-message="Belum ada dokumen Benturan Kepentingan yang tersedia." />
                    </div>
                </div>

                <div x-show="benturanTab === 'laporan'" x-transition.opacity.duration.300ms style="display: none;">
                    <x-zona-integritas.document-table
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_BENTURAN_LAPORAN)"
                        empty-message="Belum ada laporan pelaksanaan Benturan Kepentingan yang tersedia." />
                </div>
            </div>

            <div x-show="active === 'gratifikasi'" x-transition.opacity.duration.300ms style="display: none;">
                <div class="mb-8 flex flex-wrap gap-3">
                    <button type="button" @click="gratifikasiTab = 'gratifikasi'"
                        :class="gratifikasiTab === 'gratifikasi' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        Gratifikasi
                    </button>
                    <button type="button" @click="gratifikasiTab = 'laporan'"
                        :class="gratifikasiTab === 'laporan' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        Laporan Pelaksanaan
                    </button>
                </div>

                <div x-show="gratifikasiTab === 'gratifikasi'" x-transition.opacity.duration.300ms>
                    <div class="grid gap-8 lg:grid-cols-[1fr_0.9fr]">
                        <div>
                            <h3 class="mb-4 text-2xl font-semibold tracking-tight text-slate-950">Gratifikasi</h3>
                            <p class="text-base leading-8 text-slate-600">
                                Gratifikasi merupakan pemberian dalam bentuk uang, barang, rabat, komisi, pinjaman tanpa bunga,
                                perjalanan, fasilitas penginapan, atau manfaat lain yang berkaitan dengan jabatan. BSPJI Banda
                                Aceh berkomitmen menolak gratifikasi dan menjaga integritas pelayanan.
                            </p>
                        </div>

                        @if ($gratifikasiFormUrl)
                            <iframe src="{{ $gratifikasiFormUrl }}" title="Form Gratifikasi"
                                class="h-[520px] w-full rounded-lg border border-slate-200 bg-white"></iframe>
                        @else
                            <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-sm font-medium text-slate-500">
                                Formulir Google Gratifikasi belum dikonfigurasi.
                            </div>
                        @endif
                    </div>
                </div>

                <div x-show="gratifikasiTab === 'laporan'" x-transition.opacity.duration.300ms style="display: none;">
                    <x-zona-integritas.document-table
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_GRATIFIKASI_LAPORAN)"
                        empty-message="Belum ada laporan pelaksanaan Gratifikasi yang tersedia." />
                </div>
            </div>

            <div x-show="active === 'wbs'" x-transition.opacity.duration.300ms style="display: none;">
                <div class="mb-8 flex flex-wrap gap-3">
                    <button type="button" @click="wbsTab = 'wbs'"
                        :class="wbsTab === 'wbs' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        WBS
                    </button>
                    <button type="button" @click="wbsTab = 'laporan'"
                        :class="wbsTab === 'laporan' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        Laporan Pelaksanaan
                    </button>
                </div>

                <div x-show="wbsTab === 'wbs'" x-transition.opacity.duration.300ms>
                    <h3 class="mb-4 text-2xl font-semibold tracking-tight text-slate-950">Whistle Blower System</h3>
                    <p class="max-w-4xl text-base leading-8 text-slate-600">
                        Whistle Blower System menjadi sarana pelaporan dugaan pelanggaran yang berkaitan dengan integritas
                        organisasi. Setiap laporan diperlakukan secara hati-hati untuk mendukung lingkungan kerja yang bersih,
                        transparan, dan bertanggung jawab.
                    </p>
                </div>

                <div x-show="wbsTab === 'laporan'" x-transition.opacity.duration.300ms style="display: none;">
                    <x-zona-integritas.document-table
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_WBS_LAPORAN)"
                        empty-message="Belum ada laporan pelaksanaan WBS yang tersedia." />
                </div>
            </div>
        </div>
    </div>
</section>
