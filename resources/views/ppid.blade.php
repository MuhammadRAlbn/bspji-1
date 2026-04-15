<x-layouts.app title="PPID - BSPJI Banda Aceh" x-data="{ mobileMenuOpen: false }">
    @push('styles')
        <style>
            .nav-glass {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            }

            .btn-sipintu {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
                transition: all 0.3s ease;
            }

            .btn-sipintu:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
            }

            .nav-link {
                position: relative;
                transition: color 0.3s ease;
            }

            .nav-link::after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                bottom: -4px;
                left: 0;
                background-color: #f97316;
                transition: width 0.3s ease;
            }

            .nav-link:hover::after {
                width: 100%;
            }

            .nav-link:hover {
                color: #f97316;
            }
        </style>
    @endpush

    @php
        $heroImage = asset('images/ppid/gbrppid.webp');
        $structureImage = $ppid && $ppid->structure_image ? asset('storage/' . $ppid->structure_image) : null;
        $ppidPdf = $ppid && $ppid->pdf_file ? asset('storage/' . $ppid->pdf_file) : null;
    @endphp

    <section class="bg-slate-100 max-w-6xl mx-auto rounded-3xl pt-4 mt-6">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-7 pl-6">
                    <h1 class="text-4xl md:text-5xl tracking-tight text-slate-800 leading-relaxed md:leading-snug">
                        Pejabat Pengelola Informasi Dan Dokumentasi (PPID)
                    </h1>
                </div>

                <div class="md:col-span-5 flex justify-center">
                    <img src="{{ $heroImage }}" alt="Ilustrasi PPID" class="w-full max-w-md">
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-8">
        <div class="flex justify-center">
            @if($structureImage)
                <img src="{{ $structureImage }}" alt="Struktur PPID" class="w-[70%] h-auto rounded-2xl shadow-sm">
            @else
                <div
                    class="w-[70%] aspect-4/3 rounded-2xl bg-slate-100 border border-dashed border-slate-300 flex items-center justify-center">
                    <p class="text-slate-500 italic">Struktur PPID belum diunggah.</p>
                </div>
            @endif
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-12 py-12">
        <div class="text-slate-600 text-lg leading-relaxed space-y-8 text-justify">
            <p>
                <strong>Dasar Hukum</strong> <br>
                UUD 1945 Pasal 28 F menyebutkan bahwa setiap orang berhak untuk berkomunikasi dan memperoleh informasi
                untuk mengembangkan pribadi dan lingkungan sosialnya, serta berhak untuk mencari, memperoleh, memiliki,
                menyimpan, mengolah dan menyampaikan informasi dengan menggunakan segala jenis saluran yang tersedia.
            </p>
            <p>
                Undang-Undang Nomor 14 Tahun 2008 pasal 13 tentang Keterbukaan Informasi Publik, menyebutkan bahwa
                untuk mewujudkan pelayanan cepat, tepat, dan sederhana setiap Badan Publik wajib menunjuk Pejabat
                Pengelola Informasi dan Dokumentasi (PPID), membuat dan mengembangkan sistem penyediaan pelayanan
                informasi secara cepat, mudah, dan wajar sesuai petunjuk teknis standar layanan informasi publik yang
                berlaku secara nasional.
            </p>
            <p>
                <strong>Tugas dan Tanggung Jawab</strong> <br>
                Tugas dan tanggung jawab PPID berdasarkan Peraturan Pemerintah Nomor 61 Tahun 2010 tentang Pelaksanaan
                Undang Undang Nomor 14 tahun 2008 tentang Keterbukaan Informasi Publik, pasal 14 adalah :
            </p>
            <ul class="list-none space-y-3 pl-6">
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span>Penyediaan, penyimpanan, pendokumentasian, dan pengamanan informasi;</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span>Pelayanan Informasi Publik sesuai dengan aturan yang berlaku;</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span>Pelayanan Informasi Publik yang cepat, tepat, dan sederhana;</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span>Penetapan prosedur operasional dalam penyebarluasan Informasi Publik;</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span>Pengujian konsekuensi;</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span>Penetapan Informasi yang Dikecualikan yang telah habis jangka waktu pengecualiannya sebagai
                        Informasi Publik yang dapat diakses; dan</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span>Penetapan pertimbangan tertulis atas setiap kebijakan yang diambil untuk memenuhi hak setiap
                        orang atas Informasi Publik.</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span>PPID dapat menjalankan tugas dan tanggung jawabnya sesuai ketentuan peraturan
                        perundang-undangan mengenai kepegawaian.</span>
                </li>
            </ul>
            <p>
                Berdasarkan Peraturan Komisi Informasi No. 1 Tahun 2010 tentang Standar Layanan Informasi Publik, PPID
                bertanggung jawab mengkoordinasikan penyimpanan dan pendokumentasian seluruh Informasi Publik yang
                berada di Badan Publik antara lain:
            </p>
            <ul class="list-none space-y-5 pl-6">
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <div>
                        <span>Mengkoordinasikan pengumpulan seluruh Informasi Publik secara fisik dari setiap
                            unit/satuan kerja meliputi:</span>
                        <ul class="list-none mt-3 space-y-2 pl-6 text-slate-500 italic">
                            <li>- Informasi yang wajib disediakan dan diumumkan secara berkala;</li>
                            <li>- Informasi yang wajib tersedia setiap saat;</li>
                            <li>- Informasi terbuka lainnya yang diminta Pemohon Informasi Publik.</li>
                        </ul>
                    </div>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span>Mengkoordinasikan pendataan Informasi Publik yang dikuasai oleh setiap unit/satuan kerja di
                        Badan Publik dalam rangka pembuatan dan pemutakhiran Daftar Informasi Publik setelah
                        dimutakhirkan oleh pimpinan masing-masing unit/satuan kerja sekurang-kurangnya 1 (satu) kali
                        dalam sebulan;</span>
                </li>
                <li class="flex items-start gap-4">
                    <span class="text-orange-500 font-bold">&bull;</span>
                    <span>Mengkoordinasikan penyediaan dan pelayanan Informasi Publik melalui pengumuman (media yang
                        menjangkau seluruh pemangku kepentingan) dan/atau permohonan.</span>
                </li>
            </ul>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 pb-16">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 md:p-6">
            <h2 class="text-2xl font-bold text-slate-800 mb-4 md:mb-6">Dokumen PPID</h2>

            @if($ppidPdf)
                <iframe src="{{ $ppidPdf }}" class="w-full h-[70vh] md:h-[900px] border-0 rounded-2xl"
                    title="Dokumen PPID"></iframe>
            @else
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 py-16 text-center">
                    <p class="text-slate-500 italic">Dokumen PDF PPID belum diunggah dari admin panel.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>