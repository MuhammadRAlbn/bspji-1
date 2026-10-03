# Rencana Teknis: Riwayat Penghapusan Pengaduan

Acuan: [spec.md](spec.md). Rencana disusun sebelum implementasi. Implementasi selesai; suite proyek lulus 306 test (2.248 assertion). Hasil dan batasnya pada [verification.md](verification.md).

## 1. Data

Tambahkan migration baru pada tabel zona_integritas_pengaduans: deleted_at berindeks, deletion_reason nullable text, deleted_by_id nullable unsigned bigint berindeks, deleted_by_name dan deleted_by_email nullable string. Gunakan SoftDeletes pada model. Field penghapusan tidak masuk fillable.

Tidak diperlukan salinan laporan atau tabel audit terpisah karena satu pengaduan hanya dapat dihapus sekali dan tidak dapat dipulihkan. Record terhapus menjadi sumber data riwayat. deleted_by_id adalah snapshot ID tanpa foreign key/cascade agar penghapusan akun tidak mengubah attribution. Nama/email disimpan sebagai snapshot, tidak dibaca dari relasi User.

## 2. Service dan model

ZonaIntegritasPengaduanDeletionService membaca ulang dan mengunci actor lalu record dalam transaksi, memeriksa policy delete, menormalisasi/memvalidasi alasan, menyimpan snapshot actor, kemudian soft delete. Payload hanya memasok deletion_reason. Save/delete yang gagal membatalkan transaksi. File tidak disentuh.

Model menolak save pada record yang sudah terhapus, restore, force delete, dan delete tanpa metadata lengkap/status Ditolak. Normal query pada follow-up service tetap mengecualikan record terhapus sebelum file disimpan. Batas model event tidak diklaim melindungi raw SQL/query yang sengaja melewati event.

## 3. Filament dan otorisasi

DeletePengaduanAction berbagi dialog/form/service untuk aksi tabel dan header edit. Hapus DeleteBulkAction. Policy delete menambahkan syarat Ditolak dan belum terhapus; deleteAny false. view/update biasa menolak record terhapus. Tambahkan viewHistoryAny/viewHistory khusus admin aktif dan Kepala Balai aktif; restore/force delete tetap false.

Resource RiwayatPenghapusanPengaduan memakai model yang sama dengan onlyTrashed dan hanya halaman index/view. Gunakan infolist laporan existing bersama bagian catatan penghapusan. Tidak ada route edit maupun aksi mutasi. Kedua halaman memakai RechecksPanelAccess. Tambahkan izin history secara terbatas di Gate::before serta middleware route staf; FAP tetap tidak mendapat resource history.

## 4. Lampiran dan publik

Pertahankan binding/query existing yang mengecualikan record terhapus. Tambahkan endpoint riwayat terpisah, auth + EnsureCurrentAccountSession, binding withTrashed, validasi record memang terhapus, dan Gate viewHistory. Jenis dokumen dibatasi bukti/hasil; path ditentukan dari record server. Infolist memilih endpoint riwayat hanya untuk record terhapus. Tidak ada perubahan public storage atau URL hasil pengaduan aktif.

## 5. Pengujian dan aktivasi

Tulis test penerimaan service/policy, dialog daftar/header, role URL/Livewire, immutability, transaksi gagal, actor/status stale, lampiran, dan pelacakan publik sebelum perubahan implementasi. Jalankan test fokus, Pint, serta suite proyek untuk regresi gate/middleware/resource. Periksa UI dengan data uji terpisah bila runtime preview tersedia.

Test memakai SQLite in-memory sesuai phpunit.xml. Preview UI memakai SQLite, akun dummy, sesi, dan file terpisah; .env aplikasi tidak diubah. Setelah test fokus, migration tambahan diterapkan pada MySQL development lokal (APP_ENV=local, host loopback), sehingga aplikasi lokal dapat memakai fitur. Tidak ada pengaduan atau akun operasional yang dihapus. Lingkungan lain mengikuti [deployment.md](deployment.md). Tidak menjalankan rollback pada data operasional karena down menghilangkan metadata histori. Perbarui dokumen fitur 001 yang terdampak, checklist, deployment, serta verification dengan hasil nyata.
