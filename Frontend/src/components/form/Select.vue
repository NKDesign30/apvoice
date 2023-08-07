<template>
  <div
    class="select-wrapper"
    :class="{ 'is-focused': isSelectFocused }"
  >
    <select
      class="select-input"
      :class="inputClass"
      :value="value"
      v-bind="$attrs"
      v-on="listeners"
      @change="onChange"
      @focus="isSelectFocused = true"
      @blur="isSelectFocused = false"
    >
      <slot />
    </select>

    <div class="select-arrow" />
  </div>
</template>

<script>

export default {
  props: {
    inputClass: {
      type: String,
      default: '',
    },

    value: {
      type: String,
      default: '',
      required: false,
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
      };
    },
  },

  methods: {
    onChange(event) {
      this.$emit('input', event.target.value);
    },
  },
};

</script>

<style lang="scss" scoped>

.select {
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

  &-arrow {
    @apply absolute;
    @apply flex;
    @apply h-full;
    @apply items-center;
    @apply right-0;
    @apply top-0;

    z-index: -1;

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
}

</style>
