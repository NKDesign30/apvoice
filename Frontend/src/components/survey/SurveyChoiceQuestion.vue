<template>
  <div class="survey-choice-question">
    <div class="survey-choice-question__headlines">
      <h4
        class="text-3xl text-gray-900"
        v-html="$options.filters.formatContent(question)"
      />
    </div>

    <apo-survey-optional-hint v-if="isOptional" />

    <div
      class="mt-8 flex flex-wrap justify-between"
      :class="{'flex-no-wrap' : choices.length <= 2 }"
    >
      <apo-survey-choice-button
        v-for="choice in choices"
        :key="choice.id"
        class="mb-6"
        :class="{'mx-1' : choices.length <= 2 }"
        :is-active="choice.value === selectedChoice"
        :title="choice.tooltip"
        @click="setSelectedChoice(choice)"
      >
        {{ choice.value }}
      </apo-survey-choice-button>
    </div>
  </div>
</template>

<script>

import SurveyChoiceButton from '@/components/survey/SurveyChoiceButton.vue';
import SurveyOptionalHint from '@/components/survey/SurveyOptionalHint.vue';

export default {
  components: {
    'apo-survey-choice-button': SurveyChoiceButton,
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

    choices: {
      type: Array,
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

  data() {
    return {
      selectedChoice: '',
    };
  },

  watch: {
    value: {
      immediate: true,
      handler(newValue) {
        this.selectedChoice = newValue;
      },
    },
  },

  methods: {
    setSelectedChoice(choice) {
      this.selectedChoice = choice.value;

      this.$emit('input', this.selectedChoice);
    },
  },
};

</script>

<style lang="scss" scoped>

.survey-choice-question {
  @apply w-full #{!important};

  .survey-cluster-question &{

    &__headlines{
      h4{
        @apply text-xl;
      }
      p{
        @apply mt-0;
      }
    }
  }
}

</style>
