<template>
  <div class="text-media-paragraph__subheadline">
    <h3 v-html="$options.filters.formatContent(subheadline)" />
  </div>
</template>

<script>
export default {
  props: {
    subheadline: {
      type: String,
      required: false,
      default: '',
    },
  },
};
</script>
