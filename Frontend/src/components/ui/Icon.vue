<template>
  <svg
    class="inline-block"
    fill="currentColor"
    viewBox="0 0 24 24"
    v-bind="$attrs"
    v-on="$listeners"
  >
    <use :xlink:href="`#${src}`" />
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
};
</script>
