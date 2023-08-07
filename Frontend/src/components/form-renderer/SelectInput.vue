<template>
  <div
    class="select-input-wrapper"
    :class="{ 'is-focused': isSelectFocused }"
  >
    <select
      class="select-input"
      :class="inputClass"
      :value="value"
      v-bind="$attrs"
      v-on="listeners"
      @focus="isSelectFocused = true"
      @blur="isSelectFocused = false"
    >
      <option
        v-for="option in meta.options"
        :key="option.value"
        :value="option.value"
        v-html="$options.filters.formatContent(option.text)"
      />
    </select>

    <div class="select-input-arrow" />
  </div>
</template>

<script>

export default {
  props: {
    inputClass: {
      type: String,
      default: '',
    },

    meta: {
      type: Object,
      required: true,
    },

    value: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      isSelectFocused: false,
    };
  },

  computed: {
    listeners() {
      return {
        ...this.$listeners,
        input: event => this.$emit('input', event.target.value),
        change: event => this.$emit('input', event.target.value),
      };
    },
  },
};

</script>

<style lang="scss" scoped>

.select-input {
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

  &-arrow {
    @apply absolute;
    @apply flex;
    @apply h-full;
    @apply items-center;
    @apply right-0;
    @apply top-0;

    &:after {
      @apply inline-block;
      @apply h-0;
      @apply mr-4;
      @apply w-0;

      border-left: theme('spacing.2') solid transparent;
      border-right: theme('spacing.2') solid transparent;
      border-top: theme('spacing.2') solid theme('colors.gray.800');
      content: '';
    }
  }

   &:disabled {
    opacity: .5;
    @apply bg-gray-100;
  }
}

</style>
