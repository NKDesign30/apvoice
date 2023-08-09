<template>
  <div class="text-media-paragraph__media-slot--image">
    <div class="mb-3">
      <img
        :src="src"
        class="w-full h-auto"
        :alt="alt"
        :title="title"
      >
    </div>
  </div>
</template>

<script>
import get from 'lodash/get';

export default {
  props: {
    media: {
      type: Object,
      required: false,
      default: null,
    },
  },
  computed: {
    src() {
      return get(this.media, 'sizes.large', null);
    },
    alt() {
      return get(this.media, 'alt', '');
    },
    title() {
      return get(this.media, 'title', '');
    },
  },
};
</script>
