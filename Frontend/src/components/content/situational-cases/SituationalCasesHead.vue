<template>
  <div class="situational-cases__head text-center">
    <h2
      v-html="$options.filters.formatContent(headline)"
    />
    <h4
      v-if="subheadline"
      class="mt-3"
      v-html="$options.filters.formatContent(subheadline)"
    />
  </div>
</template>

<script>

export default {

  props: {
    headline: {
      type: String,
      required: true,
    },
    subheadline: {
      type: String,
      required: false,
      default: '',
    },
  },
};
</script>
