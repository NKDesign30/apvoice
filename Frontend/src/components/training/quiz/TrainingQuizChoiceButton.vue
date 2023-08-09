<template>
  <div
    class="choice-button"
  >
    <label :for="id">
      <!-- eslint-disable max-len -->
      <span
        class="choice-button-indicator cursor-pointer transition-ease transition-normal transition-background-color"
        :class="[{ 'is-active': value === answer, 'is-disabled cursor-not-allowed': isDisabled}, validationClass]"
      />
      <!-- eslint-enable max-len -->
    </label>
    <input
      :id="id"
      type="radio"
      :value="value"
      name="training-quiz-choice"
      :disabled="isDisabled"
      class="hidden"
      @change="onChoiceUpdate"
    >
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      required: true,
    },

    value: {
      type: String,
      required: true,
    },

    answer: {
      validator: prop => typeof prop === 'string' || prop === null,
      required: true,
      default: null,
    },

    isDisabled: {
      type: Boolean,
      default: false,
    },

    validationClass: {
      type: String,
      required: false,
      default: '',
    },

  },

  methods: {
    onChoiceUpdate(event) {
      this.$emit('input', event.target.value);
    },
  },
};
</script>

<style lang="scss" scoped>

.choice-button-indicator {
  @apply h-8;
  @apply w-8;
  @apply block;
  @apply rounded-full;
  @apply border-2;
  @apply border-gray-900;

  &:not(.is-disabled) {
    .choice:hover &, &:hover {
      box-shadow: inset 0px 0px 0px 2px white,
        inset 0px 0px 0px 15px theme('colors.gray.900');
    }
  }

  &.is-active {
    box-shadow: inset 0px 0px 0px 2px white,
      inset 0px 0px 0px 15px theme('colors.gray.900');
  }

  &.succeeded {
    box-shadow: inset 0px 0px 0px 2px white,
      inset 0px 0px 0px 15px theme('colors.green.500');
  }
  &.failed {
    box-shadow: inset 0px 0px 0px 2px white,
      inset 0px 0px 0px 15px theme('colors.red.500');
  }
}

</style>
