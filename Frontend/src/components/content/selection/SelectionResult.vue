<template>
  <div class="selection-result">
    <div class="selection-result-header">
      <div class="py-7.5 container flex justify-between desktop:justify-center">
        <div
          class="text-white font-display text-2xl"
          v-text="$t('modules.selection.result', [correctCount, totalCount])"
        />

        <button
          class="selection-result-restart-button"
          @click="$emit('restart')"
        >
          <span v-text="$t('general.restart')" />
          <apo-icon
            class="selection-result-restart-button-icon"
            src="time"
          />
        </button>
      </div>
    </div>

    <div class="mt-7.5 desktop:mt-10 mt- container">
      <apo-cms-content-renderer
        :components="content"
      />
    </div>
  </div>
</template>

<script>

import filter from 'lodash/filter';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

export default {
  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  props: {
    result: {
      type: Object,
      required: true,
    },

    content: {
      type: Array,
      default: () => [],
    },
  },

  computed: {
    totalCount() {
      return Object.keys(this.result).length;
    },

    correctCount() {
      return filter(this.result, ['answer.is_correct_answer', true]).length;
    },
  },
};

</script>

<style lang="scss" scoped>

.selection-result {
  &-header {
    @apply bg-blue-500;
    @apply relative;

    margin-left: calc(-50vw + 50%);
    width: 100vw;
  }

  &-restart-button {
    @apply text-white;
    @apply text-2xl;
    @apply font-display;
    @apply inline-flex;
    @apply items-center;

    @screen desktop {
      @apply absolute;
      @apply top-0;
      @apply right-0;
      @apply mt-7.5;

      margin-right: 20%;
    }

    &-icon {
      @apply ml-2;
      @apply w-8;

      @screen desktop {
        @apply w-10;
      }

      transform: scale(-1, 1);
    }
  }

  &-item {
    &-image {
      @apply overflow-hidden;
      @apply bg-cover;
      @apply w-64;
      @apply h-64;
      @apply shadow;
    }
  }

  /deep/ .cms-content-renderer > div:first-child {
    @apply pt-0;

    @screen tablet {
      @apply pt-0;
    }

    @screen desktop {
      @apply pt-0;
    }
  }
}

</style>
