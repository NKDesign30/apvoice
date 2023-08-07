<template>
  <apo-user-dashboard>
    <template #head>
      <!-- eslint-disable-next-line max-len -->
      <h1
        class="text-2xl text-center text-white font-display tablet:text-6xl"
        v-html="$t('surveys.salutation', [fullName])"
      />
    </template>

    <!-- eslint-disable max-len -->
    <template #profile>
      <img
        :src="profilePicture"
        alt="User profile picture"
        class="w-40 h-40 border-white rounded-full profile-picture tablet:w-72 tablet:h-72 border-10"
      >
      <apo-survey-expert-points-count-up class="absolute bottom-0 right-0 w-20 h-20 text-3xl tablet:w-40 tablet:h-40 tablet:text-6xl score-translate" />
    </template>
    <!-- eslint-enable max-len -->

    <template #body>
      <h2
        class="headline-3 text-3xl text-center text-white font-display tablet:text-5xl"
        v-text="$t('surveys.headlines.expertPoints')"
      />
      <router-link
        class="mt-12 text-yellow-500 button--naked shadow-hard-dark"
        tag="apo-button"
        :to="{ name: 'redeem' }"
        v-text="$t('surveys.buttons.redeem')"
      />
    </template>
  </apo-user-dashboard>
</template>

<script>
import { mapGetters } from 'vuex';
import UserDashboard from '@/components/ui/UserDashboard.vue';
import SurveyExpertPointsCountUp from '@/components/survey/SurveyExpertPointsCountUp.vue';

export default {
  components: {
    'apo-user-dashboard': UserDashboard,
    'apo-survey-expert-points-count-up': SurveyExpertPointsCountUp,
  },

  computed: {
    ...mapGetters(['fullName', 'profilePicture', 'expertPoints']),
  },

};

</script>

<style lang="scss" scoped>

.score-translate {
  transform: translate(50%, 25%);
}
</style>
