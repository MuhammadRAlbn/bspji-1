import L from 'leaflet';

const parseJsonScript = (root, selector, fallback) => {
    const element = root.querySelector(selector);

    if (!element?.textContent) {
        return fallback;
    }

    try {
        return JSON.parse(element.textContent);
    } catch {
        return fallback;
    }
};

const formatIndonesiaNumber = (value) => new Intl.NumberFormat('id-ID').format(value);

const markerColorByCustomerCount = (count) => {
    if (count >= 90) return '#c2410c';
    if (count >= 45) return '#ea580c';

    return '#fdba74';
};

const escapeHtml = (value) => String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');

const setTextContent = (root, key, value) => {
    const element = root.querySelector(`[data-customer-map-total="${key}"]`);

    if (element) {
        element.textContent = formatIndonesiaNumber(value);
    }
};

export function initCustomerMap() {
    const root = document.querySelector('[data-customer-map]');
    const mapContainer = root?.querySelector('[data-customer-map-canvas]');

    if (!mapContainer) {
        return;
    }

    const customerDistributionData = parseJsonScript(root, '[data-customer-map-data="distribution"]', []);
    const customerWithoutLocation = Number(parseJsonScript(root, '[data-customer-map-data="without-location"]', 0));
    const map = L.map(mapContainer, {
        scrollWheelZoom: false,
        zoomControl: true,
        minZoom: 4,
        maxZoom: 9,
    });

    const preferredBasemap = L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}',
        {
            attribution: 'Tiles &copy; Esri',
            maxZoom: 19,
        },
    );
    const fallbackBasemap = L.tileLayer(
        'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
        {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19,
        },
    );

    let hasSwitchedToFallback = false;
    preferredBasemap.on('tileerror', () => {
        if (hasSwitchedToFallback) {
            return;
        }

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
            fillOpacity: 0.9,
        }).bindTooltip(
            `<strong>${escapeHtml(point.region)}</strong><br>${formatIndonesiaNumber(point.customers)} pelanggan`,
            {
                className: 'customer-map-tooltip',
                direction: 'top',
                sticky: true,
                offset: [0, -9],
                opacity: 1,
            },
        ).addTo(map);
    });

    if (customerDistributionData.length > 0) {
        const mapBounds = L.latLngBounds(customerDistributionData.map((point) => [point.lat, point.lng]));
        map.fitBounds(mapBounds, { padding: [30, 30], maxZoom: 7 });
    } else {
        map.setView([4.6951, 96.8205], 8);
    }

    const totalCustomers = customerDistributionData.reduce((total, point) => total + point.customers, 0);

    setTextContent(root, 'customers', totalCustomers);
    setTextContent(root, 'coverage', customerDistributionData.length);
    setTextContent(root, 'without-location', customerWithoutLocation);
}
