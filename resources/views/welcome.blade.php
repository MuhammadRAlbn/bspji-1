<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSPJI Banda Aceh - Mendorong Inovasi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="overflow-x-hidden bg-white text-gray-900 antialiased">
    <x-layouts.partials.navbar variant="transparent" />

    <main>
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

        <!-- WhatsApp CTA section -->
        <x-landing.whatsapp-cta />

        <!-- Certificate lightbox section -->
        <x-landing.certificate-lightbox />

        <!-- Certificates section -->
        <x-landing.certificates
            :certificate-bg-image="$certificateBgImage"
            :certificate-items="$certificateItems"
        />

        <!-- Company in numbers section -->
        <x-landing.company-numbers />

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
        <x-landing.faq :faq-display-images="$faqDisplayImages" />

        <!-- Latest news section -->
        <x-landing.latest-news
            :latest-news-items="$latestNewsItems"
            :berita-index-url="$beritaIndexUrl"
        />

        <!-- footer -->
        <x-layouts.partials.footer />
    </main>
</body>

</html>
