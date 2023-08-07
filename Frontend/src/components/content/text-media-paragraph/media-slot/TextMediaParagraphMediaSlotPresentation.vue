<template>
  <div
    ref="container"
    v-observe-visibility="{
      callback: visibilityChanged,
      once: true,
      intersection: {
        rootMargin: '100%'
      }
    }"
  >
    <div class="shadow-lg">
      <iframe
        v-if="hasDimensions"
        allowfullscreen
        :data-language="language"
        :data-name="documentName"
        :height="height"
        :src="mediaSrc"
        :width="width"
      />
    </div>

    <div
      v-if="hasAttachment"
      class="mt-8"
    >
      <apo-text-media-paragraph-media-slot-file :media="attachment" />
    </div>
  </div>
</template>

<script>

import get from 'lodash/get';
import { mapGetters } from 'vuex';
import TextMediaParagraphMediaSlotFile from './TextMediaParagraphMediaSlotFile.vue';

export default {
  components: {
    'apo-text-media-paragraph-media-slot-file': TextMediaParagraphMediaSlotFile,
  },

  props: {
    media: {
      type: Object,
      default: () => {},
    },
  },

  data() {
    return {
      width: 0,
      height: 0,
      aspectRatio: 4 / 3,
    };
  },

  computed: {
    ...mapGetters(['language']),

    presentation() {
      return get(this.media, 'presentation', {});
    },

    attachment() {
      return get(this.media, 'attachment', {});
    },

    hasAttachment() {
      return this.attachment && Object.keys(this.attachment).length > 0;
    },

    mediaId() {
      return this.presentation.id;
    },

    baseUrl() {
      return window.axios.defaults.baseURL;
    },

    mediaSrc() {
      return `/ViewerJS/#${this.baseUrl}/wp-json/apovoice/v1/static/${this.mediaId}`;
    },

    hasDimensions() {
      return this.width > 0 && this.height > 0;
    },

    documentName() {
      return this.presentation.title;
    },
  },

  methods: {
    // eslint-disable-next-line no-unused-vars
    visibilityChanged(isVisible, entry) {
      if (isVisible) {
        this.handleDimensions();
      }
    },
    setDimensions() {
      this.width = Math.floor(this.$refs.container.getBoundingClientRect().width);
      this.height = Math.floor(this.width / this.aspectRatio);
    },
    handleDimensions() {
      const resizeHandler = () => this.setDimensions();

      resizeHandler();

      window.addEventListener('resize', resizeHandler, { passive: true });

      this.$once('hook:destroyed', () => window.removeEventListener('resize', resizeHandler));
    },
  },

  mounted() {
    this.handleDimensions();
  },
};

</script>
