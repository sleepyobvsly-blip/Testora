import Chart from 'chart.js/auto';

window.Chart = Chart;

import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// SENTRA SENTIMENT DISTRIBUTION CHART

document.addEventListener('DOMContentLoaded', function () {

    const chartCanvas = document.getElementById('sentimentChart');

    if (!chartCanvas) {
        return;
    }

    const positive = Number(chartCanvas.dataset.positive);
    const neutral = Number(chartCanvas.dataset.neutral);
    const negative = Number(chartCanvas.dataset.negative);

    new Chart(chartCanvas, {
        type: 'doughnut',

        data: {
            labels: ['Positive', 'Neutral', 'Negative'],

            datasets: [{
                data: [positive, neutral, negative],
                backgroundColor: [
                    '#20a779',
                    '#e0a43b',
                    '#e05b68'
                ],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',

            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

});