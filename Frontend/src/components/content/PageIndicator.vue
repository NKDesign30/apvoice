<template>
  <div class="page-indicator mb-2 tablet:mb-6">
    <h2
      v-if="hasHeadline"
      class="text-center"
      :class="{
        'mb-12': !hasSubheadline,
      }"
      v-html="$options.filters.formatContent(headline)"
    />

    <h3
      v-if="hasSubheadline"
      class="mt-6 mb-12 text-center"
      v-html="$options.filters.formatContent(subheadline)"
    />

    <button
      class="block w-full bg-gray-500 focus:outline-none"
      type="button"
      @click="toggleContent"
    >
      <div class="container flex items-center">
        <div
          class="tablet:py-2 leading-8 desktop:py-4 px-2 tablet:px-6 desktop:px-0 flex-1 text-xl tablet:text-3xl desktop:text-5xl text-gray-800 font-normal font-display text-left"
          v-html="$options.filters.formatContent(title)"
        />

        <div class="flex items-center">
          <apo-icon
            class="w-10 tablet:w-12 desktop:w-20 text-white transition-transform transition-fast transition-ease"
            :class="{
              'rotate-180': isContentVisible,
            }"
            src="chevron"
          />
        </div>
      </div>
    </button>
    <apo-drop-down-up-transition>
      <div
        v-if="isContentVisible"
        class="container"
      >
        <apo-cms-content-renderer :components="content" />
      </div>
    </apo-drop-down-up-transition>
  </div>
</template>

<script>

import get from 'lodash/get';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

export default {
  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  props: {
    page_indicator: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      isContentVisible: false,
    };
  },

  computed: {
    headline() {
      return get(this.page_indicator, 'headline', '');
    },

    hasHeadline() {
      return this.headline && this.headline.length > 0;
    },

    subheadline() {
      return get(this.page_indicator, 'subheadline', '');
    },

    hasSubheadline() {
      return this.subheadline && this.subheadline.length > 0;
    },

    title() {
      return get(this.page_indicator, 'title', '');
    },

    content() {
      return get(this.page_indicator, 'content', []);
    },
  },

  methods: {
    toggleContent() {
      this.isContentVisible = !this.isContentVisible;
    },
  },
};

</script>

<style lang="scss" scoped>

.page-indicator {
  @apply -mt-20;

  @screen desktop {
    @apply -mt-8;
  }

  &:first-child {
    @apply mt-0;
  }
}

</style>
