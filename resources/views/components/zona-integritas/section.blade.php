@props([
    'dokumensByKode' => collect(),
    'grafikIkms' => collect(),
    'initialActive' => 'zona-integritas',
    'showContent' => true,
])

@php
    use App\Models\ZonaIntegritasJenisDokumen;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Js;
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

    $validMenuIds = collect($menuItems)->pluck('id')->all();
    $initialActive = in_array($initialActive, $validMenuIds, true) ? $initialActive : 'zona-integritas';
    $tabUrl = static fn (string $tab): string => Route::has('zona-integritas.index')
        ? route('zona-integritas.index', ['tab' => $tab])
        : url('/zona-integritas?tab=' . $tab);

    $benturanFormUrl = null;
    $gratifikasiFormUrl = null;
@endphp

<section id="zona-integritas" class="bg-linear-to-b from-slate-50 via-white to-white py-16 md:pb-20 md:pt-8">
    <div class="mx-auto max-w-7xl px-6 lg:px-0"
        @if ($showContent)
            x-data="{
                active: {{ Js::from($initialActive) }},
                ikmTab: 'grafik',
                benturanTab: 'benturan-kepentingan',
                gratifikasiTab: 'gratifikasi',
                wbsTab: 'wbs',
                setActive(tab) {
                    this.active = tab;
                    const url = new URL(window.location.href);
                    url.searchParams.set('tab', tab);
                    window.history.replaceState({ tab }, '', url.toString());
                }
            }"
        @endif>
        
        @if ($showContent)
            <div class="mb-8" data-aos="fade-right">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Kembali ke Beranda
                </a>
            </div>
        @endif

        <div class="mx-auto mb-14 max-w-2xl text-center" data-aos="fade-up">
            <div class="mb-4 flex items-center justify-center gap-2">
                <span class="text-[10px] text-orange-600">&#9632;</span>
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Komitmen Kami</span>
            </div>
            <h2 class="mb-4 text-3xl font-light leading-tight tracking-tight text-gray-900 md:text-5xl">Zona Integritas</h2>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7 md:gap-5">
            @foreach ($menuItems as $item)
                @if ($showContent)
                    <button type="button"
                        @click="setActive('{{ $item['id'] }}')"
                        :class="active === '{{ $item['id'] }}' ? 'border-orange-300 bg-white shadow-md shadow-orange-100/50' : 'border-transparent bg-white/70 shadow-sm'"
                        class="group flex min-h-44 flex-col items-center justify-center gap-3 rounded-lg border p-3 text-center transition duration-300 hover:-translate-y-0.5 hover:border-orange-200 hover:bg-white hover:shadow-md hover:shadow-orange-100/50"
                        data-aos="zoom-in">
                        <span class="flex h-28 w-28 items-center justify-center sm:h-32 sm:w-32">
                            <img src="{{ asset('images/icon-zona/' . $item['image']) }}" alt="{{ $item['label'] }}"
                                class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-105">
                        </span>
                        <span class="text-sm font-semibold leading-tight text-slate-800">
                            {{ $item['label'] }}
                        </span>
                    </button>
                @else
                    <a href="{{ $tabUrl($item['id']) }}"
                        class="group flex min-h-44 flex-col items-center justify-center gap-3 rounded-lg border border-transparent bg-white/70 p-3 text-center shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-orange-200 hover:bg-white hover:shadow-md hover:shadow-orange-100/50"
                        data-aos="zoom-in">
                        <span class="flex h-28 w-28 items-center justify-center sm:h-32 sm:w-32">
                            <img src="{{ asset('images/icon-zona/' . $item['image']) }}" alt="{{ $item['label'] }}"
                                class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-105">
                        </span>
                        <span class="text-sm font-semibold leading-tight text-slate-800">
                            {{ $item['label'] }}
                        </span>
                    </a>
                @endif
            @endforeach
        </div>

        @if ($showContent)
        <div class="mt-10 border-t border-slate-200 pt-10" x-cloak>
            <div x-show="active === 'zona-integritas'">
                <div class="flex flex-col gap-10">
                    <x-zona-integritas.document-grid
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_ZONA_INTEGRITAS)"
                        empty-message="Belum ada dokumen Zona Integritas yang tersedia." />
                    
                    <div class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        <div>
                            <h3 class="mb-4 text-2xl font-bold tracking-tight text-slate-900">Apa Itu Zona Integritas?</h3>
                            <p class="text-base leading-relaxed text-slate-600">
                                Sistem birokrasi yang transparan, akuntabilitas, serta bebas dari Korupsi, Kolusi, dan Nepotisme (KKN) merupakan hal yang mutlak dijalankan oleh setiap instansi pemerintah, termasuk oleh Balai Standardisasi dan Pelayanan Jasa Industri (BSPJI) Banda Aceh. Guna mewujudkan birokrasi yang bersih KKN tersebut, BSPJI Banda Aceh terus berupaya mendorong pembangunan Zona Integritas menuju Wilayah Birokrasi Bersih dan Melayani (WBBM).
                            </p>
                        </div>

                        <div>
                            <p class="mb-5 text-base leading-relaxed text-slate-600">
                                Pembangunan Zona Integritas merupakan pemenuhan aspek terhadap 6 (enam) area perubahan meliputi:
                            </p>
                            
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <div class="flex items-center gap-3 rounded-lg border border-slate-100 bg-slate-50 p-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-100 font-bold text-orange-600">1</span>
                                    <span class="text-sm font-semibold text-slate-800">Manajemen Perubahan</span>
                                </div>
                                <div class="flex items-center gap-3 rounded-lg border border-slate-100 bg-slate-50 p-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-100 font-bold text-orange-600">2</span>
                                    <span class="text-sm font-semibold text-slate-800">Penataan Tatalaksana</span>
                                </div>
                                <div class="flex items-center gap-3 rounded-lg border border-slate-100 bg-slate-50 p-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-100 font-bold text-orange-600">3</span>
                                    <span class="text-sm font-semibold text-slate-800">Penataan Sistem Manajemen SDM</span>
                                </div>
                                <div class="flex items-center gap-3 rounded-lg border border-slate-100 bg-slate-50 p-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-100 font-bold text-orange-600">4</span>
                                    <span class="text-sm font-semibold text-slate-800">Penguatan Akuntabilitas</span>
                                </div>
                                <div class="flex items-center gap-3 rounded-lg border border-slate-100 bg-slate-50 p-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-100 font-bold text-orange-600">5</span>
                                    <span class="text-sm font-semibold text-slate-800">Penguatan Pengawasan</span>
                                </div>
                                <div class="flex items-center gap-3 rounded-lg border border-slate-100 bg-slate-50 p-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-100 font-bold text-orange-600">6</span>
                                    <span class="text-sm font-semibold text-slate-800">Peningkatan Kualitas Pelayanan Publik</span>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border border-orange-200 bg-orange-50 p-5">
                            <div class="flex items-start gap-4">
                                <div class="mt-0.5 shrink-0 text-orange-600">
                                    <i data-lucide="info" class="h-5 w-5"></i>
                                </div>
                                <p class="text-sm leading-relaxed text-orange-800">
                                    Dokumen pendukung Penilaian Mandiri Pembangunan Zona Integritas BSPJI Banda Aceh dapat diakses dengan menghubungi Unit Pelayanan Publik BSPJI Banda Aceh.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="active === 'ikm'" style="display: none;">
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

                <div x-show="ikmTab === 'grafik'">
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

                <div x-show="ikmTab === 'laporan'" style="display: none;">
                    <x-zona-integritas.document-table
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_IKM_LAPORAN)"
                        empty-message="Belum ada laporan IKM yang tersedia." />
                </div>
            </div>

            <div x-show="active === 'ipk'" style="display: none;">
                <h3 class="mb-6 text-2xl font-semibold tracking-tight text-slate-950">Indeks Persepsi Korupsi</h3>
                
                <div class="mb-6 rounded-lg border border-orange-200 bg-orange-50 p-4">
                    <p class="text-sm font-medium text-orange-800">
                        Untuk mengisi survey silahkan mengunjungi <a href="#" class="font-bold text-orange-600 underline transition hover:text-orange-700">link ini</a>.
                    </p>
                </div>

                <x-zona-integritas.document-table
                    :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_INDEKS_PERSEPSI_KORUPSI)"
                    empty-message="Belum ada dokumen Indeks Persepsi Korupsi yang tersedia." />
            </div>

            <div x-show="active === 'pengaduan'" style="display: none;">
                <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                    <h3 class="mb-2 text-xl font-semibold text-slate-900">Pengaduan</h3>
                    <p class="text-sm font-medium text-slate-500">Konten pengaduan akan ditambahkan pada tahap berikutnya.</p>
                </div>
            </div>

            <div x-show="active === 'benturan'" style="display: none;">
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

                <div x-show="benturanTab === 'benturan-kepentingan'">
                    <div class="grid gap-8 lg:grid-cols-[3fr_1fr]">
                        <div class="space-y-6">
                            <div>
                                <h3 class="mb-4 text-2xl font-semibold tracking-tight text-slate-950">Benturan Kepentingan</h3>
                                <p class="text-base leading-8 text-slate-600">
                                    Benturan Kepentingan adalah situasi dimana penyelenggara negara, memiliki atau patut diduga memiliki kepentingan pribadi, terhadap setiap penggunaan wewenang, sehingga dapat mempengaruhi kualitas keputusan dan/atau tindakannya. Kepentingan/pertimbangan pribadi tersebut dapat berasal dari kepentingan pribadi, kerabat atau kelompok yang kemudian mendesak atau mereduksi gagasan yang dibangun berdasarkan nalar profesionalnya sehingga keputusannya menyimpang dari orisionalitas keprofesionalannya dan akan berimplikasi pada penyelenggaraan negara khususnya di bidang pelayanan publik menjadi tidak efisien dan tidak efektif. Benturan kepentingan sering pula dimaknai sebagai konflik kepentingan (conflict of interest).
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
                            layout="list"
                            :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_BENTURAN_KEPENTINGAN)"
                            empty-message="Belum ada dokumen Benturan Kepentingan yang tersedia." />
                    </div>
                </div>

                <div x-show="benturanTab === 'laporan'" style="display: none;">
                    <x-zona-integritas.document-table
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_BENTURAN_LAPORAN)"
                        empty-message="Belum ada laporan pelaksanaan Benturan Kepentingan yang tersedia." />
                </div>
            </div>

            <div x-show="active === 'gratifikasi'" style="display: none;">
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

                <div x-show="gratifikasiTab === 'gratifikasi'">
                    <div class="flex flex-col gap-8">
                        <div>
                            <h3 class="mb-4 text-2xl font-semibold tracking-tight text-slate-950">Gratifikasi</h3>
                            <div class="space-y-4 text-base leading-8 text-slate-600">
                                <p>
                                    Pengertian mengenai gratifikasi dapat dilihat pada Penjelasan Pasal 12 B Ayat (1) UU No. 20 Tahun 2001, yaitu : "Yang dimaksud dengan "gratifikasi" dalam ayat ini adalah pemberian dalam arti luas, yakni meliputi pemberian uang, barang, rabat (discount), komisi, pinjaman tanpa bunga, tiket perjalanan, fasilitas penginapan, perjawalan wisata, pengobatan cuma-cuma, dan fasilitas lainnya. Gratifikasi tersebut baik yang diterima di dalam negeri maupun di luar negeri dan yang dilakukan dengan menggunakan sarana elektronik atau tanpa sarana elektronik."
                                </p>
                                <p>
                                    Tidak semua gratifikasi itu bertentangan dengan hukum, melainkan hanya gratifikasi yang memenuhi kriteria pada pasal 12 B, yaitu: "Setiap gratifikasi kepada pegawai negeri atau penyelenggara negara dianggap pemberian suap, apabila berhubungan dengan jabatannya dan yang berlawanan dengan kewajiban atau tugasnya, dengan ketentuan sebagai berikut...". Namun demikian, ketentuan tersebut tidak berlaku jika penerima melaporkan gratifikasi yang diterimanya kepada KPK atau Unit Pengendali Gratifikasi BSPJI Banda Aceh Kementerian Perindustrian selambat-lambatnya 30 (tiga puluh) hari kerja terhitung sejak tanggal gratifikasi tersebut diterima.
                                </p>
                                <p>
                                    Salah satu kebiasaan yang berlaku umum di masyarakat adalah pemberian tanda terima kasih atas jasa yang telah diberikan oleh petugas, baik dalam bentuk barang atau bahkan uang. Hal ini dapat menjadi suatu kebiasaan yang bersifat negatif dan dapat mengarah menjadi potensi perbuatan korupsi di kemudian hari. Potensi korupsi inilah yang berusaha dicegah oleh peraturan UU. Oleh karena itu, berapapun nilai gratifikasi yang anda terima, bila pemberian itu patut diduga berkaitan dengan jabatan/kewenangan yang dimiliki, maka sebaiknya segera dilaporkan ke Unit Pengendali Gratifikasi BSPJI Banda Aceh Kementerian Perindustrian untuk dianalisa lebih lanjut.
                                </p>
                            </div>
                            
                            <div class="mt-6 inline-block rounded-lg italic text-sm font-semibold text-orange-600">
                                F-FKAP-LPG
                            </div>
                        </div>

                        @if ($gratifikasiFormUrl)
                            <iframe src="{{ $gratifikasiFormUrl }}" title="Form Gratifikasi"
                                class="h-[600px] w-full rounded-lg border border-slate-200 bg-white shadow-sm"></iframe>
                        @else
                            <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center text-sm font-medium text-slate-500">
                                Formulir Google Gratifikasi belum dikonfigurasi.
                            </div>
                        @endif
                    </div>
                </div>

                <div x-show="gratifikasiTab === 'laporan'" style="display: none;">
                    <x-zona-integritas.document-table
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_BENTURAN_LAPORAN)"
                        empty-message="Belum ada laporan pelaksanaan Gratifikasi yang tersedia." />
                </div>
            </div>

            <div x-show="active === 'wbs'" style="display: none;">
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

                <div x-show="wbsTab === 'wbs'">
                    <h3 class="mb-4 text-2xl font-semibold tracking-tight text-slate-950">Whistle Blower System</h3>
                    <div class="space-y-4 text-base leading-8 text-slate-600">
                        <p>
                            Pelaporan pelanggaran (whistleblowing System) adalah pengungkapan tindakan pelanggaran atau pengungkapan perbuatan yang melawan hukum, perbuatan tidak etis/tidak bermoral atau perbuatan lain yang dapat merugikan organisasi maupun pemangku kepentingan yang dilakukan oleh pejabat/pegawai kepada pimpinan atau lembaga lain yang dapat mengambil tindakan atas pelanggaran tersebut.
                        </p>
                        <p>
                            Pelapor pelanggaran atau biasa disebut whistleblower adalah pejabat/pegawai di lingkungan Kementerian Perindustrian yang melaporkan pelanggaran berupa perbuatan yang melanggar peraturan perundang-undangan, kode etik, kebijakan dan tindakan lain yang sejenis berupa ancaman langsung atas kepentingan umum, serta Korupsi, Kolusi dan Nepotisme (KKN) yang terjadi di lingkungan Kementerian Perindustrian.
                        </p>
                        <p>
                            Hal tersebut diatas diatur melalui Peraturan Menteri Perindustrian Nomor 20/M-IND/PER/2/2015 tentang Pedoman Pelaksanaan Sistem Pelaporan Pelanggaran di Lingkungan Kementerian Perindustrian.
                        </p>
                    </div>

                    <div class="mt-8 rounded-lg border border-orange-200 bg-orange-50 p-4">
                        <p class="text-sm font-bold text-orange-800">
                            JIKA ANDA MENEMUKAN PELANGGARAN, LAPOR MELALUI <a href="#" class="text-orange-600 underline transition hover:text-orange-700">LINK INI</a>
                        </p>
                    </div>

                    <div class="mt-6 inline-block rounded-lg italic text-sm font-semibold text-orange-600">
                        F-FKAP-RLW
                    </div>
                </div>

                <div x-show="wbsTab === 'laporan'" style="display: none;">
                    <x-zona-integritas.document-table
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_BENTURAN_LAPORAN)"
                        empty-message="Belum ada laporan pelaksanaan WBS yang tersedia." />
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
