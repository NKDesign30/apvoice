<template>
  <div class="text-media-paragraph__media-slot--chart">
    <div class="chart-container mb-3">
      <apo-bar-char
        v-if="isContentVisible"
        :chartdata="chartdata"
        :options="options"
      />
    </div>
  </div>
</template>

<script>

import get from 'lodash/get';
import map from 'lodash/map';
import { Chart } from 'chart.js';
// eslint-disable-next-line no-unused-vars
import ChartDataLabels from 'chartjs-plugin-datalabels';
import Bar from '@/components/charts/Bar.vue';
import { hexToRgb, colorBrightness } from '@/services/utils';

const tailwindColors = require('../../../../tailwind/Colors');

export default {
  components: {
    'apo-bar-char': Bar,
  },

  inject: {
    pageIndicatorState: {
      default: null,
    },
  },

  props: {
    media: {
      type: Array,
      required: false,
      default() {
        return [];
      },
    },
  },

  data() {
    return {
      options: {
        legend: {
          display: false,
        },

        tooltips: {
          enabled: false,
        },

        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
            },
          }],
        },

        layout: {
          padding: {
            top: 25,
          },
        },

        maintainAspectRatio: false,

        animation: {
          onProgress() {
            const chartInstance = this.chart;
            const { ctx } = chartInstance;

            // Create Font String
            ctx.font = Chart.helpers.fontString(
              Chart.defaults.global.defaultFontSize,
              Chart.defaults.global.defaultFontStyle,
              Chart.defaults.global.defaultFontFamily,
            );
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';

            // Iterate over all bars
            this.data.datasets.forEach((dataset, datasetIndex) => {
              const meta = chartInstance.controller.getDatasetMeta(datasetIndex);

              meta.data.forEach((bar, barIndex) => {
                // Check if the bar has a value (i.e. is not hidden)
                if (dataset.data[barIndex] !== '' && dataset.data[barIndex] > 0) {
                  // Check if the bar has a custom label and draw it
                  const customLabel = dataset.customLabels[barIndex];

                  if (customLabel && customLabel !== '' && customLabel.length > 0) {
                    // eslint-disable-next-line no-underscore-dangle
                    ctx.fillText(customLabel, bar._model.x, bar._model.y - 5);
                  }
                }
              });
            });
          },
        },
      },
    };
  },

  computed: {
    chartdata() {
      return {
        labels: this.getLabels(this.media),
        datasets: this.getDatasets(this.media),
      };
    },

    isContentVisible() {
      if (this.pageIndicatorState === null) {
        return true;
      }

      return this.pageIndicatorState.isOpen;
    },
  },

  methods: {
    getLabels(media) {
      return map(media, 'description');
    },

    getDatasets(media) {
      const datasets = [];

      media.forEach((data, datasetIndex) => {
        data.bars.forEach((bar, barIndex) => {
          if (!datasets[barIndex]) {
            const { red, green, blue } = hexToRgb(this.getTailwindColor(bar.color));
            const brightness = colorBrightness(red, green, blue);
            const color = brightness < 123 ? '#ffffff' : '#000000';

            datasets[barIndex] = {
              label: '',
              data: [],
              backgroundColor: [],
              datalabels: {
                align: 'center',
                anchor: 'center',
                color,
              },
              customLabels: [],
            };
          }

          datasets[barIndex].data[datasetIndex] = parseFloat(bar.value);
          datasets[barIndex].backgroundColor[datasetIndex] = this.getTailwindColor(bar.color);
          datasets[barIndex].customLabels[datasetIndex] = bar.label || '';
        });
      });

      datasets.forEach((dataset, datasetIndex) => {
        for (let i = 0; i < media.length; i += 1) {
          if (datasets[datasetIndex].data[i] === undefined) {
            datasets[datasetIndex].data[i] = '';
            datasets[datasetIndex].backgroundColor[i] = 'transparent';
          }
        }
      });

      return datasets;
    },

    getTailwindColor(color) {
      return get(tailwindColors, color.replace(/-/, '.'));
    },
  },
};
</script>

<style lang="scss" scoped>

.chart-container {
  max-height: calc(theme('spacing.72') * 2);
}

</style>
