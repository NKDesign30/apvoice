<template>
  <div class="situational-cases__quiz">
    <div class="situational-cases__question text-center mb-15">
      <h3 v-html="$options.filters.formatContent(question)" />
    </div>
    <div class="situational-cases__answer-options max-w-4xl mx-auto">
      <apo-radio-button-group
        v-model="answer"
        class="flex flex-col"
      >
        <apo-radio-button
          v-for="option in answerOptions"
          :id="option.answer_id"
          :key="option.answer_id"
          :label="option.answer"
          :value="option.answer_id"
          class="flex-1 mb-6"
          @click="$emit('process-answer', option.answer_id)"
        />
      </apo-radio-button-group>
      <small
        v-if="!validation"
        class="mt-4 text-red-500 text-xs font-bold"
        v-text="$t('modules.situationalCases.quiz.missingAnswer')"
      />
    </div>
    <div class="situational-cases__submit-button text-center mt-15">
      <apo-button
        class="button button--primary invert button--tiny shadow-hard"
        @click="$emit('process-answer', answer)"
        v-text="$t('general.submit')"
      />
    </div>
  </div>
</template>

<script>
import RadioButton from '@/components/form/RadioButton.vue';
import RadioButtonGroup from '@/components/form/RadioButtonGroup.vue';

export default {

  components: {
    'apo-radio-button': RadioButton,
    'apo-radio-button-group': RadioButtonGroup,
  },

  props: {
    situationalCaseItem: {
      type: Object,
      required: true,
    },
    validation: {
      type: Boolean,
      required: true,
      default: true,
    },
  },

  data() {
    return {
      answer: '',
    };
  },

  computed: {
    question() {
      return this.situationalCaseItem.question;
    },
    answerOptions() {
      return this.situationalCaseItem.answerOptions;
    },
  },

};
</script>

<style lang="scss" scoped>
  .rounded-tl-4xl {
    border-top-left-radius: 4rem;
  }
</style>
