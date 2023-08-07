<template>
  <label
    class="radio-button-wrapper"
    :class="{ 'is-checked': isChecked }"
    :for="id"
  >
    <input
      :id="id"
      class="radio-button-input"
      :checked="isChecked"
      :name="radioButtonState.groupName"
      type="radio"
      :value="value"
      v-bind="$attrs"
      v-on="listeners"
      @change="onChange"
    >

    <div class="radio-button-indicator">
      <div class="radio-button-indicator-inner" />
    </div>

    <span
      class="radio-button-label"
      v-html="$options.filters.formatContent(label)"
    />
  </label>
</template>

<script>

export default {
  inject: ['radioButtonState'],

  props: {
    id: {
      type: String,
      required: true,
    },

    label: {
      type: String,
      default: '',
    },

    value: {
      type: String,
      required: true,
    },
  },

  computed: {
    listeners() {
      return {
        ...this.$listeners,
        input: event => this.$emit('input', event.target.value),
      };
    },

    isChecked() {
      return this.value === this.radioButtonState.checkedValue;
    },
  },

  methods: {
    onChange(event) {
      this.$emit('change', event.target.value);
    },
  },
};

</script>

<style lang="scss" scoped>

.radio-button {
  &-wrapper {
    @apply inline-flex;
    @apply relative;
    @apply cursor-pointer;
    @apply items-center;

    min-height: 3rem;
    min-width: theme('width.12');
  }

  &-indicator {
    @apply absolute;
    @apply left-0;
    @apply top-0;
    @apply rounded-full;
    @apply border-2;
    @apply border-gray-900;
    @apply h-12;
    @apply w-12;

    padding: calc(theme('spacing.px') * 2);

    &-inner {
      @apply opacity-0;
      @apply rounded-full;
      @apply bg-gray-900;
      @apply w-full;
      @apply h-full;

      transition: opacity 0.1s ease;
    }
  }

  &-wrapper.is-checked &-indicator-inner {
    @apply opacity-100;
  }

  &-label {
    @apply ml-20;
    @apply text-2xl;
    @apply cursor-pointer;
  }

  &-input {
    @apply absolute;
    @apply left-0;
    @apply top-0;
    @apply w-full;
    @apply h-full;
    @apply cursor-pointer;
    @apply opacity-0;
  }
}

</style>
