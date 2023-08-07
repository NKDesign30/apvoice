<template>
  <div
    v-if="menu"
    class="main-navigation"
  >
    <!-- Mobile Menu -->
    <apo-flyout-menu
      v-if="authenticatedItems"
      class="desktop:hidden"
    >
      <template #toggle="{ toggleMenu }">
        <button
          class="main-navigation-toggle w-8 h-8 text-white"
          type="button"
          @click="toggleMenu"
        >
          <apo-icon
            src="menu"
          />
        </button>
      </template>

      <template #default="{ toggleMenu }" v-if="isAuthenticated">
        <router-link
          v-for="item in authenticatedItems"
          :key="item.id"
          class="px-4 py-2 flex flex-col items-center justify-center text-white text-xs tablet:text-sm desktop:text-base"
          :to="item.url_path"
          @click.native="toggleMenu"
        >
          <div
            class="main-navigation-icon"
            v-html="item.icon.source"
          />

          <span
            class="mt-1"
            v-html="$options.filters.formatContent(item.title)"
          />
        </router-link>

        <router-link
          v-if="isAuthenticated"
          class="px-4 py-2 flex flex-col items-center justify-center text-white text-xs tablet:text-sm desktop:hidden"
          :to="{ name: 'profile' }"
          @click.native="toggleMenu"
        >
          <apo-icon
            class="w-6 tablet:w-8"
            src="profile"
          />

          <span
            class="mt-1"
            v-text="$t('template.navigation.profile')"
          />
        </router-link>
        <button
          v-if="isAuthenticated"
          class="w-full px-4 py-2 flex flex-col items-center justify-center text-white text-xs tablet:text-sm desktop:hidden"
          @click="logout"
        >
          <apo-icon
            class="w-6 tablet:w-8"
            src="logout"
          />

          <span
            class="mt-1"
            v-text="$t('template.navigation.logout')"
          />
        </button>
      </template>
      <template #default="{ toggleMenu }" v-else>
        <router-link
          class="px-4 py-2 flex flex-col items-center justify-center text-white text-xs tablet:text-sm desktop:text-base"
          :to="'/downloads'"
          @click.native="toggleMenu"
        >
          <div
            class="main-navigation-icon"
          />
          <img
            class="w-8 h-8"
            src="@/assets/svg/download.svg"
            :alt="$t('template.navigation.downloads')"
          >
          <span
            class="mt-1"
            v-text="$t('template.navigation.downloads')"
          />
        </router-link>
      </template>
    </apo-flyout-menu>
    <!-- /Mobile Menu -->
  </div>
</template>

<script>

import { mapGetters, mapState } from 'vuex';
import FlyoutMenu from '@/components/template/FlyoutMenu.vue';
import { AUTH_LOGOUT } from '@/store/types/action-types';

export default {
  components: {
    'apo-flyout-menu': FlyoutMenu,
  },

  computed: {
    ...mapGetters(['isAuthenticated']),

    ...mapState({
      menu: state => state.pages.menus[process.env.VUE_APP_MAIN_NAVIGATION_KEY] || { items: [] },
    }),

    authenticatedItems() {
      return this.menu.items.filter(item => (this.isAuthenticated && !item.isPublic) || (!this.isAuthenticated && item.isPublic));
    },
  },

  methods: {
    logout() {
      this.$store.dispatch(AUTH_LOGOUT);
    },
  },
};

</script>

<style lang="scss" scoped>

.main-navigation {
  &-icon {
    @apply text-white;

    /deep/ svg {
      @apply w-6;
      @apply fill-current;

      @screen tablet {
        @apply w-8;
      }

      @screen desktop {
        @apply w-10;
      }
    }
  }
}

.desktop-flyout-menu {
  /deep/ .flyout-menu-items {
    @apply -mt-4;
    @apply ml-3;
  }
}

</style>
