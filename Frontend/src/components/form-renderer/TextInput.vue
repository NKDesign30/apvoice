<template>
  <div
    class="relative flex items-center text-input-wrapper"
    :class="{ 'is-focused': isInputFocused }"
  >
    <slot name="before" />

    <input
      class="text-input"
      :class="inputClass"
      :placeholder="fieldPlaceholder"
      :aria-label="fieldPlaceholder"
      :type="fieldType"
      :value="value"
      :required="required"
      v-bind="$attrs"
      v-on="listeners"
      @focus="isInputFocused = true"
      @blur="isInputFocused = false"
    >

    <slot name="after" />
  </div>
</template>

<script>

export default {
  props: {
    value: {
      type: String,
      default: '',
    },

    placeholder: {
      type: String,
      default: '',
    },

    type: {
      type: String,
      default: '',
    },

    required: {
      type: String,
      default: '',
    },

    inputClass: {
      type: String,
      default: '',
    },

    field: {
      type: Object,
      default() {
        return {
          type: 'text',
        };
      },
    },

    meta: {
      type: Object,
      default() {
        return {
          maxLength: -1,
        };
      },
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

    fieldPlaceholder() {
      return this.placeholder || this.field.placeholder;
    },

    fieldType() {
      return this.type || this.field.type;
    },
  },
};

</script>

<style lang="scss" scoped>
.login-text-input {
background: #FFFFFF !important;
placeholder: #CCCCCC !important;
color: #000 !important
}
.text-input {
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

  &::placeholder {
    @apply italic;
  }

  &-wrapper {
    @apply border-2;
    @apply border-gray-600;
    @apply overflow-hidden;
    @apply rounded-full;
    @apply shadow-inner-light;

    transition: all 0.3s ease;

    &.is-focused {
      @apply border-gray-200;
      box-shadow: 0 0 0 3px lightblue;
    }
  }

  &:disabled {
    opacity: .5;
    @apply bg-gray-100;
  }
}

</style>
