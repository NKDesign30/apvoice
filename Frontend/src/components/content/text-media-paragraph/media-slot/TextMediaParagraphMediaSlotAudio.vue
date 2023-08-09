<template>
  <div class="text-media-paragraph__media-slot--video">
    <div class="mb-3">
      <audio controls>
        <source
          :src="options.src"
          :type="options.type"
        >
      </audio>
    </div>
  </div>
</template>

<script>

// eslint-disable-next-line import/no-extraneous-dependencies
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
      return get(this.media, 'url', null);
    },
    options() {
      return {
        src: this.src,
        type: 'audio/mpeg',
      };
    },
  },
};

</script>

<style lang="scss">
  audio {
    width: 100%;
  }
</style>
