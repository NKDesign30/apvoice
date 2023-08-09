<template>
  <div class="answer-multi-line-question">
    <h4
      class="text-3xl text-gray-900"
      v-html="$options.filters.formatContent(question)"
    />

    <apo-survey-optional-hint v-if="isOptional" />

    <apo-textarea
      class="mt-4 w-full"
      :maxlength="-1"
      :value="value"
      @input="$emit('input', $event)"
    />
  </div>
</template>

<script>

import Textarea from '@/components/form-renderer/Textarea.vue';
import SurveyOptionalHint from '@/components/survey/SurveyOptionalHint.vue';

export default {
  components: {
    'apo-textarea': Textarea,
    'apo-survey-optional-hint': SurveyOptionalHint,
  },

  props: {
    id: {
      type: String,
      required: true,
    },

    question: {
      type: String,
      required: true,
    },

    value: {
      type: String,
      required: true,
    },

    isOptional: {
      type: Boolean,
      default: false,
    },
  },
};

</script>

<style lang="scss" scoped>

.answer-multi-line-question {
  @apply w-full #{!important};
}

</style>
