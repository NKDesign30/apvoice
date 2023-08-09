<template>
  <div class="text-media-paragraph container">
    <component
      :is="resolveLayout"
      :text-media-paragraph="text_media_paragraph"
    />
  </div>
</template>

<script>
import get from 'lodash/get';
import TextMediaParagraphOneColumn from '@/components/content/text-media-paragraph/TextMediaParagraphOneColumn.vue';
import TextMediaParagraphTwoColumns from '@/components/content/text-media-paragraph/TextMediaParagraphTwoColumns.vue';
import TextMediaParagraphThreeColumns from '@/components/content/text-media-paragraph/TextMediaParagraphThreeColumns.vue';
import TextMediaParagraphThreeColumnsSmall from '@/components/content/text-media-paragraph/TextMediaParagraphThreeColumnsSmall.vue';

export default {
  components: {
    'apo-text-media-paragraph-one-column': TextMediaParagraphOneColumn,
    'apo-text-media-paragraph-two-columns': TextMediaParagraphTwoColumns,
    'apo-text-media-paragraph-three-columns': TextMediaParagraphThreeColumns,
    'apo-text-media-paragraph-three-columns-small': TextMediaParagraphThreeColumnsSmall,
  },
  props: {
    text_media_paragraph: {
      type: Object,
      required: true,
    },
  },
  computed: {
    columns() {
      return parseInt(get(this.text_media_paragraph.options, 'columns', 1), 10);
    },
    isSmall() {
      return get(this.text_media_paragraph.options, 'size', 'default') === 'small';
    },
    resolveLayout() {
      switch (this.columns) {
        case 1:
          return 'apo-text-media-paragraph-one-column';

        case 2:
          return 'apo-text-media-paragraph-two-columns';

        case 3:
          return this.isSmall
            ? 'apo-text-media-paragraph-three-columns-small' : 'apo-text-media-paragraph-three-columns';

        default:
          return 'apo-text-media-paragraph-one-column';
      }
    },
  },
};
</script>
