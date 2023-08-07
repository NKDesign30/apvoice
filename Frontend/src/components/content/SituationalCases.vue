<template>
  <div
    v-observe-visibility="{
      callback: visibilityChanged,
      once: true,
    }"
    class="container situational-cases"
  >
    <apo-situational-cases-head
      :headline="headline"
      :subheadline="subheadline"
    />

    <div v-if="showContent">
      <div
        v-if="isAnswerTrue"
        class="text-center situational-cases__success-icon-wrapper my-7"
      >
        <apo-icon
          src="radio_checked"
          class="w-20 h-20"
        />
      </div>
      <apo-cms-content-renderer
        :components="currentContent"
        class="pt-20"
      />
      <div class="text-center situational-cases__button-wrapper mt-7">
        <apo-button
          class="button button--primary invert button--tiny shadow-hard"
          @click="onUpdateCase"
          v-text="buttonLabel"
        />
      </div>
    </div>
    <template v-else>
      <apo-situational-cases-conversation
        :background-image="backgroundImage"
        :avatars="avatars"
        :first-speaker="firstSpeaker"
        :speech-bubbles="speechBubbles"
        :start-timeout="startTimeouts"
      />
      <apo-situational-cases-quiz
        v-if="currentCase.question && currentCase.answerOptions.length > 0"
        :situational-case-item="currentCase"
        :validation="quizValidation"
        @process-answer="onProcessAnswer"
      />
    </template>
  </div>
</template>

<script>

import get from 'lodash/get';
import SituationalCasesHead from '@/components/content/situational-cases/SituationalCasesHead.vue';
import SituationalCasesConversation from '@/components/content/situational-cases/SituationalCasesConversation.vue';
import SituationalCasesQuiz from '@/components/content/situational-cases/SituationalCasesQuiz.vue';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

export default {

  components: {
    'apo-situational-cases-head': SituationalCasesHead,
    'apo-situational-cases-conversation': SituationalCasesConversation,
    'apo-situational-cases-quiz': SituationalCasesQuiz,
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  props: {
    situational_cases: {
      type: Object,
      required: false,
      default: () => {},
    },
  },

  data() {
    return {
      case: 1,
      showContent: false,
      currentContent: [],
      currentAnswerId: null,
      quizValidation: true,
      isAnswerTrue: false,
      startTimeouts: false,
    };
  },

  computed: {
    headline() {
      return this.situational_cases.globals.headline;
    },

    subheadline() {
      return this.situational_cases.globals.subheadline;
    },

    backgroundImage() {
      return get(this.situational_cases, 'globals.background_image', {});
    },

    avatars() {
      return this.situational_cases.globals.avatars;
    },

    finishPage() {
      return this.situational_cases.finish_page.finish_page;
    },

    cases() {
      return this.situational_cases.situational_cases_items
        .flatMap(item => item.situational_case_item)
        .map(item => {
          /* eslint-disable no-param-reassign */
          item.answerOptions = [];
          if (item.answer_option_group_1.answer) {
            item.answerOptions.push(item.answer_option_group_1);
          }
          if (item.answer_option_group_2.answer) {
            item.answerOptions.push(item.answer_option_group_2);
          }
          // delete item.answer_option_group_1;
          // delete item.answer_option_group_2;
          return item;
          /* eslint-enable no-param-reassign */
        });
    },

    currentCase() {
      return this.cases[this.case - 1];
    },

    firstSpeaker() {
      return this.currentCase.first_speaker;
    },

    speechBubbles() {
      return this.currentCase.speech_bubbles;
    },

    isFirstCase() {
      return this.case === 1;
    },

    isLastCase() {
      return this.case === this.cases.length;
    },

    isFinishPage() {
      return this.currentContent === this.finishPage;
    },

    buttonLabel() {
      return this.isFinishPage ? this.$t('general.restart') : this.$t('general.continue');
    },
  },

  methods: {
    onProcessAnswer(answerId) {
      if (!answerId) {
        this.quizValidation = false;
        return;
      }
      this.quizValidation = true;
      const currentAnswer = this.currentCase.answerOptions
        .find(option => option.answer_id === answerId);
      this.currentContent = currentAnswer.content || [];
      this.isAnswerTrue = currentAnswer.is_true;
      this.showContent = true;
      this.$nextTick(() => {
        this.$scrollTo(this.$el, 200);
      });
    },
    onUpdateCase() {
      this.isAnswerTrue = false;
      if (this.isFinishPage) {
        this.restart();
        return;
      }
      if (this.isLastCase) {
        this.currentContent = this.finishPage || [];
        return;
      }
      this.showContent = false;
      this.case += 1;
      this.restartTimeouts();
    },
    restart() {
      this.case = 1;
      this.showContent = false;
      this.currentContent = [];
      this.restartTimeouts();
    },
    restartTimeouts() {
      this.startTimeouts = false;
      this.$nextTick(() => {
        this.startTimeouts = true;
      });
    },
    // eslint-disable-next-line no-unused-vars
    visibilityChanged(isVisible, entry) {
      if (isVisible) {
        this.startTimeouts = true;
      }
    },
  },
};
</script>
