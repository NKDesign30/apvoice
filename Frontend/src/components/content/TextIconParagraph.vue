<template>
  <div class="container flex flex-col tablet:flex-row tablet:flex-wrap tablet:justify-end">
    <div
      v-for="(paragraph, index) in paragraphs"
      :key="index"
      class="w-full mb-6 tablet:w-1/2 tablet:px-2"
    >
      <div class="mb-6 text-icon-paragraph">
        <!-- eslint-disable-next-line max-len -->
        <div class="flex items-center p-4 text-2xl text-white bg-blue-600 fill-current text-icon-paragraph__head">
          <img
            :src="paragraph.icon"
            alt=""
            class="w-12 h-auto mr-5"
          >
          <span v-html="$options.filters.formatContent(paragraph.title)" />
        </div>
        <apo-wysiwyg-content
          class="mt-4 text-icon-paragraph__body"
          :content="paragraph.copy"
        />
      </div>
    </div>
  </div>
</template>

<script>
import get from 'lodash/get';

export default {
  props: {
    text_icon_paragraph_item: {
      type: Array,
      required: true,
    },
  },
  computed: {
    paragraphs() {
      return this.text_icon_paragraph_item.map(paragraph => ({
        icon: get(paragraph, 'icon.sizes.large', null),
        title: get(paragraph, 'title', null),
        copy: get(paragraph, 'copy', null),
      }));
    },
  },
};
</script>

<style lang="scss" scoped>

.text-icon-paragraph {
  .theme-survey &__head {
    @apply bg-yellow-500;
  }

  .theme-training &__head {
    @apply bg-training-500;
  }

  .theme-knowledge-base &__head,
  .theme-downloads &__head {
    @apply bg-purple-300;
  }

  .theme-raffle &__head {
    @apply bg-green-400;
  }
}

</style>
