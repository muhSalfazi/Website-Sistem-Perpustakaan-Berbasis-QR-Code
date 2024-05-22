import Chart from 'chart.js/auto';

try {
  window.Chart = Chart;
} catch (e) {}

export { Chart };
