<template>
  <label class="checkbox">
    <input
      type="checkbox"
      :checked="meta.choice.isSelected"
      :value="meta.choice.value"
      v-bind="$attrs"
      v-on="listeners"
      @change="onChange"
    >

    <span
      class="checkbox-text"
      v-html="$options.filters.formatContent(meta.choice.text)"
    />
  </label>
</template>

<script>

export default {
  props: {
    meta: {
      type: Object,
      required: true,
    },

    value: {
      type: String,
      default: '',
    },
  },

  computed: {
    listeners() {
      return {
        ...this.$listeners,
        // eslint-disable-next-line no-unused-vars
        input: event => {},
      };
    },
  },

  methods: {
    // use onChange instead of @input to prevent MS-Edge issues
    onChange(event) {
      this.$emit('input', event.target.checked ? event.target.value : '');
    },
  },
};

</script>

<style lang="scss" scoped>

.checkbox {
  @apply cursor-pointer;
  @apply block;
  @apply items-center;

  @screen tablet {
      @apply inline-flex;
  }

  &-text {
    @apply ml-4;
    @apply text-gray-900;
    @apply text-xl;
  }
}

</style>
