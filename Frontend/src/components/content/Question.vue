<template>
  <div class="question container">
    <div class="question__head mb-17 tablet:mb-13 text-center">
      <h2 v-html="$options.filters.formatContent(computedQuestion)" />
      <small
        v-if="componentKey === 'multiple-answers'"
        v-text="$t('modules.question.multipleAnswersHint')"
      />
      <h4
        class="mt-10 tablet:mt-8"
        v-html="$options.filters.formatContent(subheadline)"
      />
    </div>
    <div
      v-if="componentExists"
      class="question__module"
    >
      <component
        :is="componentName"
        :options="options"
        :response-messages="responseMessages"
        @input="onSubmitAnswer"
      />
    </div>
    <small
      v-if="isMissing"
      class="mt-4 block text-center text-red-500 text-xs font-bold"
      v-text="$t('trainings.messages.questionIsRequired')"
    />
  </div>
</template>

<script>
import get from 'lodash/get';
import { mapGetters } from 'vuex';
import TrainingService from '@/services/api/TrainingService';
import QuestionChoice from '@/components/content/question/QuestionChoice.vue';
import QuestionRating from '@/components/content/question/QuestionRating.vue';
import QuestionMultipleAnswers from '@/components/content/question/QuestionMultipleAnswers.vue';

export default {

  inject: ['trainingsState'],

  components: {
    'apo-question-choice': QuestionChoice,
    'apo-question-rating': QuestionRating,
    'apo-question-multiple-answers': QuestionMultipleAnswers,
  },

  props: {
    question: {
      type: Object,
      required: true,
    },
    parentId: {
      type: Number,
      required: false,
      default: null,
    },
  },

  data() {
    return {
      isMissing: false,
    };
  },

  computed: {
    ...mapGetters(['userId', 'training', 'lesson']),

    computedQuestion() {
      return get(this.question, 'question', '');
    },
    subheadline() {
      return get(this.question, 'subheadline', '');
    },
    componentKey() {
      return get(this.question, 'answer_options[0].acf_fc_layout', null).toLowerCase().replace(/[_\s]/g, '-');
    },
    componentName() {
      return `apo-question-${this.componentKey}`;
    },
    componentExists() {
      return this.componentName in this.$options.components;
    },
    options() {
      if (this.componentKey === 'choice') {
        return [
          get(this.question, 'answer_options[0].option_1', {}),
          get(this.question, 'answer_options[0].option_2', {}),
        ];
      }
      return get(this.question, 'answer_options[0].options', []);
    },
    responseMessages() {
      if (this.componentKey !== 'choice') {
        return get(this.question, 'answer_options[0].response_messages', []);
      }
      return null;
    },
  },

  watch: {
    // eslint-disable-next-line func-names
    'trainingsState.currentMissingElement': function (elementId) {
      if (elementId === this.question.id && this.isRequiredQuestionModule()) {
        this.isMissing = true;
        setTimeout(() => {
          this.$el.scrollIntoView({
            behavior: 'smooth',
          });
        }, 800);
      }
    },
  },

  methods: {
    onSubmitAnswer(answer) {
      this.isMissing = false;

      // console.log(this.training);
      // console.log(this.lesson);

      const payload = {
        user_id: this.userId,
        training_id: this.training.id,
        question_id: this.question.id,
        lesson_id: this.lesson.lesson_id,
        question_type: this.componentKey,
        result: [{
          question: this.question.question,
          user_answer: answer,
          question_type: this.componentKey,
        }],
      };

      // returns a promise
      TrainingService.storeQuestionResult(payload)
        .then(() => {
          if (this.isRequiredQuestionModule()) {
            const elementIndex = this.trainingsState.requiredElements
              .findIndex(element => element.question_id === this.question.id);
            this.trainingsState.requiredElements[elementIndex].hasSubmitted = true;
          }
        })
        .catch(() => {
          this.isMissing = true;
        });
    },

    isRequiredQuestionModule() {
      // add required questions module keys to array
      // actual only rating question module is always required
      return ['rating'].indexOf(this.componentKey) !== -1;
    },

  },

  created() {
    if (this.isRequiredQuestionModule()) {
      this.trainingsState.requiredElements.push({
        pageIndicatorId: this.parentId,
        question_id: this.question.id,
        hasSubmitted: false,
      });
    }
  },
};

</script>

<style lang="scss" scoped>

/* Component Styles */

</style>
