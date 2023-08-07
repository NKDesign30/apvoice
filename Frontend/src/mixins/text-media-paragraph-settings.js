import get from 'lodash/get';
import TextMediaParagraphHeadline from '@/components/content/text-media-paragraph/TextMediaParagraphHeadline.vue';
import TextMediaParagraphSubHeadline from '@/components/content/text-media-paragraph/TextMediaParagraphSubHeadline.vue';
import TextMediaParagraphMediaSlot from '@/components/content/text-media-paragraph/TextMediaParagraphMediaSlot.vue';
import TextMediaParagraphCopy from '@/components/content/text-media-paragraph/TextMediaParagraphCopy.vue';

export default () => ({
  components: {
    'apo-text-media-paragraph-headline': TextMediaParagraphHeadline,
    'apo-text-media-paragraph-sub-headline': TextMediaParagraphSubHeadline,
    'apo-text-media-paragraph-media-slot': TextMediaParagraphMediaSlot,
    'apo-text-media-paragraph-copy': TextMediaParagraphCopy,
  },
  computed: {
    headline() {
      return get(this.textMediaParagraph, 'headline', '');
    },
    subheadline() {
      return get(this.textMediaParagraph, 'subheadline', '');
    },
    copy() {
      return get(this.textMediaParagraph, 'copy', '');
    },
    mediaType() {
      return get(this.textMediaParagraph, 'media[0].acf_fc_layout', null);
    },
    hasMedia() {
      return !!get(this.textMediaParagraph, `media.[0]${this.mediaType}`, false);
    },
    media() {
      return get(this.textMediaParagraph, `media[0]${this.mediaType}`, null);
    },
    alignment() {
      return get(this.textMediaParagraph.options, 'alignment', 'left');
    },
    columns() {
      return get(this.textMediaParagraph.options, 'columns', 1);
    },
    size() {
      return get(this.textMediaParagraph.options, 'size', 'default');
    },
    caption() {
      return get(this.textMediaParagraph, 'media_caption', null);
    },
  },
});
