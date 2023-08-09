<template>
  <div class="page-indicator w-full font-display">
    <div
      class="page-indicator__head py-2 text-3xl cursor-pointer head-background-class"
      @click="toggle"
    >
      <div class="container flex">
        <span class="page-indicator__icon mr-4">
          <apo-icon
            v-if="isCompleted"
            src="radio_checked"
            class="page-indicator__icon--unchecked w-8 h-8"
          />
          <apo-icon
            v-else
            src="radio"
            class="page-indicator__icon--checked w-8 h-8"
          />
        </span>
        <div
          class="page-indicator__title flex-1"
          v-html="$options.filters.formatContent(title)"
        />
      </div>
    </div>
    <div
      v-show="isOpen"
      class="page-indicator__body py-8 overflow-hidden"
    >
      <div class="container">
        <div class="page-indicator__content">
          <apo-cms-content-renderer
            v-show="content"
            :id="id"
            :components="computedContent"
          />
          <slot/>
        </div>
        <div
          v-if="withNextButton"
          class="page-indicator__actions flex justify-center"
        >
          <apo-button
            class="button text-white button--tiny shadow-hard primary-button-class"
            @click="onContinue"
            v-text="$t('general.continue')"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

export default {
  inject: ['pageIndicatorsState'],

  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  props: {
    id: {
      type: Number,
      required: true,
    },

    title: {
      type: String,
      required: true,
    },

    content: {
      required: false,
      default: () => [],
      validator: prop => typeof prop === 'object' || typeof prop === 'boolean',
    },

    open: {
      type: Boolean,
      required: false,
      default: false,
    },

    completed: {
      type: Boolean,
      required: false,
      default: false,
    },

    withNextButton: {
      type: Boolean,
      required: false,
      default: false,
    },
  },

  provide() {
    return {
      pageIndicatorState: this.sharedState,
    };
  },

  data() {
    return {
      sharedState: {
        isOpen: this.open,
        isCompleted: this.completed,
      },
    };
  },

  computed: {
    computedContent() {
      return this.content ? this.content : [];
    },

    isOpen: {
      get() {
        return this.sharedState.isOpen;
      },

      set(isOpen) {
        this.sharedState.isOpen = isOpen;
        this.updateInjectedState();
      },
    },

    isCompleted: {
      get() {
        return this.sharedState.isCompleted;
      },
      set(isCompleted) {
        this.sharedState.isCompleted = isCompleted;
        this.updateInjectedState();
      },
    },
  },

  watch: {
    open: {
      immediate: true,
      handler(isOpen) {
        this.isOpen = isOpen;
      },
    },

    completed: {
      immediate: true,
      handler(isCompleted) {
        this.isCompleted = isCompleted;
      },
    },

    isOpen(isOpen) {
      if (isOpen) {
        this.$nextTick(() => {
          this.$scrollTo(this.$el, 500, {
            x: false,
            y: true,
          });
        });
      } else {
        this.complete();
      }
    },

    // eslint-disable-next-line func-names
    'pageIndicatorsState.activePageIndicator': function (activePageIndicatorId) {
      this.isOpen = activePageIndicatorId === this.id;
    },
  },

  methods: {
    toggle() {
      if (this.isOpen) {
        this.closePageIndicator();
      } else {
        this.openPageIndicator();
      }
    },

    openPageIndicator() {
      this.pageIndicatorsState.activePageIndicator = this.id;
    },

    closePageIndicator() {
      this.pageIndicatorsState.activePageIndicator = null;
    },

    complete() {
      this.isCompleted = true;
    },

    onContinue() {
      this.complete();
      this.closePageIndicator();

      this.$parent.$emit('continue', this.id);
    },

    updateInjectedState() {
      this.pageIndicatorsState.pageIndicators = this.pageIndicatorsState.pageIndicators
        .map(pageIndicator => {
          if (pageIndicator.id === this.id) {
            /* eslint-disable no-param-reassign */
            pageIndicator.isOpen = this.isOpen;
            pageIndicator.isCompleted = this.isCompleted;
            /* eslint-enable no-param-reassign */
          }

          return pageIndicator;
        });
    },
  },

  created() {
    this.pageIndicatorsState.pageIndicators.push({
      id: this.id,
      isOpen: this.isOpen,
      isCompleted: this.isCompleted,
    });
  },

  beforeDestroy() {
    this.pageIndicatorsState.pageIndicators = this.pageIndicatorsState.pageIndicators
      .filter(indicator => indicator.id !== this.id);
  },
};
</script>

<style lang="scss" scoped>
.theme-training {
  .primary-button-class {
    @apply bg-training-500;
  }
  .head-background-class {
    @apply bg-training-100;
  }
}

.theme-scientific {
  .primary-button-class {
    @apply bg-scientific-500;
  }
  .head-background-class {
    @apply bg-scientific-100;
  }
}
</style>
