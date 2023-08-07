<template>
  <select
    class="multi-select-input"
    :value="value"
    v-bind="$attrs"
    multiple
    v-on="listeners"
  >
    <option
      v-for="option in meta.options"
      :key="option.id"
      :value="option.value"
      v-text="option.text"
    />
  </select>
</template>

<script>

export default {
  props: {
    meta: {
      type: Object,
      required: true,
    },

    value: {
      type: Array,
      required: true,
    },
  },

  computed: {
    listeners() {
      return {
        ...this.$listeners,
        input: event => [...event.target.selectedOptions].map(option => option.value),
      };
    },
  },
};

</script>

<style lang="scss" scoped>

.multi-select-input {
  @apply appearance-none;
  @apply bg-transparent;
  @apply border-2;
  @apply border-gray-600;
  @apply outline-none;
  @apply p-3;
  @apply rounded-lg;
  @apply shadow-inner-light;
  @apply text-gray-900;
  @apply text-xl;
  @apply w-full;

  transition: all 0.3s ease;

  &:focus {
    @apply border-gray-200;
    @apply outline-none;
  }
}

</style>
