<template>
  <svg
    class="inline-block"
    fill="currentColor"
    viewBox="0 0 24 24"
  >
    <use v-bind="bindings" />
  </svg>
</template>

<script>

export default {
  props: {
    src: {
      type: String,
      required: true,
    },
  },

  computed: {
    bindings() {
      return {
        'xlink:href': `#streamline-${this.src}`,
      };
    },
  },
};

</script>
