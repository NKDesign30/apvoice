<template>
  <div class="loading-overlay container flex flex-col items-center">
    <apo-spinner
      size="huge"
    />

    <p
      class="mt-8 font-display text-3xl text-gray-900"
      v-html="$options.filters.formatContent(message)"
    />
  </div>
</template>

<script>

export default {
  props: {
    message: {
      type: String,
      default: '',
    },
  },
};

</script>
