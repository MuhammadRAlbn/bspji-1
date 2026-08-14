<x-layouts.app
    title="BSPJI Banda Aceh - Mendorong Inovasi Industri"
    description="Balai Standardisasi dan Pelayanan Jasa Industri (BSPJI) Banda Aceh — mitra layanan teknis pengujian, kalibrasi, sertifikasi produk, dan konsultasi industri untuk meningkatkan daya saing."
    navbarVariant="transparent"
    bodyClass="overflow-x-hidden bg-white"
>
    @push('head')
        {{-- Open Graph --}}
        <meta property="og:type" content="website">
        <meta property="og:title" content="BSPJI Banda Aceh - Mendorong Inovasi Industri">
        <meta property="og:description" content="Mitra layanan teknis pengujian, kalibrasi, sertifikasi produk, dan konsultasi industri untuk meningkatkan daya saing.">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:locale" content="id_ID">
    @endpush

    <!-- Hero section -->
    <x-landing.hero />

    <!-- Profile section -->
    <x-landing.profile
        :profile-images="$profileImages"
        :sejarah-url="$sejarahUrl"
    />

    <!-- Sipintu showcase section -->
    <x-landing.sipintu-showcase
        :sipintu-desktop-image="$sipintuDesktopImage"
        :sipintu-mobile-image="$sipintuMobileImage"
    />

    <!-- Services section -->
    <x-landing.services
        :service-items="$serviceItems"
    />

    <!-- Customer logo section -->
    <x-landing.customer-logos
        :logo-items="$logoItems"
        :first-logo-group="$firstLogoGroup"
        :second-logo-group="$secondLogoGroup"
        :showcase-image="$showcaseImage"
    />

    
    <!-- Certificate lightbox section -->
    <x-landing.certificate-lightbox />
    
    <!-- Certificates section -->
    <x-landing.certificates
    :certificate-bg-image="$certificateBgImage"
    :certificate-items="$certificateItems"
    />
    
    <!-- WhatsApp CTA section -->
    <x-landing.whatsapp-cta />
    
    <!-- Company in numbers section -->
    <!-- <x-landing.company-numbers /> -->

    <!-- Testimonials section -->
    <x-landing.testimonials :testimonial-items="$testimonialItems" />

    <!-- Customer map section -->
    <x-landing.customer-map
        :customer-distribution="$customerDistribution"
        :customer-without-location="$customerWithoutLocation"
    />

    <!-- versi lama testimoni -->
    {{--
        Arsip section testimoni lama:
        <x-landing.testimoni-legacy :testimonis="$testimonis" />
    --}}

    <!-- Zona Integritas section -->
    <x-zona-integritas.section :show-content="false" />

    <!-- FAQ section -->
    <!-- <x-landing.faq :faq-display-images="$faqDisplayImages" /> -->

    <!-- Latest news section -->
    <x-landing.latest-news
        :latest-news-items="$latestNewsItems"
        :berita-index-url="$beritaIndexUrl"
    />
</x-layouts.app>
