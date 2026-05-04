<x-layouts.app title="Zona Integritas - BSPJI Banda Aceh">
    <x-zona-integritas.section
        :dokumens-by-kode="$zonaIntegritasDokumens"
        :grafik-ikms="$zonaIntegritasGrafikIkms"
        :initial-active="$initialActive" />

    @push('scripts')
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            });
        </script>
    @endpush
</x-layouts.app>
