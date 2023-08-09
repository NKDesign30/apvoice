<template>
  <div class="selection">
    <template v-if="currentQuestionIndex <= questions.length - 1">
      <transition
        name="fade"
        mode="out-in"
      >
        <component
          :is="resolveQuestionComponentName(currentQuestion)"
          v-if="Object.keys(result).length > 0"
          :key="`question-${currentQuestionIndex}`"
          v-model="result[currentQuestionIndex]"
          :answer-a="currentQuestion.answer_a"
          :answer-b="currentQuestion.answer_b"
          class="container"
          :is-disabled="isCurrentQuestionAnswered"
          :question="currentQuestion.question"
          @answered="onAnswered"
        />
      </transition>

      <apo-selection-progress
        v-if="hasMultipleQuestions"
        class="mt-10 desktop:mt-13"
        :current="currentQuestionIndex + 1"
        :is-current-question-answered="isCurrentQuestionAnswered"
        :total="questions.length"
        @back="onBack"
        @next="onNext"
      />
    </template>
    <apo-selection-result
      v-else
      :result="result"
      :content="resultPageContent"
      @restart="onRestart"
    />
  </div>
</template>

<script>

import transform from 'lodash/transform';
import SelectionCopyQuestion from '@/components/content/selection/SelectionCopyQuestion.vue';
import SelectionImageQuestion from '@/components/content/selection/SelectionImageQuestion.vue';
import SelectionProgress from '@/components/content/selection/SelectionProgress.vue';
import SelectionResult from '@/components/content/selection/SelectionResult.vue';

export default {
  components: {
    'apo-selection-copy-question': SelectionCopyQuestion,
    'apo-selection-image-question': SelectionImageQuestion,
    'apo-selection-progress': SelectionProgress,
    'apo-selection-result': SelectionResult,
  },

  props: {
    selection_items: {
      type: Array,
      default: () => [],
    },

    result_page: {
      type: [Array, Boolean],
      default: () => [],
    },
  },

  data() {
    return {
      currentQuestionIndex: 0,
      result: {},
    };
  },

  computed: {
    questions() {
      return this.selection_items;
    },

    resultPageContent() {
      return this.result_page || [];
    },

    currentQuestion() {
      return this.questions[this.currentQuestionIndex];
    },

    isCurrentQuestionAnswered() {
      return this.result[this.currentQuestionIndex]
        && this.result[this.currentQuestionIndex].answer
        && Object.keys(this.result[this.currentQuestionIndex].answer).length > 0;
    },

    hasMultipleQuestions() {
      return this.questions.length > 1;
    },
  },

  watch: {
    selection_items: {
      immediate: true,
      handler() {
        this.$nextTick(() => this.createResult());
      },
    },
  },

  methods: {
    resolveQuestionComponentName(question) {
      return `apo-selection-${question.acf_fc_layout.replace(/_+/g, '-')}`;
    },

    createResult() {
      this.result = transform(this.questions, (result, question, index) => {
        // eslint-disable-next-line no-param-reassign
        result[index] = {
          question: question.question,
          answer: {},
        };
      }, {});
    },

    onBack() {
      if (this.currentQuestionIndex > 0) {
        this.currentQuestionIndex -= 1;
      }
    },

    onNext() {
      if (this.nextTimer) {
        clearTimeout(this.nextTimer);
        this.nextTimer = null;
      }

      if (!this.result[this.currentQuestionIndex].answer) {
        return;
      }

      this.currentQuestionIndex += 1;
    },

    onAnswered() {
      this.nextTimer = setTimeout(() => {
        this.onNext();
      }, 3000);
    },

    onRestart() {
      this.createResult();
      this.currentQuestionIndex = 0;
    },
  },
};

</script>

<style lang="scss" scoped>

.fade {
  &-enter-active,
  &-leave-active {
    transition: opacity 0.3s ease;
  }

  &-enter,
  &-leave-to {
    opacity: 0;
  }
}

</style>
