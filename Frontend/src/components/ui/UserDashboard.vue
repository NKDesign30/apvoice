<template>
  <div class="flex flex-col items-center pb-24 user-dashboard">
    <div class="container text-left user-dashboard__logo">
      <slot name="logo" />
    </div>

    <apo-animate-transition name="fadeInDown">
      <div class="container pt-24 mx-auto text-center text-white user-dashboard_head font-display">
        <slot name="notification" />
        <slot name="head" />
      </div>
    </apo-animate-transition>

    <apo-animate-transition name="zoomIn">
      <div class="relative mt-10 mb-10 user-dashboard__profile">
        <!-- eslint-disable max-len -->
        <slot name="profile">
          <img
            :src="profilePicture"
            alt="User profile picture"
            class="w-40 h-40 border-white rounded-full user-dashboard__profile-picture profile-picture tablet:w-72 tablet:h-72 border-10"
          >
        </slot>
        <!-- eslint-enable max-len -->
      </div>
    </apo-animate-transition>

    <div class="w-full px-4 text-center text-white user-dashboard__body font-display">
      <slot name="body" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters(['profilePicture']),
  },
};
</script>

<style lang="scss" scoped>

  .theme-default {
      .user-dashboard {
        background: linear-gradient(45deg, theme('colors.blue.700'), theme('colors.blue.500'));
      }

  }

  .theme-training {
    .user-dashboard {
      background: linear-gradient(45deg, theme('colors.training.500'), theme('colors.training.200'));
    }
  }

  .theme-scientific {
    .user-dashboard {
      background: linear-gradient(45deg, theme('colors.scientific.500'), theme('colors.scientific.300'));
    }
  }

  .theme-survey {
    .user-dashboard {
      background: linear-gradient(120deg, theme('colors.orange.600'), theme('colors.yellow.500'));
    }
  }

  .profile-picture {
    box-shadow: 0 4px 0 1px rgba(0, 0, 0,0.2), inset 0 1px 60px rgba(0, 0, 0, 0.35);
  }

  .logo {
    max-width: 280px;
    height: 157px;
  }

</style>
