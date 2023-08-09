<template>
  <apo-user-dashboard>
    <template #head>
      <h1 class="text-3xl tablet:text-6xl font-bold">
        {{ fullName }}
      </h1>
      <span
        class="headline-4 text-xl"
        v-text="$t(`data.profile.job.${user.job}`)"
      />
    </template>
    <template #profile>
      <apo-training-overview-user-dashboard-training-activity />
    </template>
    <template #body>
      <h2
        class="headline-3 text-3xl mb-4"
        v-text="$t('trainings.overview.activity')"
      />
      <div class="description text-xl">
        <p v-html="$t('trainings.overview.activityMessage')" />
      </div>
    </template>
  </apo-user-dashboard>
</template>

<script>
import { mapGetters } from 'vuex';
import UserDashboard from '@/components/ui/UserDashboard.vue';
import TrainingOverviewUserDashboardTrainingActivity from '@/components/training/overview/TrainingOverviewUserDashboardTrainingActivity.vue';

export default {
  components: {
    'apo-user-dashboard': UserDashboard,
    'apo-training-overview-user-dashboard-training-activity': TrainingOverviewUserDashboardTrainingActivity,
  },

  computed: {
    ...mapGetters(['user', 'fullName']),
  },
};
</script>
