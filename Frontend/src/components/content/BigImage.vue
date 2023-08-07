<template>
  <div class="container big-image">
    <div
      v-if="headline"
      class="container mb-16 text-4xl text-center big-image__headline desktop:text-5xl"
      v-html="$options.filters.formatContent(headline)"
    />
    <img
      v-if="image"
      :src="image"
      :alt="alt"
      :title="title"
      class="w-full h-auto big-image__image"
    >
  </div>
</template>

<script>
import get from 'lodash/get';

export default {
  props: {
    big_image: {
      type: Object,
      required: true,
    },
  },
  computed: {
    image() {
      return get(this.big_image, 'image.sizes.large', null);
    },
    headline() {
      return get(this.big_image, 'headline', null);
    },
    alt() {
      return get(this.big_image, 'image.alt', '');
    },
    title() {
      return get(this.big_image, 'image.title', '');
    },
  },
};
</script>

<style lang="scss" scoped>

@tailwind components;

.big-image {
  .big-image__headline {
    @apply headline-3;

    @screen desktop {
      @apply headline-3-desktop;
    }
  }
}

</style>
