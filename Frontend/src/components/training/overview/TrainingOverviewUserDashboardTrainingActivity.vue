<template>
  <div class="relative w-56 h-56 bg-white rounded-full training-activity tablet:w-72 tablet:h-72">
    <apo-user-training-activity class="absolute absolute-center" />
    <apo-user-login-activity class="absolute absolute-center" />

    <!-- eslint-disable max-len -->
    <img
      :src="profilePicture"
      alt="User profile picture"
      class="absolute w-32 h-32 border-white rounded-full training-activity__profile-picture tablet:w-40 tablet:h-40 absolute-center"
    >
    <!-- eslint-enable max-len -->
  </div>
</template>

<script>

import { mapGetters } from 'vuex';
import UserLoginActivity from '@/components/user/UserLoginActivity.vue';
import UserTrainingActivity from '@/components/user/UserTrainingActivity.vue';

export default {
  components: {
    'apo-user-login-activity': UserLoginActivity,
    'apo-user-training-activity': UserTrainingActivity,
  },

  computed: {
    ...mapGetters(['profilePicture']),
  },
};

</script>

<style lang="scss" scoped>

.absolute-center {
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

</style>
