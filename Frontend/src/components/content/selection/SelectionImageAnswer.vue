<template>
  <div
    class="selection-image-answer"
    @click="select"
  >
    <h4
      class="text-center"
      v-html="$options.filters.formatContent(answer.title)"
    />

    <div
      class="mt-7.5 w-full h-full relative shadow-lg"
      :class="{ 'cursor-pointer hover:shadow-xl': !isDisabled }"
    >
      <div
        v-if="status"
        class="selection-image-answer-overlay"
        :class="[`is-${status}`]"
      />

      <img
        v-if="answer.image"
        class="w-full h-full object-cover"
        :src="answer.image.sizes.large"
        :alt="answer.image.alt"
        :title="answer.image.title"
      >
    </div>
  </div>
</template>

<script>

export default {
  props: {
    answer: {
      type: Object,
      required: true,
    },

    selectedAnswer: {
      type: Object,
      required: true,
    },

    isDisabled: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    status() {
      if (!this.selectedAnswer || !this.selectedAnswer.answer) {
        return '';
      }

      return this.answer.is_correct_answer ? 'success' : 'failure';
    },
  },

  methods: {
    select() {
      if (this.isDisabled) {
        return;
      }

      this.$emit('answered', this.answer);
    },
  },
};

</script>

<style lang="scss" scoped>

.selection-image {
  &-answer {
    &-overlay {
      @apply absolute;
      @apply left-0;
      @apply top-0;
      @apply h-6;
      @apply w-full;
      @apply opacity-50;

      animation-name: flash;
      animation-duration: 1s;
      animation-timing-function: ease;

      &.is-success {
        @apply bg-green-200;
      }

      &.is-failure {
        @apply bg-red-500;
      }
    }
  }
}

@keyframes flash {
  0%,
  25%,
  75% {
    @apply opacity-0;
  }

  50%,
  100% {
    @apply opacity-50;
  }
}

</style>
