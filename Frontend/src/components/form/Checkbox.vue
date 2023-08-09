<template>
  <label
    class="checkbox-button-wrapper"
    :class="{ 'is-checked': isChecked }"
    :for="id"
  >
    <input
      :id="id"
      class="checkbox-button-input"
      :checked="isChecked"
      type="checkbox"
      :value="value"
      v-bind="$attrs"
      v-on="listeners"
      @change="onChange"
    >

    <div class="checkbox-button-indicator">
      <div class="checkbox-button-indicator-inner" />
    </div>

    <span
      class="checkbox-button-label"
      v-html="$options.filters.formatContent(label)"
    />
  </label>
</template>

<script>

export default {
  model: {
    prop: 'values',
  },

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

    values: {
      type: Array,
      required: true,
    },
  },

  computed: {
    listeners() {
      return {
        ...this.$listeners,
        input: event => {
          if (event.target.checked) {
            // this.$emit('input', [...this.values, event.target.value]);
          } else {
            // this.$emit('input', this.values.filter(val => val !== event.target.value));
          }
        },
      };
    },

    isChecked() {
      return this.values.indexOf(this.value) !== -1;
    },
  },

  methods: {
    // use onChange instead of @input to prevent MS-Edge issues
    onChange(event) {
      if (event.target.checked) {
        this.$emit('input', [...this.values, event.target.value]);
      } else {
        this.$emit('input', this.values.filter(val => val !== event.target.value));
      }
    },
  },
};

</script>

<style lang="scss" scoped>

.checkbox-button {
  &-wrapper {
    @apply inline-flex;
    @apply relative;
    @apply h-12;
    @apply cursor-pointer;
    @apply items-center;

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
