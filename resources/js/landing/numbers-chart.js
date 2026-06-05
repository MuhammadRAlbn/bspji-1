const chartConfigs = [
    {
        key: 'jumlah-pelanggan',
        labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'],
        values: [210, 255, 300, 360, 420, 490, 560],
        min: 0,
        max: 600,
        step: 50,
        color: '#f59e0b',
        stroke: '#d97706',
    },
    {
        key: 'spm',
        labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'],
        values: [80, 83, 86, 89, 92, 95, 98],
        min: 0,
        max: 100,
        step: 20,
        color: '#ef4444',
        stroke: '#dc2626',
    },
];

const svgNamespace = 'http://www.w3.org/2000/svg';

const formatChartTick = (value, maxValue) => {
    if (maxValue <= 4) {
        return Number.isInteger(value) ? String(value) : value.toFixed(1).replace('.', ',');
    }

    return new Intl.NumberFormat('id-ID').format(Math.round(value));
};

const createSvgElement = (tagName, attributes = {}) => {
    const element = document.createElementNS(svgNamespace, tagName);

    Object.entries(attributes).forEach(([key, value]) => {
        element.setAttribute(key, value);
    });

    return element;
};

const appendText = (parent, textContent, attributes) => {
    const text = createSvgElement('text', attributes);
    text.textContent = textContent;
    parent.append(text);
};

const renderBarChart = (container, config) => {
    if (!container || config.labels.length === 0) {
        return;
    }

    const svgWidth = 760;
    const svgHeight = 340;
    const margin = {
        top: 18,
        right: 16,
        bottom: config.labels.length > 10 ? 78 : 54,
        left: 54,
    };
    const plotWidth = svgWidth - margin.left - margin.right;
    const plotHeight = svgHeight - margin.top - margin.bottom;
    const plotBottom = margin.top + plotHeight;
    const slotWidth = plotWidth / config.labels.length;
    const barWidth = Math.max(10, Math.min(34, slotWidth * 0.58));
    const gradientId = `bar-gradient-${config.key}`;
    const denseLabels = config.labels.length > 10;

    const svg = createSvgElement('svg', {
        viewBox: `0 0 ${svgWidth} ${svgHeight}`,
        'aria-hidden': 'true',
        focusable: 'false',
    });
    const defs = createSvgElement('defs');
    const gradient = createSvgElement('linearGradient', {
        id: gradientId,
        x1: '0',
        y1: '0',
        x2: '0',
        y2: '1',
    });
    gradient.append(
        createSvgElement('stop', { offset: '0%', 'stop-color': config.color }),
        createSvgElement('stop', { offset: '100%', 'stop-color': config.stroke }),
    );
    defs.append(gradient);
    svg.append(defs);

    svg.append(
        createSvgElement('line', {
            x1: margin.left,
            y1: margin.top,
            x2: margin.left,
            y2: plotBottom,
            stroke: '#cbd5e1',
            'stroke-width': 1.2,
        }),
        createSvgElement('line', {
            x1: margin.left,
            y1: plotBottom,
            x2: margin.left + plotWidth,
            y2: plotBottom,
            stroke: '#cbd5e1',
            'stroke-width': 1.2,
        }),
    );

    for (let tick = config.min; tick <= config.max + config.step / 2; tick += config.step) {
        const tickValue = Number(tick.toFixed(4));
        const ratio = (tickValue - config.min) / (config.max - config.min || 1);
        const y = plotBottom - ratio * plotHeight;

        svg.append(createSvgElement('line', {
            x1: margin.left,
            y1: y,
            x2: margin.left + plotWidth,
            y2: y,
            stroke: '#e2e8f0',
            'stroke-width': 1,
        }));

        appendText(svg, formatChartTick(tickValue, config.max), {
            x: margin.left - 10,
            y: y + 4.5,
            'text-anchor': 'end',
            fill: '#64748b',
            'font-size': 13,
            'font-weight': 500,
        });
    }

    config.values.forEach((rawValue, index) => {
        const value = Math.max(config.min, Math.min(config.max, rawValue));
        const ratio = (value - config.min) / (config.max - config.min || 1);
        const barHeight = ratio * plotHeight;
        const xCenter = margin.left + slotWidth * index + slotWidth / 2;
        const x = xCenter - barWidth / 2;
        const y = plotBottom - barHeight;

        svg.append(createSvgElement('rect', {
            x: x,
            y: y,
            width: barWidth,
            height: barHeight,
            rx: 5,
            fill: `url(#${gradientId})`,
            stroke: config.stroke,
            'stroke-width': 1.2,
        }));

        const labelAttributes = {
            x: xCenter,
            y: denseLabels ? plotBottom + 24 : plotBottom + 22,
            'text-anchor': denseLabels ? 'end' : 'middle',
            fill: '#475569',
            'font-size': 13,
            'font-weight': 500,
        };

        if (denseLabels) {
            labelAttributes.transform = `rotate(-34 ${xCenter} ${plotBottom + 24})`;
        }

        appendText(svg, config.labels[index], labelAttributes);
    });

    container.replaceChildren(svg);
};

export function initNumbersCharts() {
    const chartConfigByKey = new Map(chartConfigs.map((config) => [config.key, config]));

    document.querySelectorAll('[data-numbers-chart]').forEach((container) => {
        const config = chartConfigByKey.get(container.dataset.numbersChart);

        if (config) {
            renderBarChart(container, config);
        }
    });
}
