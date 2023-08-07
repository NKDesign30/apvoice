<template>
  <div class="tab-bar">
    <template v-if="currentViewport !== 'desktop'">
      <apo-tab-item
        class="tab-bar-active-tab-item"
        :label="'active tab label goes here!'"
        @click="toggleDropdown"
      >
        <div
          v-if="activeTab !== null"
          class="pr-20"
          v-html="$options.filters.formatContent(activeTab.label)"
        />

        <div class="tab-bar-toggle">
          <apo-icon
            class="tab-bar-toggle-icon transition-transform transition-fast transition-ease"
            :class="{
              'rotate-180': isDropdownVisible,
            }"
            src="chevron"
          />
        </div>
      </apo-tab-item>

      <apo-drop-down-up-transition>
        <div
          v-if="isDropdownVisible"
          class="tab-bar-dropdown"
        >
          <apo-tab-item
            v-for="tab in computedTabs"
            :key="tab.id"
            :label="tab.label"
            @click="select(tab)"
          />
        </div>
      </apo-drop-down-up-transition>
    </template>
    <template v-else>
      <apo-tab-item
        v-for="tab in tabs"
        :key="tab.id"
        :class="{ 'tab-bar-active-tab-item': isTabActive(tab) }"
        :label="tab.label"
        @click="select(tab)"
      />
    </template>
  </div>
</template>

<script>

import { mapGetters } from 'vuex';
import TabItem from '@/components/content/tabs/TabItem.vue';

export default {
  inject: ['sharedState'],

  components: {
    'apo-tab-item': TabItem,
  },

  props: {
    tabs: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {
      isDropdownVisible: false,
    };
  },

  computed: {
    ...mapGetters(['currentViewport']),

    activeTab() {
      return this.sharedState.activeTab;
    },

    computedTabs() {
      return this.tabs.filter(tab => tab.id !== this.activeTab.id);
    },
  },

  methods: {
    toggleDropdown() {
      this.isDropdownVisible = !this.isDropdownVisible;
    },

    isTabActive(tab) {
      return this.activeTab !== null && tab.id === this.activeTab.id;
    },

    select(tab) {
      if (this.activeTab === null || this.activeTab.id !== tab.id) {
        this.sharedState.activeTab = tab;
      } else if (this.activeTab.id === tab.id) {
        this.sharedState.activeTab = null;
      }

      this.isDropdownVisible = false;
    },
  },
};

</script>

<style lang="scss" scoped>

.tab-bar {

  @apply relative;

  @screen tablet {
    @apply mx-20;
  }

  @screen desktop {
    @apply mx-0;
    @apply flex;
    @apply border-b-2;
    @apply border-blue-400;
  }

  &-active-tab-item {
    @apply bg-blue-400;
    @apply text-white;
    @apply relative;
    @apply z-20;

    @screen desktop {
      @apply bg-white;
      @apply text-blue-400;

      border-bottom-color: theme('colors.white');
      top: calc(theme('spacing.px') * 2);
      transition: background-color 0.1s ease;
    }
  }

  &-toggle {
    @apply mr-13;
    @apply absolute;
    @apply right-0;
    @apply inset-y-0;
    @apply flex;
    @apply items-center;

    &-icon {
      @apply w-12;
      @apply h-12;
    }
  }

  &-dropdown {
    @apply absolute;
    @apply z-10;
    @apply w-full;
    @apply shadow-xl;

    margin-top: calc(theme('spacing.px') * -2);
  }
}

</style>
