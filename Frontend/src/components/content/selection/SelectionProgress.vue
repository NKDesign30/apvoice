<template>
  <div class="selection-progress">
    <div class="container flex flex-col items-center">
      <div class="text-gray-900 font-display text-4xl tracking-wide font-normal">
        <span v-text="current" />
        <span>/</span>
        <span v-text="total" />
      </div>

      <div class="mt-6 w-full desktop:w-auto flex justify-between desktop:justify-center text-sm">
        <button
          class="mr-2.5 selection-progress-button"
          :disabled="!canNavigateBack"
          type="button"
          @click="back"
        >
          <apo-icon
            class="w-12 rotate-90"
            src="dropdown-small"
          />

          <span
            class="ml-3 desktop:ml-8"
            v-text="$t('general.back')"
          />
        </button>
        <button
          class="ml-2.5 selection-progress-button"
          :disabled="!canNavigateForth"
          type="button"
          @click="next"
        >
          <span
            class=" mr-3 desktop:mr-8"
            v-text="$t('general.next')"
          />

          <apo-icon
            class="w-12 rotate-negative-90"
            src="dropdown-small"
          />
        </button>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: {
    current: {
      type: Number,
      required: true,
    },

    total: {
      type: Number,
      required: true,
    },

    isCurrentQuestionAnswered: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    canNavigateBack() {
      return this.current > 1;
    },

    canNavigateForth() {
      return this.isCurrentQuestionAnswered;
    },
  },

  methods: {
    back() {
      this.$emit('back');
    },

    next() {
      this.$emit('next');
    },
  },
};

</script>

<style lang="scss" scoped>

@import '../../../assets/scss/utilities';

.selection-progress {
  &-button {
    @apply text-gray-700;
    @apply text-2xl;
    @apply font-display;
    @apply inline-flex;
    @apply items-center;

    @extend .transition-color;
    @extend .transition-ease;
    @extend .transition-fast;

    &:hover:not(:disabled) {
      @apply text-gray-800;
    }

    &:disabled {
      @apply opacity-50;
      @apply cursor-not-allowed;
    }
  }
}

</style>
