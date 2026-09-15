# Implementasi & Perbaikan Fitur Komplain Layanan pada Zona Integritas

Menambahkan opsi "Komplain Layanan" ke dalam modul Pengaduan Zona Integritas (`/zona-integritas?tab=pengaduan`), dengan formulir terpadu yang menyertakan kontak pelapor (`email` dan `telepon`), hanya meminta informasi relevan saat komplain dipilih, menyembunyikan input pelanggaran dan pihak terlapor, serta menyediakan opsi alternatif cepat melalui **Live Chat** di pojok kanan bawah layar dan tautan ke **WhatsApp Customer Service**.

---

## Catatan Keputusan Desain & Spesifikasi Terbaru

### 1. Petunjuk Kanal Alternatif (Live Chat & WhatsApp) Khusus Komplain
- **Kondisional**: Catatan hanya muncul ketika pengguna memilih opsi **"Komplain Layanan"** (`x-show="jenisPengaduan === 'komplain'"`).
- **Tampilan**: Berupa kotak informasi (callout note) yang sederhana, bersih, dan elegan di bawah dropdown jenis laporan.
- **Isi Petunjuk**:
  - **Live Chat**: Petunjuk tekstual bahwa masyarakat dapat menggunakan tombol Live Chat yang tersedia di pojok kanan bawah layar untuk konsultasi langsung.
  - **WhatsApp**: Tautan aktif menuju nomor WhatsApp CS BSPJI Banda Aceh (`https://api.whatsapp.com/send/?phone=%2B6281349735981&type=phone_number&app_absent=0`) tanpa template pesan (pesan kosong).

### 2. Dropdown Awal "Pilih Jenis Laporan"
- State Alpine.js diinisialisasi kosong `''` (`old('jenis_pengaduan', '')`), dengan opsi bawaan `<option value="">Pilih jenis laporan</option>`.
- Field **Jenis Pelanggaran** dan **Nama Yang Dilaporkan** hanya muncul apabila jenis pengaduan adalah `"pengaduan"` atau `"wbs"`. Saat form pertama kali dibuka atau saat memilih `"komplain"`, kedua field tersebut disembunyikan dan di-`disabled`.

### 3. Kamus Validasi Bahasa Indonesia & Error Handling
- Disediakan file kamus [lang/id/validation.php](file:///c:/laragon/www/bspji-1/lang/id/validation.php).
- Ditambahkan method `messages()` pada [StoreZonaIntegritasPengaduanRequest.php](file:///c:/laragon/www/bspji-1/app/Http/Requests/StoreZonaIntegritasPengaduanRequest.php) sehingga pesan error (seperti uraian minimal 10 karakter) berbunyi: *"Uraian laporan minimal harus berisi 10 karakter."* dan tidak memunculkan raw key `validation.min.string`.

### 4. Database & Filament Admin Panel
- Menggunakan kolom fisik database `jenis_pelanggan` (Opsi B) dan menambahkan `email` serta `telepon` (string, nullable).
- Filament Admin menampilkan kontak pelapor serta menyembunyikan field pelanggaran jika tipe laporan adalah komplain.

---

## User Review Required

> [!NOTE]
> Spesifikasi yang akan diimplementasikan pada Blade frontend:
> - Penambahan alert/callout box sederhana khusus saat `jenisPengaduan === 'komplain'`.
> - Teks: *"Butuh respon lebih cepat? Anda juga dapat menyampaikan komplain layanan secara langsung melalui tombol **Live Chat di pojok kanan bawah** atau chat via [WhatsApp CS BSPJI](https://api.whatsapp.com/send/?phone=%2B6281349735981&type=phone_number&app_absent=0)."*
> - Link WhatsApp membuka tab baru (`target="_blank" rel="noopener noreferrer"`).

---

## Proposed Changes

### Frontend Blade

#### [MODIFY] [section.blade.php](file:///c:/laragon/www/bspji-1/resources/views/components/zona-integritas/section.blade.php)
- Menambahkan komponen callout sederhana tepat setelah input dropdown `jenis_pengaduan`:
  ```blade
  <div x-show="jenisPengaduan === 'komplain'" x-cloak x-transition
      class="rounded-xl border border-emerald-200 bg-emerald-50/60 p-4 text-sm text-slate-700 md:col-span-2">
      <div class="flex items-start gap-3">
          <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600"></i>
          <p class="leading-relaxed">
              <span class="font-semibold text-slate-900">Butuh respon lebih cepat?</span>
              Selain formulir ini, Anda juga dapat menyampaikan komplain layanan secara langsung melalui tombol
              <span class="font-semibold text-slate-900">Live Chat</span> di pojok kanan bawah layar, atau chat langsung via
              <a href="https://api.whatsapp.com/send/?phone=%2B6281349735981&type=phone_number&app_absent=0"
                  target="_blank" rel="noopener noreferrer"
                  class="font-semibold text-emerald-700 underline decoration-emerald-400 underline-offset-2 transition hover:text-emerald-800">
                  WhatsApp (+62 813-4973-5981)
              </a>.
          </p>
      </div>
  </div>
  ```

---

## Verification Plan

### Automated Tests
- Menjalankan feature test yang sudah ada untuk memastikan seluruh aturan formulir dan submit data tidak mengalami regresi:
  ```powershell
  php vendor/bin/phpunit tests/Feature/ZonaIntegritasPengaduanTest.php
  ```

### Manual Verification
1. Buka `/zona-integritas?tab=pengaduan`.
2. Pastikan saat awal dibuka (belum memilih jenis laporan) callout petunjuk WhatsApp/Live Chat **tidak tampil**.
3. Pilih "Pengaduan Pelanggaran" atau "WBS": pastikan callout tetap **tidak tampil**.
4. Pilih "Komplain Layanan":
   - Pastikan callout informasi langsung muncul secara halus.
   - Periksa bahwa teks Live Chat mengarahkan ke tombol di pojok kanan bawah.
   - Klik link WhatsApp dan pastikan membuka tab baru menuju nomor CS BSPJI dengan pesan kosong.
