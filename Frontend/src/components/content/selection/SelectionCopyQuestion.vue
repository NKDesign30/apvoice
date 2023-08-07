<template>
  <div class="selection-copy-question">
    <div
      class="headline-2 text-center"
      v-html="$options.filters.formatContent(question)"
    />

    <p
      class="selection-copy-questions__note mt-6 text-center text-xl desktop:text-base"
      v-text="$t('modules.selection.note')"
    />

    <div
      v-if="statusA !== '' && statusB !== ''"
      class="mt-20 flex"
    >
      <div class="flex-1">
        <apo-selection-status-bar :status="statusA" />
      </div>
      <div class="mx-2.5 desktop:mx-16 w-0 desktop:w-2/12" />
      <div class="flex-1">
        <apo-selection-status-bar :status="statusB" />
      </div>
    </div>

    <div
      class="flex"
      :class="{ 'mt-23': statusA === '' && statusB === '' }"
    >
      <div
        class="selection-copy-question-answer mr-2.5 desktop:mr-0"
        :class="{ 'is-disabled': isQuestionAnswered }"
        @click="onAnswer(answerA)"
        v-html="$options.filters.formatContent(answerA.copy)"
      />

      <apo-selection-spacer class="mx-16 w-2/12" />

      <div
        class="selection-copy-question-answer ml-2.5 desktop:ml-0"
        :class="{ 'is-disabled': isQuestionAnswered }"
        @click="onAnswer(answerB)"
        v-html="$options.filters.formatContent(answerB.copy)"
      />
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

.selection-copy-question-answer {
  @apply flex;
  @apply flex-1;
  @apply py-4;
  @apply px-3;
  @apply cursor-pointer;
  @apply bg-gray-100;
  @apply text-sm;

  p {
    @apply self-center;
  }

  &:hover {
    @apply bg-blue-100;
  }

  &.is-disabled {
    @apply cursor-not-allowed;
  }

  @screen tablet {
    @apply text-lg;
     @apply px-6;
  }

  @screen desktop {
    @apply text-base;
     @apply px-6;

    &.is-short-answer {
      @apply text-2xl;
    }
  }
}

</style>
