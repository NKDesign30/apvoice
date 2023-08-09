<template>
  <apo-user-dashboard>
    <template #head>
      <!-- eslint-disable-next-line max-len -->
      <h2
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
    </template>
    <!-- eslint-enable max-len -->

    <template #body>
      <h3
        class="text-center text-white font-display"
        v-text="$t('general.forbiddenPageAccess')"
      />
    </template>
  </apo-user-dashboard>
</template>

<script>
import { mapGetters } from 'vuex';
import UserDashboard from '@/components/ui/UserDashboard.vue';

export default {
  components: {
    'apo-user-dashboard': UserDashboard,
  },

  computed: {
    ...mapGetters(['fullName', 'profilePicture']),
  },

};

</script>
