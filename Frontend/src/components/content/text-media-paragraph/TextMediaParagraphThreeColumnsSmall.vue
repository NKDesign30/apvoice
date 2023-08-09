<template>
  <div class="text-media-paragraph__three-columns--small">
    <div class="text-media-paragraph__headlines text-left">
      <apo-text-media-paragraph-headline
        v-if="headline"
        :headline="headline"
        class="mb-10 desktop:mb-5"
      />
      <apo-text-media-paragraph-sub-headline
        v-if="subheadline"
        :subheadline="subheadline"
        class="mb-15 desktop:mb-8"
      />
    </div>
    <div
      class="flex items-start"
    >
      <apo-text-media-paragraph-media-slot
        v-if="hasMedia"
        class="w-1/3"
        :media="media"
        :media-type="mediaType"
        :caption="caption"
        without-caption
      />
      <div
        :class="[ hasMedia ? 'ml-5 w-2/3' : 'w-full']"
      >
        <apo-text-media-paragraph-copy
          v-if="copy"
          class="desktop:mt-5"
          :copy="copy"
        />
      </div>
    </div>
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
