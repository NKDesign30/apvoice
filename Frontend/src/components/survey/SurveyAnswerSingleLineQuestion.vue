<template>
  <div class="answer-single-line-question">
    <h4
      class="text-3xl text-gray-900"
      v-html="$options.filters.formatContent(question)"
    />

    <apo-survey-optional-hint v-if="isOptional" />

    <apo-text-input
      class="mt-4 w-full"
      :value="value"
      @input="$emit('input', $event)"
    />
  </div>
</template>

<script>

import TextInput from '@/components/form-renderer/TextInput.vue';
import SurveyOptionalHint from '@/components/survey/SurveyOptionalHint.vue';

export default {
  components: {
    'apo-text-input': TextInput,
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

.answer-single-line-question {
  @apply w-full #{!important};
}

</style>
