<template>
  <textarea
    class="px-3 py-2 w-full border-2 border-gray-600 resize-y rounded-lg focus:outline-none"
    :value="value"
    v-bind="$attrs"
    :maxlength="meta.maxLength"
    v-on="listeners"
  />
</template>

<script>

export default {
  props: {
    value: {
      type: String,
      default: '',
    },

    meta: {
      type: Object,
      default() {
        return {
          maxLength: 0,
        };
      },
    },
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
