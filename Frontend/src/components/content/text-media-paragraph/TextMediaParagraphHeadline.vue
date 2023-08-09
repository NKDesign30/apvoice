<template>
  <div class="text-media-paragraph__headline">
    <h2
      class="headline-1 "
      v-html="$options.filters.formatContent(headline)"
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
  },
};
</script>

<style lang="scss">

.text-media-paragraph__headline b {
  font-weight: bold;
}

.text-media-paragraph__headline sub {
  bottom: .75rem;
}

</style>
