<template>
  <div
    class="text-wrapper"
    :class="{ 'is-focused': isInputFocused }"
  >
    <input
      :type="type"
      class="text-input"
      :class="inputClass"
      :value="value"
      v-bind="$attrs"
      v-on="listeners"
      @focus="isInputFocused = true"
      @blur="isInputFocused = false"
    >
  </div>
</template>

<script>

export default {
  inheritAttrs: false,
  props: {
    type: {
      type: String,
      default: 'text',
    },

    inputClass: {
      type: String,
      default: '',
    },

    value: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      isInputFocused: false,
    };
  },

  computed: {
    listeners() {
      return {
        ...this.$listeners,
        input: event => this.$emit('input', event.target.value),
      };
    },
  },
};

</script>

<style lang="scss" scoped>

.text {
  &-input {
    @apply appearance-none;
    @apply border-0;
    @apply bg-transparent;
    @apply outline-none;
    @apply px-5;
    @apply py-2;
    @apply text-gray-900;
    @apply text-xl;
    @apply w-full;

    transition: all 0.3s ease;

    &:hover,
    &:focus {
      @apply border-gray-200;
    }
  }

  &-wrapper {
    @apply border-2;
    @apply border-gray-600;
    @apply overflow-hidden;
    @apply relative;
    @apply rounded-full;
    @apply shadow-inner-light;

    transition: all 0.3s ease;

    &.is-focused {
      @apply border-gray-200;
    }
  }
}

</style>
