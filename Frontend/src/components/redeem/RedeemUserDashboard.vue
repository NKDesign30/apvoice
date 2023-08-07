<template>
  <apo-user-dashboard>
    <template #notification>
      <apo-redeem-notification />
    </template>

    <template #head>
      <h2
        class="text-center text-white"
        v-html="$t('pages.redeem.headlines.redeemExpertPoints')"
      />
    </template>

    <!-- eslint-disable max-len -->
    <template #profile>
      <apo-survey-expert-points-count-up class="w-40 h-40 text-6xl tablet:w-72 tablet:h-72 tablet:text-9xl" />
    </template>
    <!-- eslint-enable max-len -->

    <template #body>
      <h3
        class="mb-6 text-3xl text-center text-white font-display tablet:text-5xl"
        v-text="$t('pages.redeem.headlines.expertPoints')"
      />
      <p
        class="container text-xl tablet:max-w-xl tablet:text-2xl border-2 border-blue-500"
        v-html="getPointHint"
      />
      <apo-button
        v-if="expertPoints >= 50 && !isPending"
        class="mt-12 text-yellow-500 button--naked shadow-hard-dark disabled"
        @click="exchange"
        v-text="$t('surveys.buttons.redeem')"
      >
        <apo-spinner
          v-if="isBusy"
          class="ml-4"
          size="small"
        />
      </apo-button>
    </template>
  </apo-user-dashboard>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex';
import UserDashboard from '@/components/ui/UserDashboard.vue';
import SurveyExpertPointsCountUp from '@/components/survey/SurveyExpertPointsCountUp.vue';
import RedeemNotification from '@/components/redeem/RedeemNotification.vue';
import { VOUCHERS_EXCHANGE_POINTS } from '@/store/types/action-types';

export default {
  components: {
    'apo-user-dashboard': UserDashboard,
    'apo-survey-expert-points-count-up': SurveyExpertPointsCountUp,
    'apo-redeem-notification': RedeemNotification,
  },

  data() {
    return {
      isBusy: false,
    };
  },

  computed: {
    ...mapState({
      settings: state => state.settings.settings,
    }),

    ...mapGetters(['expertPoints', 'language']),

    getPointHint() {
      if (!this.settings.showVoucher.is_available) {
        return this.$t(this.settings.showVoucher.message);
      }
      console.log('dashbd points',this.expertPoints )
      if (this.expertPoints < 50) {
        return this.$t('pages.redeem.hint.hasNotEnoughPoints', { points: parseInt(50 - this.expertPoints, 10) });
      }
      return this.$t('pages.redeem.hint.hasEnoughPoints');
    },

    isPending() {
      return !this.settings.showVoucher.is_available;
    },
  },

  methods: {
    ...mapActions([VOUCHERS_EXCHANGE_POINTS]),

    exchange() {
      this.isBusy = true;
      this[VOUCHERS_EXCHANGE_POINTS]()
        .finally(() => {
          this.isBusy = false;
        });
    },
  },
};

</script>

<style lang="scss" scoped>

/* Component Styles */

</style>
