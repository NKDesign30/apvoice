<template>
  <div
    class="progress overflow-hidden"
    :class="{ 'inset-0 sticky z-10': sticky, 'interactive': interactive }"
  >
    <!-- eslint-disable max-len -->
    <div
      v-if="totalChapters === 1"
      class="mx-2 rounded-full progress--secondary container flex h-2 mx-auto new-progress w-full overflow-hidden"
    >
      <div
        class="progress--primary transition-width transition-normal transition-ease"
        :style="{ width: progess + '%' }"
      />
    </div>

    <div
      v-else
      class="-mx-2 flex justify-center"
    >
      <!-- eslint-disable max-len -->
      <div
        v-for="number in chapters"
        :key="number"
        class="mx-2 h-2 progress--secondary rounded-full max-w-xs transition-background-color transition-normal transition-ease"
        :class="[
          {
            'progress--primary': isProgressTabActive(number),
          },
          progressClassObject
        ]"
        :title="$t('modules.progress.chapter', [number])"
        :style="{ width: `${100 / totalChapters}%` }"
        @click="$emit('update-chapter', number)"
      />
      <!-- eslint-enable max-len -->
    </div>
  </div>
</template>

<script>

import range from 'lodash/range';

export default {
  props: {
    chapter: {
      type: Number,
      default: 1,
    },

    totalChapters: {
      type: Number,
      default: 1,
    },

    totalQuestions: {
      type: Number,
      default: 0,
    },

    answeredQuestions: {
      type: Number,
      default: 0,
    },

    interactive: {
      type: Boolean,
      default: true,
    },

    sticky: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    chapters() {
      return range(1, this.totalChapters + 1);
    },
    progess() {
      return this.answeredQuestions / this.totalQuestions * 100;
    },
    progressClassObject() {
      if (this.interactive) {
        return 'progress--hover cursor-pointer';
      }
      return null;
    },
  },
  methods: {
    isProgressTabActive(number) {
      if (this.interactive) {
        return number === this.chapter;
      }
      return number <= this.chapter;
    },
  },
};

</script>

<style lang="scss" scoped>

.progress {

  &.sticky {
    @apply py-6;
    @apply bg-white;

    top: 0;
    max-width: 64rem;
    margin: 0 auto;
  }

  &--secondary {
    @apply bg-gray-500;
  }

  &--primary {
    @apply bg-blue-500;
  }

  &.interactive {
    .progress--hover {
      &:hover {
        @apply bg-blue-500;
      }
    }
  }

  .theme-survey &--secondary {
    @apply bg-orange-100;
  }

  .theme-survey &--primary {
    @apply bg-yellow-500;
  }

  .theme-survey &.interactive {
    .progress--hover {
      &:hover {
        @apply bg-yellow-500;
      }
    }
  }

  .theme-training &--primary {
    @apply bg-training-500;
  }

  .theme-training &.interactive {
    .progress--hover {
      &:hover {
        @apply bg-training-500;
      }
    }
  }

  .theme-knowledge-base &--primary,
  .theme-downloads &--primary {
    @apply bg-purple-300;
  }

  .theme-knowledge-base &.interactive,
  .theme-downloads &.interactive {
    .progress--hover {
      &:hover {
        @apply bg-purple-300;
      }
    }
  }

  .theme-raffle &--primary {
    @apply bg-green-500;
  }

}
</style>
