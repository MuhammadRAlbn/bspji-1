@props([
    'dokumensByKode' => collect(),
    'grafikIkms' => collect(),
    'initialActive' => 'zona-integritas',
    'initialPengaduanTab' => 'masyarakat',
    'trackedPengaduan' => null,
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
    $initialPengaduanTab = in_array($initialPengaduanTab, ['masyarakat', 'laporan', 'lacak'], true) ? $initialPengaduanTab : 'masyarakat';
    $tabUrl = static fn (string $tab): string => Route::has('zona-integritas.index')
        ? route('zona-integritas.index', ['tab' => $tab])
        : url('/zona-integritas?tab=' . $tab);

    $benturanFormUrl = null;
    $gratifikasiFormUrl = null;
@endphp

<section id="zona-integritas" class="relative overflow-hidden border-y border-slate-300 bg-slate-50/80 mt-16 py-16 md:mt-24 md:pb-20 md:pt-8">
    <div class="pointer-events-none absolute inset-0 opacity-40"
        style="background-image: radial-gradient(#64748b20 0.8px, transparent 0.8px); background-size: 24px 24px;">
    </div>
    <div class="relative mx-auto max-w-6xl px-6 lg:px-0"
        @if ($showContent)
            x-data="{
                active: {{ Js::from($initialActive) }},
                ikmTab: 'grafik',
                pengaduanTab: {{ Js::from($initialPengaduanTab) }},
                benturanTab: 'benturan-kepentingan',
                gratifikasiTab: 'gratifikasi',
                wbsTab: 'wbs',
                showPengaduanSuccess: {{ Js::from(session()->has('pengaduan_success_nomor')) }},
                buktiDukungName: '',
                buktiDukungError: '',
                setActive(tab) {
                    this.active = tab;
                    const url = new URL(window.location.href);
                    url.searchParams.set('tab', tab);
                    window.history.replaceState({ tab }, '', url.toString());
                },
                handleBuktiDukungChange(event) {
                    const file = event.target.files[0] || null;
                    this.buktiDukungName = '';
                    this.buktiDukungError = '';

                    if (! file) {
                        return;
                    }

                    if (file.size > 5 * 1024 * 1024) {
                        this.buktiDukungError = 'Ukuran file melebihi batas maksimal 5 MB.';
                        event.target.value = '';
                        return;
                    }

                    this.buktiDukungName = file.name;
                }
            }"
        @endif>
        
        @if ($showContent)
            @if (session('pengaduan_success_nomor'))
                <div x-show="showPengaduanSuccess" x-cloak x-transition.opacity
                    class="fixed inset-0 z-100 flex items-center justify-center bg-slate-950/70 px-6 py-8">
                    <button type="button" class="absolute inset-0 cursor-default" @click="showPengaduanSuccess = false" aria-label="Tutup notifikasi"></button>

                    <div x-show="showPengaduanSuccess" x-transition
                        class="relative w-full max-w-lg overflow-hidden rounded-2xl border border-emerald-200 bg-white shadow-2xl">
                        <div class="bg-emerald-50 px-6 py-5">
                            <div class="flex items-start gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white">
                                    <i data-lucide="check" class="h-6 w-6"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold tracking-tight text-slate-950">Pengaduan berhasil dikirim</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">
                                        Catat nomor pengaduan ini agar memudahkan pelacakan pengaduan Anda.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-6">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-500">Nomor Pengaduan</p>
                            <div class="mt-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 font-mono text-2xl font-bold tracking-wide text-slate-950">
                                {{ session('pengaduan_success_nomor') }}
                            </div>

                            <button type="button" @click="showPengaduanSuccess = false"
                                class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-orange-600">
                                Saya Mengerti
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-8" data-aos="fade-right">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Kembali ke Beranda
                </a>
            </div>
        @endif

        <div class="mx-auto mb-14 max-w-2xl text-center" data-aos="fade-up">
            <div class="mb-2 flex items-center justify-center gap-2">
                <span class="text-[10px] text-orange-600">■</span>
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Komitmen Kami</span>
            </div>
            <h2 class="text-2xl font-semibold leading-[1.2] text-gray-900 md:text-[30px]">Zona Integritas</h2>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7 md:gap-5">
            @foreach ($menuItems as $item)
                @if ($showContent)
                    <button type="button"
                        @click="setActive('{{ $item['id'] }}')"
                        :class="active === '{{ $item['id'] }}' ? 'border-orange-300 bg-white shadow-md shadow-orange-100/50' : 'border-slate-300/60 bg-white/70 shadow-sm'"
                        class="group flex min-h-44 flex-col items-center justify-center gap-3 rounded-2xl border p-3 text-center transition-all duration-500 ease-out hover:border-slate-400/50 hover:bg-white hover:shadow-xl hover:shadow-slate-200/60"
                        data-aos="zoom-in">
                        <span class="flex h-28 w-28 items-center justify-center sm:h-32 sm:w-32">
                            <img src="{{ asset('images/icon-zona/' . $item['image']) }}" alt="{{ $item['label'] }}"
                                class="h-full w-full object-contain transition-transform duration-700 ease-out group-hover:scale-110">
                        </span>
                        <span class="text-sm font-semibold leading-tight text-slate-800">
                            {{ $item['label'] }}
                        </span>
                    </button>
                @else
                    <a href="{{ $tabUrl($item['id']) }}"
                        class="group flex min-h-44 flex-col items-center justify-center gap-3 rounded-2xl border border-slate-300/60 bg-white/70 p-3 text-center shadow-sm transition-all duration-500 ease-out hover:border-slate-400/50 hover:bg-white hover:shadow-xl hover:shadow-slate-200/60"
                        data-aos="zoom-in">
                        <span class="flex h-28 w-28 items-center justify-center sm:h-32 sm:w-32">
                            <img src="{{ asset('images/icon-zona/' . $item['image']) }}" alt="{{ $item['label'] }}"
                                class="h-full w-full object-contain transition-transform duration-700 ease-out group-hover:scale-110">
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
                <div class="mb-8 flex flex-wrap gap-3">
                    <button type="button" @click="pengaduanTab = 'masyarakat'"
                        :class="pengaduanTab === 'masyarakat' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        Pengaduan Masyarakat
                    </button>
                    <button type="button" @click="pengaduanTab = 'laporan'"
                        :class="pengaduanTab === 'laporan' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        Laporan Pelaksanaan
                    </button>
                    <button type="button" @click="pengaduanTab = 'lacak'"
                        :class="pengaduanTab === 'lacak' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border-slate-200'"
                        class="rounded-lg border px-5 py-2.5 text-sm font-semibold transition hover:border-orange-300">
                        Lacak Pengaduan
                    </button>
                </div>

                <div x-show="pengaduanTab === 'masyarakat'">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 bg-slate-950 px-6 py-6 text-white sm:px-8">
                            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                                <div>
                                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.28em] text-orange-300">Kanal Pengaduan</p>
                                    <h3 class="text-2xl font-semibold tracking-tight">Pengaduan Masyarakat</h3>
                                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                                        Laporkan pengaduan Anda melalui formulir ini. Nomor pengaduan akan dibuat otomatis setelah formulir dikirim.
                                    </p>
                                </div>
                                <div class="inline-flex w-fit items-center gap-2 rounded-lg border border-white/15 bg-white/10 px-4 py-2 text-sm font-semibold text-white">
                                    <i data-lucide="shield-check" class="h-4 w-4"></i>
                                    Aktif
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('zona-integritas.pengaduan.store') }}" enctype="multipart/form-data" class="space-y-6 p-6 sm:p-8">
                            @csrf

                            <div class="grid gap-5 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label for="nama_pengadu" class="text-sm font-semibold text-slate-700">Nama</label>
                                    <input id="nama_pengadu" type="text" name="nama"
                                        value="{{ old('nama') }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                        placeholder="Masukkan nama Anda" required>
                                    @error('nama')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="jenis_pengaduan" class="text-sm font-semibold text-slate-700">Jenis Pengaduan</label>
                                    <select id="jenis_pengaduan" name="jenis_pengaduan"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100" required>
                                        <option value="">Pilih jenis pengaduan</option>
                                        <option value="pengaduan" @selected(old('jenis_pengaduan') === 'pengaduan')>Pengaduan</option>
                                        <option value="wbs" @selected(old('jenis_pengaduan') === 'wbs')>WBS</option>
                                    </select>
                                    @error('jenis_pengaduan')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2 md:col-span-2">
                                    <label for="jenis_pelanggan" class="text-sm font-semibold text-slate-700">Jenis Pelanggaran</label>
                                    <select id="jenis_pelanggan" name="jenis_pelanggan"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100" required>
                                        <option value="">Pilih kategori pengaduan</option>
                                        <option value="pelanggaran-peraturan" @selected(old('jenis_pelanggan') === 'pelanggaran-peraturan')>Pelanggaran terhadap peraturan</option>
                                        <option value="penyalahgunaan-wewenang" @selected(old('jenis_pelanggan') === 'penyalahgunaan-wewenang')>Penyalahgunaan wewenang atau jabatan</option>
                                        <option value="pelanggaran-kode-etik" @selected(old('jenis_pelanggan') === 'pelanggaran-kode-etik')>Pelanggaran kode etik</option>
                                        <option value="membahayakan-k3-keamanan-organisasi" @selected(old('jenis_pelanggan') === 'membahayakan-k3-keamanan-organisasi')>Perbuatan yang membahayakan K3 atau keamanan organisasi</option>
                                        <option value="kerugian-kemenperin-bspji" @selected(old('jenis_pelanggan') === 'kerugian-kemenperin-bspji')>Perbuatan yang dapat menimbulkan kerugian Kemenperin/BSPJI Banda Aceh</option>
                                        <option value="pelanggaran-sop" @selected(old('jenis_pelanggan') === 'pelanggaran-sop')>Pelanggaran terhadap SOP</option>
                                    </select>
                                    @error('jenis_pelanggan')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="nama_dilaporkan" class="text-sm font-semibold text-slate-700">Nama Yang Dilaporkan</label>
                                    <input id="nama_dilaporkan" type="text" name="nama_dilaporkan"
                                        value="{{ old('nama_dilaporkan') }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                        placeholder="Masukkan nama pihak yang dilaporkan" required>
                                    @error('nama_dilaporkan')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="judul_pengaduan" class="text-sm font-semibold text-slate-700">Judul</label>
                                    <input id="judul_pengaduan" type="text" name="judul"
                                        value="{{ old('judul') }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                        placeholder="Ringkasan singkat pengaduan" required>
                                    @error('judul')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="uraian_pengaduan" class="text-sm font-semibold text-slate-700">Uraian Pengaduan</label>
                                <textarea id="uraian_pengaduan" name="uraian" rows="6"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                    placeholder="Tuliskan kronologi, waktu kejadian, lokasi, dan informasi pendukung lainnya" required>{{ old('uraian') }}</textarea>
                                @error('uraian')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="bukti_dukung" class="text-sm font-semibold text-slate-700">Upload Bukti Dukung</label>
                                <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5 transition hover:border-orange-300 hover:bg-orange-50/40">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                        <div class="grow">
                                            <input id="bukti_dukung" type="file" name="bukti_dukung" @change="handleBuktiDukungChange($event)"
                                                class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-orange-600">
                                            <p class="mt-2 text-xs font-medium text-slate-500">Maksimal ukuran file 5 MB. Format: PDF, JPG, JPEG, atau PNG.</p>
                                            <p x-show="buktiDukungName" x-cloak class="mt-2 inline-flex items-center gap-2 rounded-lg bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700">
                                                <i data-lucide="check-circle" class="h-4 w-4"></i>
                                                <span>File siap diunggah: <span x-text="buktiDukungName"></span></span>
                                            </p>
                                            <p x-show="buktiDukungError" x-cloak class="mt-2 inline-flex items-center gap-2 rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700">
                                                <i data-lucide="alert-circle" class="h-4 w-4"></i>
                                                <span x-text="buktiDukungError"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @error('bukti_dukung')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="hidden" aria-hidden="true">
                                <label for="website_pengaduan">Website</label>
                                <input id="website_pengaduan" type="text" name="website" value="" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="flex flex-col gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:items-center sm:justify-between">
                                <button type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-orange-500 px-6 py-3 text-sm font-bold text-white shadow-md shadow-orange-100 transition hover:bg-orange-600 active:scale-[0.99] sm:w-auto">
                                    <i data-lucide="send" class="h-4 w-4"></i>
                                    Kirim
                                </button>
                                <p class="text-center text-sm font-semibold italic text-orange-600 sm:text-right">F-FKAP-LPPM</p>
                            </div>
                        </form>
                    </div>
                </div>

                <div x-show="pengaduanTab === 'laporan'" style="display: none;">
                    <x-zona-integritas.document-table
                        :documents="$documentList(ZonaIntegritasJenisDokumen::KODE_PENGADUAN_LAPORAN)"
                        empty-message="Belum ada laporan pelaksanaan Pengaduan yang tersedia." />
                </div>

                <div x-show="pengaduanTab === 'lacak'" style="display: none;">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        <div class="mb-6">
                            <p class="mb-2 text-xs font-bold uppercase tracking-[0.28em] text-orange-600">Pelacakan</p>
                            <h3 class="text-2xl font-semibold tracking-tight text-slate-950">Lacak Pengaduan</h3>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600">
                                Fitur pelacakan belum terhubung ke sistem. Tampilan ini disiapkan untuk alur pelacakan pengaduan berikutnya.
                            </p>
                        </div>

                        <form method="GET" action="{{ route('zona-integritas.index') }}" class="grid gap-4 md:grid-cols-[1fr_auto] md:items-end">
                            <input type="hidden" name="tab" value="pengaduan">
                            <div class="space-y-2">
                                <label for="lacak_nomor_pengaduan" class="text-sm font-semibold text-slate-700">Nomor Pengaduan</label>
                                <input id="lacak_nomor_pengaduan" type="text" name="lacak_nomor"
                                    value="{{ request('lacak_nomor') }}"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 font-mono text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                                    placeholder="Contoh: 20260500001">
                            </div>
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-6 py-3 text-sm font-bold text-white transition hover:bg-orange-600">
                                <i data-lucide="search" class="h-4 w-4"></i>
                                Lacak
                            </button>
                        </form>

                        @if (request()->filled('lacak_nomor'))
                            <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 p-5">
                                @if ($trackedPengaduan)
                                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-500">Nomor Pengaduan</p>
                                            <h4 class="mt-2 font-mono text-xl font-bold text-slate-950">{{ $trackedPengaduan->nomor_pengaduan }}</h4>
                                            <p class="mt-3 text-sm font-semibold text-slate-700">{{ $trackedPengaduan->judul }}</p>
                                        </div>
                                        <span class="inline-flex w-fit rounded-full bg-orange-100 px-4 py-2 text-sm font-bold text-orange-700">
                                            {{ $trackedPengaduan->status_label }}
                                        </span>
                                    </div>

                                    @if ($trackedPengaduan->hasil_teks || $trackedPengaduan->dokumen_hasil_path)
                                        <div class="mt-5 border-t border-slate-200 pt-5">
                                            @if ($trackedPengaduan->hasil_teks)
                                                <p class="whitespace-pre-line text-sm leading-6 text-slate-700">{{ $trackedPengaduan->hasil_teks }}</p>
                                            @endif

                                            @if ($trackedPengaduan->dokumen_hasil_path)
                                                <a href="{{ route('zona-integritas.pengaduan.hasil.download', $trackedPengaduan->nomor_pengaduan) }}"
                                                    class="mt-4 inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-600">
                                                    <i data-lucide="download" class="h-4 w-4"></i>
                                                    Download Dokumen Hasil
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <p class="text-sm font-medium text-slate-600">Nomor pengaduan tidak ditemukan. Pastikan nomor yang dimasukkan sudah benar.</p>
                                @endif
                            </div>
                        @endif
                    </div>
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
