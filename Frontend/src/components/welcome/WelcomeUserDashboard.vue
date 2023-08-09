<template>
  <apo-user-dashboard>
    <template #head>
      <h1
        class="text-3xl tablet:text-6xl font-bold"
        v-text="$t('general.hello', {name: fullName })"
      />
    </template>

    <!-- eslint-disable max-len -->
    <template #body>
      <div class="flex flex-col tablet:flex-row justify-center">
        <div class="welcome-page__expert-points flex justify-center tablet:justify-end tablet:w-1/2 w-full">
          <apo-survey-expert-points-count-up class="w-20 h-20 tablet:w-30 tablet:h-30 text-3xl tablet:text-5xl" />
          <div class="ml-10 flex flex-col justify-between text-left">
            <h2
              class="headline-3 text-3xl mb-4"
              v-text="$t('surveys.headlines.expertPoints')"
            />
            <router-link
              class="button--naked shadow-hard-dark text-yellow-500"
              tag="apo-button"
              :to="{ name: 'redeem' }"
              v-text="$t('surveys.buttons.redeem')"
            />
          </div>
        </div>

        <div class="welcome-page__training-activity flex justify-center ml-0 mt-10 tablet:justify-start tablet:ml-16 tablet:mt-0 tablet:w-1/2 w-full">
          <apo-user-training-activity
            :stroke-width="12"
            :mobile-circle-diamter="80"
            :circle-diamter="120"
          />
          <div class="ml-10 flex flex-col justify-between text-left">
            <h2
              class="headline-3 text-3xl mb-4"
              v-text="$t('trainings.overview.activity')"
            />
            <router-link
              class="button--naked shadow-hard-dark text-training-500 enter-training"
              tag="apo-button"
              :to="{ name: 'trainings' }"
              v-text="$t('trainings.successPage.hint.nextTraining')"
            />
          </div>
        </div>
      </div>
    </template>
    <!-- eslint-enable max-len -->
  </apo-user-dashboard>
</template>

<script>

import { mapGetters } from 'vuex';
import UserDashboard from '@/components/ui/UserDashboard.vue';
import SurveyExpertPointsCountUp from '@/components/survey/SurveyExpertPointsCountUp.vue';
import UserTrainingActivity from '@/components/user/UserTrainingActivity.vue';

export default {

  components: {
    'apo-user-dashboard': UserDashboard,
    'apo-user-training-activity': UserTrainingActivity,
    'apo-survey-expert-points-count-up': SurveyExpertPointsCountUp,
  },

  computed: {
    ...mapGetters(['fullName']),
  },

};

</script>
