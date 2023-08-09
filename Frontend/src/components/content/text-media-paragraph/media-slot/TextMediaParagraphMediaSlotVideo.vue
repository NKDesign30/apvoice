<template>
  <div class="text-media-paragraph__media-slot--video">
    <div class="mb-3">
      <apo-video-player
        class="vjs-apo-skin"
        :options="options"
      />
    </div>
  </div>
</template>

<script>

// eslint-disable-next-line import/no-extraneous-dependencies
import 'video.js/dist/video-js.css';
import { videoPlayer } from 'vue-video-player';
import get from 'lodash/get';

export default {
  components: {
    'apo-video-player': videoPlayer,
  },
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
    alt() {
      return get(this.media, 'alt', null);
    },
    title() {
      return get(this.media, 'title', null);
    },
    options() {
      return {
        autoplay: false,
        controls: true,
        sources: [
          {
            src: this.src,
            type: 'video/mp4',
          },
        ],
        aspectRatio: '16:9',
        fluid: true,
        responsive: true,
      };
    },
  },
};

</script>

<style lang="scss">

.vjs-apo-skin {
  & > .video-js {
    width: 100%;
  }

  .vjs-big-play-button {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
}

</style>
