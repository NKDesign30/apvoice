<template>
  <div class="question__choice">
    <div class="mt-8 flex justify-center">
      <apo-choice-button
        v-for="option in options"
        :key="option.id"
        class="mx-6 mb-6"
        :is-active="option === selectedOption"
        :title="option.value"
        @click="setSelectedOption(option)"
      >
        {{ option.value }}
      </apo-choice-button>
    </div>
    <apo-question-response-message
      v-if="selectedOption && selectedOption.response_message"
      :msg="selectedOption.response_message"
    />
  </div>
</template>

<script>
import ChoiceButton from '@/components/ui/ChoiceButton.vue';
import QuestionResponseMessage from '@/components/content/question/QuestionResponseMessage.vue';

export default {
  components: {
    'apo-choice-button': ChoiceButton,
    'apo-question-response-message': QuestionResponseMessage,
  },

  props: {
    options: {
      type: Array,
      requied: true,
      default: () => [],
    },
    responseMessages: {
      type: Array,
      requied: false,
      default: () => [],
    },
  },

  data() {
    return {
      selectedOption: null,
    };
  },

  methods: {
    setSelectedOption(option) {
      if (this.selectedOption) return;
      this.selectedOption = option;

      this.$emit('input', this.selectedOption);
    },
  },
};

</script>

<style lang="scss" scoped>

.question__choice {
  @apply w-full #{!important};
}

</style>
