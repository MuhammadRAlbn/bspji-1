@props([
    'faqDisplayImages',
])

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
                    <img src="{{ $faqDisplayImages[0] }}" x-show="currentImage === 1" class="absolute inset-0 h-full w-full object-cover" alt="FAQ 1" loading="lazy">
                    <img src="{{ $faqDisplayImages[1] }}" x-show="currentImage === 2" class="absolute inset-0 h-full w-full object-cover" alt="FAQ 2" loading="lazy">
                    <img src="{{ $faqDisplayImages[2] }}" x-show="currentImage === 3" class="absolute inset-0 h-full w-full object-cover" alt="FAQ 3" loading="lazy">
                    <img src="{{ $faqDisplayImages[3] }}" x-show="currentImage === 4" class="absolute inset-0 h-full w-full object-cover" alt="FAQ 4" loading="lazy">
                    <div class="absolute inset-0 bg-linear-to-t from-black/20 to-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</section>
