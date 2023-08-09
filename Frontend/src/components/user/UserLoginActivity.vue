<template>
  <apo-radial-progress-bar
    v-if="totalSteps > 0"
    class="user-login-activity"
    :diameter="circleDiameter"
    :completed-steps="completedSteps"
    :total-steps="totalSteps"
    :stroke-width="12"
    inner-stroke-color="#ffffff"
    start-color="#0d3493"
    stop-color="#0d3493"
    :title="$t('modules.user.loginActivity.yourLoginActivity', [activity])"
  />
</template>

<script>

import { mapGetters } from 'vuex';
import RadialProgressBar from '@/components/ui/RadialProgressBar.vue';

export default {
  components: {
    'apo-radial-progress-bar': RadialProgressBar,
  },

  data() {
    return {
      completedSteps: 0,
      totalSteps: 0,
    };
  },

  computed: {
    ...mapGetters(['currentViewport', 'loginActivity']),

    circleDiameter() {
      if (this.currentViewport === 'mobile') {
        return 230;
      }

      return 290;
    },

    activity() {
      return this.loginActivity ? this.loginActivity : 0;
    },
  },

  watch: {
    loginActivity: {
      immediate: true,
      handler(loginActivity) {
        this.totalSteps = 100;

        // Currently there is a workaround to enable a "forced" animation start,
        // by providing a timeout -> https://github.com/wyzant-dev/vue-radial-progress/issues/6
        setTimeout(() => {
          this.completedSteps = loginActivity;
        }, 1);
      },
    },
  },
};

</script>
