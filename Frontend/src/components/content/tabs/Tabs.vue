<template>
  <div class="tabs container">
    <h2
      class="text-center"
      v-html="$options.filters.formatContent(headline)"
    />

    <h3
      v-if="hasSubheadline"
      class="mt-6 text-center"
      v-html="$options.filters.formatContent(subheadline)"
    />

    <apo-tab-bar
      class="mt-7"
      :tabs="tabItems"
    />

    <apo-drop-down-up-transition>
      <apo-tab-content
        v-if="hasActiveTab && activeTab.content"
        :content="activeTab.content"
      />
    </apo-drop-down-up-transition>
  </div>
</template>

<script>

import get from 'lodash/get';
import head from 'lodash/head';
import uniqueId from 'lodash/uniqueId';
import { mapGetters } from 'vuex';
import TabBar from '@/components/content/tabs/TabBar.vue';
import TabContent from '@/components/content/tabs/TabContent.vue';

export default {
  components: {
    'apo-tab-bar': TabBar,
    'apo-tab-content': TabContent,
  },

  props: {
    tabs: {
      type: Object,
      required: true,
    },
  },

  provide() {
    return {
      sharedState: this.sharedState,
    };
  },

  data() {
    return {
      sharedState: {
        activeTab: null,
      },
    };
  },

  computed: {
    ...mapGetters(['currentViewport']),

    headline() {
      return get(this.tabs, 'headline', '');
    },

    subheadline() {
      return get(this.tabs, 'subheadline', '');
    },

    tabItems() {
      return get(this.tabs, 'tab', []).map(tab => ({
        ...tab,
        id: uniqueId('tab-'),
      }));
    },

    firstTab() {
      let firstTab = null;
      this.tabItems.map((tab, index) => {
        if (index === 0) {
          firstTab = tab;
        }
        return null;
      });
      return firstTab;
    },

    hasSubheadline() {
      return this.subheadline && this.subheadline.length > 0;
    },

    hasActiveTab() {
      return this.activeTab !== null;
    },

    activeTab: {
      get() {
        return this.sharedState.activeTab;
      },

      set(activeTab) {
        this.sharedState.activeTab = activeTab;
      },
    },
  },

  created() {
    this.sharedState.activeTab = this.firstTab;

    const unwatch = this.$watch('currentViewport', currentViewport => {
      if (currentViewport !== 'desktop' && !this.hasActiveTab) {
        this.activeTab = head(this.tabItems);
        this.$nextTick(() => unwatch());
      }
    }, { immediate: true });
  },
};

</script>
