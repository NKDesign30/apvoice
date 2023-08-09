<template>
  <div class="text-media-paragraph__media-slot--file">
    <div class="mb-3 text-center">
      <apo-button
        class="button button--primary invert button--tiny shadow-hard"
        @click="download"
        v-text="buttonText"
      />
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
    id() {
      return get(this.media, 'ID', null);
    },
    url() {
      return get(this.media, 'url', null);
    },
    title() {
      return get(this.media, 'title', null);
    },
    subtype() {
      return get(this.media, 'subtype', null);
    },
    filename() {
      return get(this.media, 'filename', `Apovoice file attachment.${this.subtype}`);
    },
    buttonText() {
      return this.$t('modules.textMediaParagraph.buttons.download', { title: this.title });
    },
  },
  methods: {
    download() {
      window.open(this.url, '_blank');
    },
  },
};
</script>
