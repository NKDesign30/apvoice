<template>
  <!-- eslint-disable-next-line max-len -->
  <div class="flex flex-col mx-4 training-quiz-item tablet:container tablet:mx-auto font-display tablet:flex-row">
    <div class="w-full mb-6 training-quiz-item__image tablet:w-1/2 tablet:mr-12">
      <img
        :src="quiz.image.url"
        :alt="quiz.image.alt"
      >
      <slot />
    </div>

    <div class="w-full training-quiz-item__body tablet:w-1/3">
      <div class="question">
        <h3
          class="mb-6 text-xl tablet:mb-2 leading-xl tablet:text-2xl tablet:leading-2xl"
          v-html="$options.filters.formatContent(quiz.question)"
        />
      </div>

      <div class="choices">
        <div
          v-for="choice in quiz.choices"
          :key="choice.id"
          class="flex mb-4 choice"
        >
          <div class="flex-shrink-0 mt-4 mr-6">
            <apo-training-quiz-choice-button
              :id="choice.id"
              :answer="userAnswerId"
              :value="choice.id"
              :is-disabled="!canAnswer"
              :validation-class="choice.validationClass"
              @input="userAnswerId = $event"
            />
          </div>
          <div class="flex-1 mt-4">
            <label
              :for="choice.id"
              :class="[canAnswer ? 'cursor-pointer' : 'cursor-not-allowed']"
              v-html="$options.filters.formatContent(choice.value)"
            />
          </div>
        </div>
      </div>

      <small
        v-if="!validation"
        class="mt-4 text-xs font-bold text-red-500"
        v-text="$t('trainings.messages.questionIsRequired')"
      />

      <div class="flex justify-end buttons">
        <apo-button
          v-if="!hasAnswerd"
          class="`button button--tiny shadow-hard text-white button-class"
          @click="validateAnswer"
        >
          <apo-wait for="submitTrainingQuiz">
            <template #waiting>
              <apo-spinner
                size="small"
              />
            </template>
            {{ $t('trainings.buttons.checkAnswer') }}
          </apo-wait>
        </apo-button>

        <apo-button
          v-else
          class="button button--tiny shadow-hard text-white button-class"
          @click="onUpdateChapter"
        >
          <apo-wait for="submitTrainingQuiz">
            <template #waiting>
              <apo-spinner
                size="small"
              />
            </template>
            {{ updateChapterButtonLabel }}
          </apo-wait>
        </apo-button>
      </div>
    </div>
  </div>
</template>

<script>
import TrainingQuizChoiceButton from '@/components/training/quiz/TrainingQuizChoiceButton.vue';

export default {

  components: {
    'apo-training-quiz-choice-button': TrainingQuizChoiceButton,
  },

  props: {
    quiz: {
      type: Object,
      required: true,
    },
    isLastChapter: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      canAnswer: true,
      hasAnswerd: false,
      userAnswerId: null,
      validation: true,
    };
  },
  computed: {
    userAnswer() {
      return this.quiz.choices.find(choice => choice.id === this.userAnswerId);
    },
    correctAnswer() {
      return this.quiz.choices.find(choice => choice.is_true);
    },
    updateChapterButtonLabel() {
      return this.isLastChapter ? this.$t('general.finish') : this.$t('general.next');
    }
  },
  watch: {
    quiz: {
      handler() {
        this.resetQuiz();
      },
    },
  },
  methods: {
    validateAnswer() {
      if (!this.userAnswerId) {
        this.validation = false;
        return;
      }
      this.processAnswer();
    },
    processAnswer() {
      if (!this.correctAnswer) {
        return;
      }

      if (this.userAnswer.id !== this.correctAnswer.id) {
        this.userAnswer.validationClass = 'failed';
        setTimeout(()=>{
          this.userAnswer.validationClass = null;
       },500)
      }
    if (this.userAnswer.id == this.correctAnswer.id) {
       this.correctAnswer.validationClass = 'succeeded';
      this.$emit('submit-answer', this.userAnswer);
      this.disableChoices();
      this.hasAnswerd = true;
      }
 
    },
    onUpdateChapter() {
      this.$emit('update-chapter');
    },
    disableChoices() {
      this.canAnswer = false;
    },
    enableChoices() {
      this.canAnswer = true;
    },
    onChoiceInput() {
      this.validation = true;
    },
    resetQuiz() {
      this.canAnswer = true;
      this.hasAnswerd = false;
      this.userAnswerId = null;
      this.validation = true;
    },
  },

};
</script>

<style lang="scss"  scoped>
.theme-training {
  .button-class {
    @apply bg-training-500;
  }
}
.theme-scientific {
  .button-class {
    @apply bg-scientific-500;
  }
}
</style>
