export default {
  model: {
    prop: 'answer',
    event: 'answered',
  },

  props: {
    question: {
      type: String,
      required: true,
    },

    answer: {
      type: Object,
      required: true,
    },

    answerA: {
      type: Object,
      default: () => {},
    },

    answerB: {
      type: Object,
      default: () => {},
    },

    isDisabled: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    statusA() {
      if (!this.isQuestionAnswered) {
        return '';
      }

      return this.answerA.is_correct_answer ? 'success' : 'failure';
    },

    statusB() {
      if (!this.isQuestionAnswered) {
        return '';
      }

      return this.answerB.is_correct_answer ? 'success' : 'failure';
    },

    isQuestionAnswered() {
      return Object.keys(this.answer.answer).length > 0;
    },
  },

  methods: {
    onAnswer(answer) {
      this.$emit('answered', {
        answer,
        question: this.question,
      });
    },

    isShortAnswer(answer) {
      return answer.length <= 80;
    },
  },
};
