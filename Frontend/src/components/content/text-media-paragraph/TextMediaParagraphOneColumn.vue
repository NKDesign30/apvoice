<template>
  <div class="text-media-paragraph__one-column">
    <div class="text-media-paragraph__headlines text-center">
      <apo-text-media-paragraph-headline
        v-if="headline"
        :headline="headline"
        class="mb-10 desktop:mb-8"
      />
      <apo-text-media-paragraph-sub-headline
        v-if="subheadline"
        :subheadline="subheadline"
        class="mb-15 desktop:mb-25"
      />
    </div>
    <apo-text-media-paragraph-media-slot
      v-if="hasMedia"
      class="mt-15 desktop:mt-0 w-full desktop:w-10/12 mx-auto"
      :media="media"
      :media-type="mediaType"
      :caption="caption"
      caption-spacings="mb-15 desktop:mb-25"
    />
    <apo-text-media-paragraph-copy
      v-if="copy"
      class="mt-15 desktop:mt-25 w-full"
      :copy="copy"
    />
  </div>
</template>

<script>
import componentsAndComputedProperties from '@/mixins/text-media-paragraph-settings';

export default {
  mixins: [
    componentsAndComputedProperties(),
  ],
  props: {
    textMediaParagraph: {
      type: Object,
      required: true,
    },
  },
};
</script>
