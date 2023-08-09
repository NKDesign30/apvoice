<template>
  <div class="text-media-paragraph__media-slot">
    <div class="mb-3">
      <component
        :is="resolveMediaSlot"
        :media="media"
      />
    </div>
    <div
      v-if="caption && !withoutCaption"
      :class="captionSpacings"
      class="font-display text-sm"
      v-html="$options.filters.formatContent(caption)"
    />
  </div>
</template>

<script>
import TextMediaParagraphMediaSlotImage from '@/components/content/text-media-paragraph/media-slot/TextMediaParagraphMediaSlotImage.vue';
import TextMediaParagraphMediaSlotVideo from '@/components/content/text-media-paragraph/media-slot/TextMediaParagraphMediaSlotVideo.vue';
import TextMediaParagraphMediaSlotAudio from '@/components/content/text-media-paragraph/media-slot/TextMediaParagraphMediaSlotAudio.vue';
import TextMediaParagraphMediaSlotFile from '@/components/content/text-media-paragraph/media-slot/TextMediaParagraphMediaSlotFile.vue';
import TextMediaParagraphMediaSlotChart from '@/components/content/text-media-paragraph/media-slot/TextMediaParagraphMediaSlotChart.vue';
import TextMediaParagraphMediaSlotPresentation from '@/components/content/text-media-paragraph/media-slot/TextMediaParagraphMediaSlotPresentation.vue';

export default {
  components: {
    'apo-text-media-paragraph-media-slot-image': TextMediaParagraphMediaSlotImage,
    'apo-text-media-paragraph-media-slot-video': TextMediaParagraphMediaSlotVideo,
    'apo-text-media-paragraph-media-slot-audio': TextMediaParagraphMediaSlotAudio,
    'apo-text-media-paragraph-media-slot-file': TextMediaParagraphMediaSlotFile,
    'apo-text-media-paragraph-media-slot-chart': TextMediaParagraphMediaSlotChart,
    'apo-text-media-paragraph-media-slot-presentation': TextMediaParagraphMediaSlotPresentation,
  },
  props: {
    media: {
      type: [Object, Array],
      required: true,
      default: () => {},
    },
    mediaType: {
      type: String,
      required: false,
      default: null,
    },
    caption: {
      type: String,
      required: false,
      default: '',
    },
    captionSpacings: {
      type: String,
      required: false,
      default: '',
    },
    withoutCaption: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  computed: {
    resolveMediaSlot() {
      switch (this.mediaType) {
        case 'image':
          return 'apo-text-media-paragraph-media-slot-image';

        case 'video':
          return 'apo-text-media-paragraph-media-slot-video';

        case 'audio':
          return 'apo-text-media-paragraph-media-slot-audio';

        case 'file':
          return 'apo-text-media-paragraph-media-slot-file';

        case 'chart':
          return 'apo-text-media-paragraph-media-slot-chart';

        case 'presentation':
          return 'apo-text-media-paragraph-media-slot-presentation';

        default:
          return null;
      }
    },
  },
};
</script>
