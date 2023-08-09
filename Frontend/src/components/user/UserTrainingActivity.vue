<template>
  <apo-radial-progress-bar
    v-if="totalSteps > 0"
    class="user-training-activity"
    :diameter="circleDiameter"
    :completed-steps="completedSteps"
    :total-steps="totalSteps"
    :stroke-width="strokeWidth"
    inner-stroke-color="#ffffff"
    start-color="#0099ff"
    stop-color="#0099ff"
    :title="$t('modules.user.trainingActivity.yourTrainingActivity', [activity])"
  />
</template>

<script>

import { mapGetters } from 'vuex';
import RadialProgressBar from '@/components/ui/RadialProgressBar.vue';

export default {
  components: {
    'apo-radial-progress-bar': RadialProgressBar,
  },
  props: {
    strokeWidth: {
      type: Number,
      required: false,
      default: 22,
    },
    mobileCircleDiamter: {
      type: Number,
      required: false,
      default: 205,
    },
    circleDiamter: {
      type: Number,
      required: false,
      default: 265,
    },
  },

  data() {
    return {
      completedSteps: 0,
      totalSteps: 0,
    };
  },

  computed: {
    ...mapGetters(['currentViewport', 'trainingActivity']),

    circleDiameter() {
      if (this.currentViewport === 'mobile') {
        return this.mobileCircleDiamter;
      }

      return this.circleDiamter;
    },

    activity() {
      return this.trainingActivity ? this.trainingActivity.activity : 0;
    },
  },

  watch: {
    trainingActivity: {
      immediate: true,
      handler(trainingActivity) {
        this.totalSteps = trainingActivity.total;

        // Currently there is a workaround to enable a "forced" animation start,
        // by providing a timeout -> https://github.com/wyzant-dev/vue-radial-progress/issues/6
        setTimeout(() => {
          this.completedSteps = trainingActivity.completed;
        }, 1);
      },
    },
  },
};

</script>
