<template>
  <div class="interactive-list">
    <div class="desktop:mx-auto desktop:container">
      <div
        v-if="headline || subheadline"
        class="list__headlines text-gray-900 mb-7"
      >
        <h2
          class="text-center"
          v-html="$options.filters.formatContent(headline)"
        />

        <span
          v-if="subheadline"
          class="headline-2 mt-6 text-center"
          v-html="$options.filters.formatContent(subheadline)"
        />
      </div>
      <div class="desktop:-mx-4 tablet:flex tablet:flex-wrap tablet:justify-around">
        <!-- eslint-disable max-len -->
        <div
          v-for="item in listItems"
          :key="item.id"
          class="interactive-list-item w-full tablet:w-1/2 desktop:w-1/5"
          :class="{ 'is-open': visibleItem === item }"
        >
          <div
            class="p-4 flex flex-col items-center"
            :class="{ 'cursor-pointer transition-ease transition-normal transition-background-color hover:bg-blue-100': isInteractive }"
            @click="visibleItem = item"
          >
            <img
              v-if="item.image"
              :src="item.image.sizes.thumbnail"
              :alt="item.image.alt"
              class="h-32 w-32 rounded-full"
            >

            <h3
              class="headline-4 mt-6 text-center text-gray-800 text-2xl font-display"
              v-html="$options.filters.formatContent(item.title)"
            />

            <p
              class="mt-2 text-center"
              v-html="$options.filters.formatContent(item.description)"
            />

            <apo-icon
              v-if="isInteractive"
              src="chevron"
              class="interactive-list-item-indicator"
            />
          </div>

          <apo-interactive-list-content
            v-if="isInteractive"
            class="tablet:hidden"
            :item="visibleItem"
            :show="visibleItem !== null && visibleItem.id === item.id"
            @close="visibleItem = null"
          />
        </div>
        <!-- eslint-enable max-len -->
      </div>
    </div>

    <apo-interactive-list-content
      v-if="isInteractive"
      class="py-6 hidden tablet:block"
      :item="visibleItem"
      :show="visibleItem !== null"
      @close="visibleItem = null"
    />
  </div>
</template>

<script>

import uniqueId from 'lodash/uniqueId';
import InteractiveListContent from '@/components/content/interactive-list/InteractiveListContent.vue';

export default {
  components: {
    'apo-interactive-list-content': InteractiveListContent,
  },

  props: {
    headline: {
      type: String,
      required: false,
      default: '',
    },
    subheadline: {
      type: String,
      required: false,
      default: '',
    },
    // eslint-disable-next-line vue/prop-name-casing
    interactive_list_item: {
      type: Array,
      required: false,
      default: () => [],
    },

    // eslint-disable-next-line vue/prop-name-casing
    list_item: {
      type: Array,
      required: false,
      default: () => [],
    },
  },

  data() {
    return {
      listItems: [],
      visibleItem: null,
      isInteractive: false,
    };
  },

  created() {
    let actualItems = [];
    if (this.interactive_list_item.length > 0) {
      this.isInteractive = true;
      actualItems = this.interactive_list_item.slice();
    } else {
      actualItems = this.list_item.slice();
    }
    this.listItems = actualItems.map(item => ({
      id: uniqueId(),
      ...item,
    }));
  },
};

</script>

<style lang="scss" scoped>

.interactive-list {
  &-item {
    &-indicator {
      @apply w-16;
      @apply text-gray-900;

      transition: transform 0.25s ease;
      will-change: transform;
    }

    &.is-open &-indicator {
      transform: rotate(180deg);
    }
  }
}

</style>
