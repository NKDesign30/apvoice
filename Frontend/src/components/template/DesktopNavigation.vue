<template>
  <div
    v-if="menu"
    class="main-navigation"
  >
    <!-- Desktop Menu -->
    <div class="hidden desktop:flex">
      <div
        v-for="item in showInMoreItems"
        :key="item.id"
      >
        <router-link
          v-if="item.url_path == '/trainings/' || item.url_path == '/trainings#products' || item.url_path == '/surveys/' || item.url_path == '/scientific/' || item.url_path == '/downloads'"
          class="flex flex-col items-center justify-center px-4 py-2 text-xs text-white tablet:text-sm desktop:text-base"
          :to="item.url_path"
        >
          <div
            class="main-navigation-icon"
            v-html="item.icon.source"
          />

          <span
            class="mt-1"
            v-text="item.title"
          />
        </router-link>
      </div>
      <!-- <div class="flex">
        <router-link
          v-for="(item, index) in regularItems"
          :key="item.id"
          class="inline-flex flex-col items-center text-white"
          :class="{ 'ml-8': index > 0 }"
          :to="item.url_path"
        >
          <div
            class="main-navigation-icon"
            v-html="item.icon.source"
          />

          <span
            class="text-center"
            v-html="$options.filters.formatContent(item.title)"
          />
        </router-link>
      </div> -->
      <!-- <div
        v-if="showInMoreItems.length > 0"
        class="relative"
      >
        <apo-flyout-menu class="w-32 ml-8 desktop-flyout-menu">
          <template #toggle="{ toggleMenu }">
            <button
              class="inline-flex flex-col items-center text-white main-navigation-toggle"
              type="button"
              @click="toggleMenu"
            >
              <apo-icon
                class="w-8 h-8"
                src="menu"
              />

              <span
                v-html="$t('template.navigation.more')"
              />
            </button>
          </template>

          <template #default="{ toggleMenu }">
            <router-link
              v-for="item in showInMoreItems"
              :key="item.id"
              class="flex flex-col items-center justify-center px-4 py-2 text-xs text-white tablet:text-sm desktop:text-base"
              :to="item.url_path"
              @click.native="toggleMenu"
            >
              <div
                class="main-navigation-icon"
                v-html="item.icon.source"
              />

              <span
                class="mt-1"
                v-text="item.title"
              />
            </router-link>

            <router-link
              v-if="isAuthenticated"
              class="flex flex-col items-center justify-center px-4 py-2 text-xs text-white tablet:text-sm desktop:hidden"
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
          </template>
        </apo-flyout-menu>
      </div> -->
    </div>
    <!-- /Desktop Menu -->
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';

export default {
  components: {
  },

  computed: {
    ...mapGetters(['isAuthenticated']),

    ...mapState({
      menu: state => state.pages.menus[process.env.VUE_APP_MAIN_NAVIGATION_KEY] || {
        items: [],
      },
    }),

    authenticatedItems() {
      return this.menu.items.filter(
        item => (this.isAuthenticated && !item.isPublic)
          || (!this.isAuthenticated && item.isPublic),
      );
    },

    regularItems() {
      return this.authenticatedItems.filter(
        item => item.showInMore === false,
      );
    },

    showInMoreItems() {
      return this.authenticatedItems.filter(item => item.showInMore === true);
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
        @apply w-8;
        @apply h-8;
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
