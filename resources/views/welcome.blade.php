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
        <x-landing.customer-map />

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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const certificateLightbox = document.getElementById('certificateLightbox');
            const certificateLightboxImage = document.getElementById('certificateLightboxImage');
            const certificateLightboxTitle = document.getElementById('certificateLightboxTitle');
            const certificateLightboxClose = document.getElementById('certificateLightboxClose');
            const certificateLightboxBackdrop = document.getElementById('certificateLightboxBackdrop');
            const certificateTriggers = document.querySelectorAll('[data-certificate-trigger]');

            if (certificateLightbox && certificateLightboxImage && certificateLightboxTitle) {
                const defaultImageClasses = 'h-auto max-h-[92vh] w-auto max-w-[96vw] object-contain';
                const compactImageClasses = 'h-auto max-h-[78vh] w-auto max-w-[80vw] object-contain';

                const openCertificateLightbox = (imageSrc, imageTitle, imageAlt, variant) => {
                    certificateLightboxImage.src = imageSrc;
                    certificateLightboxImage.alt = imageAlt || imageTitle || 'Sertifikat';
                    certificateLightboxTitle.textContent = imageTitle || 'Sertifikat';
                    certificateLightboxImage.className = variant === 'compact' ? compactImageClasses : defaultImageClasses;
                    certificateLightbox.classList.remove('hidden');
                    certificateLightbox.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('overflow-hidden');
                };
                const closeCertificateLightbox = () => {
                    certificateLightbox.classList.add('hidden');
                    certificateLightbox.setAttribute('aria-hidden', 'true');
                    certificateLightboxImage.src = '';
                    certificateLightboxImage.alt = '';
                    certificateLightboxImage.className = defaultImageClasses;
                    document.body.classList.remove('overflow-hidden');
                };
                certificateTriggers.forEach((trigger) => {
                    trigger.addEventListener('click', () => {
                        const variant = trigger.dataset.certificateVariant || '';
                        openCertificateLightbox(trigger.dataset.src, trigger.dataset.title, trigger.querySelector('img')?.alt, variant);
                    });
                });
                certificateLightboxClose?.addEventListener('click', closeCertificateLightbox);
                certificateLightboxBackdrop?.addEventListener('click', closeCertificateLightbox);
            }

            const customerDistributionData = @json($customerDistribution ?? []);
            const customerWithoutLocation = Number(@json($customerWithoutLocation ?? 0));

            const formatIndonesiaNumber = (value) => new Intl.NumberFormat('id-ID').format(value);
            const markerColorByCustomerCount = (count) => {
                if (count >= 90) return '#c2410c';
                if (count >= 45) return '#ea580c';
                return '#fdba74';
            };

            const mapContainer = document.getElementById('customer-distribution-map');
            if (mapContainer && typeof L !== 'undefined') {
                const map = L.map(mapContainer, {
                    scrollWheelZoom: false,
                    zoomControl: true,
                    minZoom: 4,
                    maxZoom: 9
                });

                const preferredBasemap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Tiles &copy; Esri',
                    maxZoom: 19
                });
                const fallbackBasemap = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 19
                });

                let hasSwitchedToFallback = false;
                preferredBasemap.on('tileerror', () => {
                    if (hasSwitchedToFallback) return;
                    hasSwitchedToFallback = true;
                    if (map.hasLayer(preferredBasemap)) {
                        map.removeLayer(preferredBasemap);
                    }
                    fallbackBasemap.addTo(map);
                });
                preferredBasemap.addTo(map);

                customerDistributionData.forEach((point) => {
                    L.circleMarker([point.lat, point.lng], {
                        radius: Math.max(7, Math.min(18, 7 + (point.customers / 18))),
                        weight: 1.4,
                        color: '#ffffff',
                        fillColor: markerColorByCustomerCount(point.customers),
                        fillOpacity: 0.9
                    }).bindTooltip(
                        `<strong>${point.region}</strong><br>${formatIndonesiaNumber(point.customers)} pelanggan`,
                        {
                            className: 'customer-map-tooltip',
                            direction: 'top',
                            sticky: true,
                            offset: [0, -9],
                            opacity: 1
                        }
                    ).addTo(map);
                });

                if (customerDistributionData.length > 0) {
                    const mapBounds = L.latLngBounds(customerDistributionData.map((point) => [point.lat, point.lng]));
                    map.fitBounds(mapBounds, { padding: [30, 30], maxZoom: 7 });
                } else {
                    map.setView([4.6951, 96.8205], 8);
                }

                const totalCustomers = customerDistributionData.reduce((total, point) => total + point.customers, 0);
                const totalCoverage = customerDistributionData.length;
                const totalCustomersElement = document.getElementById('map-total-customers');
                const totalCoverageElement = document.getElementById('map-total-coverage');
                const totalNoLocationElement = document.getElementById('map-total-no-location');
                if (totalCustomersElement) totalCustomersElement.textContent = formatIndonesiaNumber(totalCustomers);
                if (totalCoverageElement) totalCoverageElement.textContent = formatIndonesiaNumber(totalCoverage);
                if (totalNoLocationElement) totalNoLocationElement.textContent = formatIndonesiaNumber(customerWithoutLocation);
            }

            const formatChartTick = (value, maxValue) => {
                if (maxValue <= 4) {
                    return Number.isInteger(value) ? String(value) : value.toFixed(1).replace('.', ',');
                }
                return new Intl.NumberFormat('id-ID').format(Math.round(value));
            };

            const renderBarChart = (config) => {
                const container = document.getElementById(config.targetId);
                if (!container) return;

                const svgWidth = 760;
                const svgHeight = 340;
                const margin = {
                    top: 18,
                    right: 16,
                    bottom: config.labels.length > 10 ? 78 : 54,
                    left: 54
                };
                const plotWidth = svgWidth - margin.left - margin.right;
                const plotHeight = svgHeight - margin.top - margin.bottom;
                const plotBottom = margin.top + plotHeight;
                const slotWidth = plotWidth / config.labels.length;
                const barWidth = Math.max(10, Math.min(34, slotWidth * 0.58));
                const gradientId = `bar-gradient-${config.targetId}`;
                const denseLabels = config.labels.length > 10;

                const ticks = [];
                for (let tick = config.min; tick <= config.max + config.step / 2; tick += config.step) {
                    ticks.push(Number(tick.toFixed(4)));
                }

                const tickMarkup = ticks.map((tickValue) => {
                    const ratio = (tickValue - config.min) / (config.max - config.min || 1);
                    const y = plotBottom - ratio * plotHeight;
                    return `
                        <line x1="${margin.left}" y1="${y}" x2="${margin.left + plotWidth}" y2="${y}" stroke="#e2e8f0" stroke-width="1" />
                        <text x="${margin.left - 10}" y="${y + 4.5}" text-anchor="end" fill="#64748b" font-size="13" font-weight="500">${formatChartTick(tickValue, config.max)}</text>
                    `;
                }).join('');

                const barMarkup = config.values.map((rawValue, index) => {
                    const value = Math.max(config.min, Math.min(config.max, rawValue));
                    const ratio = (value - config.min) / (config.max - config.min || 1);
                    const barHeight = ratio * plotHeight;
                    const xCenter = margin.left + slotWidth * index + slotWidth / 2;
                    const x = xCenter - barWidth / 2;
                    const y = plotBottom - barHeight;
                    const xLabel = denseLabels
                        ? `<text x="${xCenter}" y="${plotBottom + 24}" transform="rotate(-34 ${xCenter} ${plotBottom + 24})" text-anchor="end" fill="#475569" font-size="13" font-weight="500">${config.labels[index]}</text>`
                        : `<text x="${xCenter}" y="${plotBottom + 22}" text-anchor="middle" fill="#475569" font-size="13" font-weight="500">${config.labels[index]}</text>`;
                    return `
                        <rect x="${x}" y="${y}" width="${barWidth}" height="${barHeight}" rx="5" fill="url(#${gradientId})" stroke="${config.stroke}" stroke-width="1.2" />
                        ${xLabel}
                    `;
                }).join('');

                container.innerHTML = `
                    <svg viewBox="0 0 ${svgWidth} ${svgHeight}" aria-hidden="true" focusable="false">
                        <defs>
                            <linearGradient id="${gradientId}" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="${config.color}" />
                                <stop offset="100%" stop-color="${config.stroke}" />
                            </linearGradient>
                        </defs>
                        <line x1="${margin.left}" y1="${margin.top}" x2="${margin.left}" y2="${plotBottom}" stroke="#cbd5e1" stroke-width="1.2" />
                        <line x1="${margin.left}" y1="${plotBottom}" x2="${margin.left + plotWidth}" y2="${plotBottom}" stroke="#cbd5e1" stroke-width="1.2" />
                        ${tickMarkup}
                        ${barMarkup}
                    </svg>
                `;
            };

            [
                // { targetId: 'chart-spkp', labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'], values: [3.1, 3.2, 3.3, 3.4, 3.5, 3.6, 3.7], min: 0, max: 4, step: 0.5, color: '#3b82f6', stroke: '#2563eb' },
                // { targetId: 'chart-anti-korupsi', labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'], values: [3.0, 3.2, 3.3, 3.4, 3.6, 3.7, 3.8], min: 0, max: 4, step: 0.5, color: '#10b981', stroke: '#059669' },
                { targetId: 'chart-jumlah-pelanggan', labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'], values: [210, 255, 300, 360, 420, 490, 560], min: 0, max: 600, step: 50, color: '#f59e0b', stroke: '#d97706' },
                { targetId: 'chart-spm', labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'], values: [80, 83, 86, 89, 92, 95, 98], min: 0, max: 100, step: 20, color: '#ef4444', stroke: '#dc2626' }
            ].forEach(renderBarChart);
        });
    </script>
</body>

</html>
