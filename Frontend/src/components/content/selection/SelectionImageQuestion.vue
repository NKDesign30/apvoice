<template>
  <div class="selection-image-question">
    <div
      class="headline-2 text-center"
      v-html="$options.filters.formatContent(question)"
    />

    <p
      class="selection-image-questions__note mt-6 text-center text-xl desktop:text-base"
      v-text="$t('modules.selection.note')"
    />

    <div class="mt-25 desktop: mt-13 flex">
      <div class="w-6/12 desktop:w-5/12">
        <div
          class="headline-4 text-center"
          v-html="$options.filters.formatContent(answerA.title)"
        />
      </div>
      <div class="mx-2.5 desktop:mx-16 w-0 desktop:w-2/12" />
      <div class="w-6/12 desktop:w-5/12">
        <h4
          class="text-center"
          v-html="$options.filters.formatContent(answerB.title)"
        />
      </div>
    </div>

    <div
      v-if="statusA !== '' && statusB !== ''"
      class="mt-5 flex"
    >
      <div class="mr-2.5 desktop:mr-0 w-6/12 desktop:w-5/12">
        <apo-selection-status-bar :status="statusA" />
      </div>
      <div class="mx-16 w-2/12 hidden desktop:block" />
      <div class="ml-2.5 desktop:ml-0 w-6/12 desktop:w-5/12">
        <apo-selection-status-bar :status="statusB" />
      </div>
    </div>

    <div
      class="flex"
      :class="{ 'mt-7.5': statusA === '' && statusB === '' }"
    >
      <div
        class="selection-image-question-answer mr-2.5 desktop:mr-0"
        :class="{ 'is-disabled': isQuestionAnswered }"
        @click="onAnswer(answerA)"
      >
        <img
          class="w-full h-full object-cover"
          :src="answerA.image.sizes.large"
          :alt="answerA.image.alt"
          :title="answerA.image.title"
        >
      </div>

      <apo-selection-spacer class="mx-16 w-2/12" />

      <div
        class="selection-image-question-answer ml-2.5 desktop:ml-0"
        :class="{ 'is-disabled': isQuestionAnswered }"
        @click="onAnswer(answerB)"
      >
        <img
          class="w-full h-full object-cover"
          :src="answerB.image.sizes.large"
          :alt="answerB.image.alt"
          :title="answerB.image.title"
        >
      </div>
    </div>

    <div class="mt-10 desktop:hidden text-gray-900 font-display text-4xl text-center">
      or
    </div>
  </div>
</template>

<script>

import SelectionQuestion from '@/components/content/selection/mixins';
import SelectionSpacer from '@/components/content/selection/SelectionSpacer.vue';
import SelectionStatusBar from '@/components/content/selection/SelectionStatusBar.vue';

export default {
  components: {
    'apo-selection-spacer': SelectionSpacer,
    'apo-selection-status-bar': SelectionStatusBar,
  },

  mixins: [SelectionQuestion],
};

</script>

<style lang="scss" scoped>

@import '../../../assets/scss/utilities';

.selection-image-question-answer {
  @apply w-6/12;
  @apply shadow;
  @apply cursor-pointer;

  @screen desktop {
    @apply ml-0;
    @apply w-5/12;
  }

  @extend .transition-all;
  @extend .transition-fast;
  @extend .transition-ease;

  &:hover {
    @apply shadow-lg;
  }

  &.is-disabled {
    @apply cursor-not-allowed;
  }
}

</style>
