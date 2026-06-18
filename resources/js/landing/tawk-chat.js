const TAWK_LOADER_SELECTOR = '[data-tawk-chat-loader]';

function scheduleAfterIdle(callback) {
    const run = () => {
        if ('requestIdleCallback' in window) {
            window.requestIdleCallback(callback, { timeout: 3000 });
            return;
        }

        window.setTimeout(callback, 1200);
    };

    if (document.readyState === 'complete') {
        run();
        return;
    }

    window.addEventListener('load', run, { once: true });
}

export function registerTawkChat() {
    const loader = document.querySelector(TAWK_LOADER_SELECTOR);

    if (!loader || window.__bspjiTawkLoaded) {
        return;
    }

    const { propertyId, widgetId } = loader.dataset;

    if (!propertyId || !widgetId) {
        return;
    }

    window.__bspjiTawkLoaded = true;

    scheduleAfterIdle(() => {
        window.Tawk_API = window.Tawk_API || {};
        window.Tawk_LoadStart = new Date();

        const script = document.createElement('script');
        const firstScript = document.getElementsByTagName('script')[0];

        script.async = true;
        script.src = `https://embed.tawk.to/${propertyId}/${widgetId}`;
        script.charset = 'UTF-8';
        script.setAttribute('crossorigin', 'anonymous');

        firstScript.parentNode.insertBefore(script, firstScript);
    });
}
