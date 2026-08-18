# Mengubah Ukuran Jarak (Gap) Navigasi Group di Sidebar

Dokumen ini menjelaskan cara memperpendek atau merapatkan jarak antar grup navigasi pada sidebar Filament Panel yang telah diimplementasikan.

## Masalah
Secara default, Filament memiliki jarak (gap) yang cukup lebar antar grup navigasi di sidebar. Untuk tampilan yang lebih ringkas (compact), jarak ini perlu diperkecil.

## Solusi
Menggunakan `renderHook` pada `AdminPanelProvider` untuk menyuntikkan CSS kustom ke bagian `<head>` aplikasi.

### Lokasi File
[AdminPanelProvider.php](file:///c:/laragon/www/bspji-1/app/Providers/Filament/AdminPanelProvider.php)

### Kode Implementasi
Di dalam metode `panel()`, tambahkan kode berikut:

```php
use Illuminate\Support\HtmlString;
use Filament\View\PanelsRenderHook;

// ...

->renderHook(
    PanelsRenderHook::HEAD_END,
    fn (): string => new HtmlString('
        <style>
            /* Mengatur jarak antar grup navigasi */
            .fi-sidebar-nav-groups {
                gap: 0.25rem !important;
            }
            /* Menghilangkan margin default dan mengatur margin bawah yang lebih rapat */
            .fi-sidebar-group {
                margin-top: 0 !important;
                margin-bottom: 0.25rem !important;
            }
        </style>
    '),
);
```

## Penjelasan Teknis
1.  **`.fi-sidebar-nav-groups`**: Kelas container yang membungkus grup-grup navigasi. Properti `gap` mengatur jarak antar elemen di dalamnya.
2.  **`.fi-sidebar-group`**: Kelas untuk setiap blok grup navigasi. Mengatur `margin-top` dan `margin-bottom` membantu merapatkan teks label grup dengan item di bawah/atasnya.
3.  **`!important`**: Digunakan untuk memastikan style kustom ini menimpa (override) style bawaan dari Tailwind/Filament.
4.  **`PanelsRenderHook::HEAD_END`**: Hook ini memastikan CSS disisipkan tepat sebelum tag `</head>` ditutup.

---
*Catatan: Jika ingin merubah jarak lagi di masa depan, cukup ubah nilai `0.25rem` pada file AdminPanelProvider.php tersebut.*
