<template>
  <div class="text-media-paragraph__two-columns">
    <apo-text-media-paragraph-headline
      v-if="headline"
      :headline="headline"
      class="mb-10 text-center"
    />
    <div
      class="flex flex-col items-start tablet:flex-row"
      :class="{ 'tablet:flex-row-reverse' : alignment === 'right'}"
    >
      <apo-text-media-paragraph-media-slot
        v-if="hasMedia"
        class="w-full tablet:w-1/2"
        :media="media"
        :media-type="mediaType"
        :caption="caption"
        caption-spacings="mt-3"
      />
      <div
        :class="[ !hasMedia ? 'w-full' : alignment === 'right' ? 'w-full tablet:mr-10 tablet:w-1/2' : 'w-full tablet:ml-10 tablet:w-1/2' ]"
      >
        <apo-text-media-paragraph-sub-headline
          v-if="subheadline"
          :subheadline="subheadline"
          class="mb-13"
          :class="{ 'mt-3' : hasMedia }"
        />
        <apo-text-media-paragraph-copy
          v-if="copy"
          class="mt-13"
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
