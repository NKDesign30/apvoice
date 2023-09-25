<template>
  <div class="pb-16 survey">
    <div class="px-6 py-6 bg-yellow-200 survey-header tablet:px-0">
      <div class="container flex flex-wrap items-center tablet:justify-start justify-center">
        <!-- eslint-disable max-len -->
        <div class="flex items-center justify-center text-xl font-bold text-yellow-500">
          <apo-icon
            src="time"
            class="w-12 h-12"
          />
          <span
            class="mt-1 -ml-6 whitespace-no-wrap"
            v-text="duration"
          />
        </div>
        <!-- eslint-enable max-len -->

        <div class="tablet:ml-8 text-gray-900">
          <h4
            class="font-bold"
            v-html="$options.filters.formatContent(survey.title)"
          />
          <p :inner-html="interpolate(survey.description) | formatContent" />
        </div>
      </div>
    </div>

    <apo-survey-exit-page
      v-if="isComplete"
      :survey="survey"
    />
    <div
      v-else
      class="survey-body"
    >
      <div class="container mt-16 tablet:mt-24">
        <h3
          class="text-5xl text-center text-gray-900 font-display"
          v-text="$t('general.expertPoints', [survey.points])"
        />
        <span
          class="block text-3xl text-center text-gray-900 font-display"
          v-text="fullDuration"
        />
      </div>

      <apo-progress
        class="mt-8 px-4 tablet:px-0"
        :chapter="chapter"
        :total-chapters="survey.chapters.length"
        :total-questions="totalQuestions"
        :answered-questions="answeredQuestions.length"
        sticky
        @update-chapter="chapter = $event"
      />

      <div class="container mx-auto mt-20 overflow-hidden chapter">
        <div class="flex flex-wrap justify-center">
          <div
            v-for="(question) in currentChapter.questions"
            :key="question.id"
            class="flex flex-wrap items-end justify-center w-full px-4 mb-16 tablet:px-8"
          >
            <component
              :is="getSurveyComponent(question)"
              v-if="question.type !== 'question_cluster'"
              :current-chapter="chapter"
              class="mx-6 text-center my-12"
              v-bind="question"
              :value="question.value"
              @input="onQuestionInput($event, question)"
            />

            <small
              v-if="getError(question) !== false"
              class="error mt-1 text-xs font-bold text-red-500 pin-l w-full text-center"
              v-text="getError(question)"
            />

            <div
              v-if="question.type === 'question_cluster'"
              class="survey-cluster-question w-full my-12"
            >
              <div class="text-center survey-cluster-question__headlines mb-6">
                <h4
                  class="text-3xl text-gray-900"
                  v-text="question.question"
                />
                <p
                  v-if="question.subheadline"
                  class="mt-2 italic text-gray-700 text-lg"
                  v-html="$options.filters.formatContent(question.subheadline)"
                />
              </div>
              <div class="flex flex-wrap justify-center">
                <div
                  v-for="(clusterQuestion) in question.questions"
                  :key="clusterQuestion.id"
                  class="flex flex-wrap items-end justify-center"
                  :class="clusterQuestion.type === 'choice' || clusterQuestion.type === 'choice-multi' ? 'w-full' : 'w-auto'"
                >
                  <div class="mx-6 mb-6 tablet:mb-12 w-full">
                    <component
                      :is="getSurveyComponent(clusterQuestion)"
                      class="text-center"
                      is-cluster="true"
                      v-bind="clusterQuestion"
                      :value="clusterQuestion.value"
                      @input="onQuestionInput($event, clusterQuestion)"
                    />

                    <small
                      v-if="getError(clusterQuestion) !== false"
                      class="error mt-4 text-xs font-bold text-red-500 pin-l block text-center"
                      v-text="getError(clusterQuestion)"
                    />
                  </div>
                </div>
              </div>
            </div>

            <div
              v-if="question.isNested"
              class="w-full"
            >
              <div
                v-for="(nestedQuestion) in question.nestedQuestion"
                :key="nestedQuestion.id"
                class="flex flex-wrap items-end justify-center w-full "
              >
                <div
                  v-if="showNestedQuestion(nestedQuestion, question)"
                  class="w-full px-6 flex justify-center flex-wrap mt-16"
                >
                  <component
                    :is="getSurveyComponent(nestedQuestion)"
                    class="text-center my-12 w-full"
                    v-bind="nestedQuestion"
                    :value="nestedQuestion.value"
                    @input="onQuestionInput($event, nestedQuestion)"
                  />

                  <small
                    v-if="getError(nestedQuestion) !== false"
                    class="error mt-1 text-xs font-bold text-red-500 pin-l"
                    v-text="getError(nestedQuestion)"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap justify-center pb-4">
          <apo-button
            v-if="!isFirstChapter"
            class="mr-6 text-gray-900 button button--naked shadow-hard"
            @click.native="onPreviousButtonClick"
            v-text="$t('general.back')"
          />

          <apo-button
            class="text-white button button--primary shadow-hard-dark"
            @click.native="onNextButtonClick"
            v-text="$t(`general.${isLastChapter ? 'submit' : 'continue'}`)"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import forEach from 'lodash/forEach';
import { mapGetters, mapActions } from 'vuex';
import { SURVEYS_STORE_RESULT } from '@/store/types/action-types';
import Progress from '@/components/ui/Progress.vue';
import SurveyAnswerMultiLineQuestion from '@/components/survey/SurveyAnswerMultiLineQuestion.vue';
import SurveyAnswerSingleLineQuestion from '@/components/survey/SurveyAnswerSingleLineQuestion.vue';
import SurveyRatingQuestion from '@/components/survey/SurveyRatingQuestion.vue';
import SurveyRatingIconsQuestion from '@/components/survey/SurveyRatingIconsQuestion.vue';
import SurveyPromoterScoreQuestion from '@/components/survey/SurveyPromoterScoreQuestion.vue';
import SurveyChoiceQuestion from '@/components/survey/SurveyChoiceQuestion.vue';
import SurveyMatrixQuestion from '@/components/survey/SurveyMatrixQuestion.vue';
import SurveyExitPage from '@/components/survey/SurveyExitPage.vue';
import SurveyChoiceMultiQuestion from '@/components/survey/SurveyChoiceMultiQuestion.vue';
import SurveyTextParagraphQuestion from './SurveyTextParagraphQuestion.vue';
import SurveyMapper from '@/services/mapper/SurveyMapper';
import SurveyValidation from '@/services/survey/SurveyValidation';
import SurveyChapterValidation from '@/services/survey/SurveyChapterValidation';

export default {
  components: {
    'apo-progress': Progress,
    'apo-survey-answer-multi-line-question': SurveyAnswerMultiLineQuestion,
    'apo-survey-answer-single-line-question': SurveyAnswerSingleLineQuestion,
    'apo-survey-choice-question': SurveyChoiceQuestion,
    'apo-survey-matrix-question': SurveyMatrixQuestion,
    'apo-survey-choice-multi-question': SurveyChoiceMultiQuestion,
    'apo-survey-rating-question': SurveyRatingQuestion,
    'apo-survey-rating_icons-question': SurveyRatingIconsQuestion,
    'apo-survey-promoter_score-question': SurveyPromoterScoreQuestion,
    'apo-survey-text-paragraph-question': SurveyTextParagraphQuestion,
    'apo-survey-exit-page': SurveyExitPage,
  },

  props: {
    survey: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      chapter: 1,
      validation: new SurveyValidation(),
      answeredQuestions: [],
      excludedHeadlines: [],
    };
  },

  computed: {
    ...mapGetters(['userId', 'user']),

    duration() {
      const { type, time: amount } = this.survey.duration;

      return this.$tc(`general.time.short.${type}`, amount, { amount });
    },

    fullDuration() {
      const { type, time: amount } = this.survey.duration;

      return this.$tc(`general.time.full.${type}`, amount, { amount });
    },

    currentChapter() {
      return this.survey.chapters[this.chapter - 1];
    },

    isFirstChapter() {
      return this.chapter === 1;
    },

    isLastChapter() {
      return this.chapter === this.survey.chapters.length;
    },

    isComplete() {
      return (this.user.surveyResults[this.survey.id] !== undefined && this.user.surveyResults[this.survey.id].is_complete);
    },

    previousChapterAnswers() {
      if (this.chapter > 1) {
        const previousChapter = this.$store.state.surveys[0].chapters[this.chapter - 2];
        return previousChapter ? previousChapter.questions.map(q => q.value) : [];
      }
      return [];
    },
    totalQuestions() {
      return this.currentChapter.questions.reduce((accumulator, question) => {
        if (question.type === 'rating') {
          return accumulator + question.items.length;
        }
        return accumulator + 1;
      }, 0);
    },
  },

  methods: {
    ...mapActions([SURVEYS_STORE_RESULT]),

    interpolate(text) {
      const replacements = {
        survey_points: this.survey.points,
      };

      forEach(replacements, (value, key) => {
        const regex = new RegExp(`{${key}}`, 'g');

        // eslint-disable-next-line no-param-reassign
        text = text.replace(regex, value);
      });

      return text;
    },
    resetExcludedHeadlines() {
      this.excludedHeadlines = [];
    },
    validateCurrentChapter() {
      this.validation.resetChapter(this.chapter);

      const chapterValidation = new SurveyChapterValidation();

      this.currentChapter.questions.forEach(question => {
        if (question.isOptional) {
          return;
        }

        if (question.type === 'question_cluster') {
          question.questions.forEach(clusterQuestion => {
            if (clusterQuestion.isOptional) {
              return;
            }
            this.validateQuestion(clusterQuestion, chapterValidation);
          });
        } else this.validateQuestion(question, chapterValidation);

        if (question.isNested) {
          question.nestedQuestion.forEach(nestedQuestion => {
            if (nestedQuestion.isOptional || !this.showNestedQuestion(nestedQuestion, question)) {
              return;
            }

            this.validateQuestion(nestedQuestion, chapterValidation);
          });
        }
      });

      this.validation.setChapter(this.chapter, chapterValidation);
    },

    validateQuestion(question, chapterValidation) {
      let isValid = true;

      switch (question.type) {
        case 'choice-multi':
          isValid = question.value.length > 0;
          break;

        case 'rating':
          isValid = question.value.length === question.items.length;
          break;

        case 'matrix':
          isValid = Object.keys(question.value).length === question.sections.length;
          break;

        default:
          isValid = question.value !== undefined && question.value !== '';
      }

      if (!isValid) {
        chapterValidation.add(question.id, this.$t('surveys.messages.questionIsRequired'));
      }
    },

    getError({ id }) {
      if (!this.validation.hasChapter(this.chapter)) {
        return false;
      }

      if (!this.validation.getChapter(this.chapter).has(id)) {
        return false;
      }

      window.setTimeout(() => {
        window.scrollTo({ top: document.getElementsByClassName('error')[0].parentElement.offsetTop - 60, behavior: 'smooth' });
      }, 500);
      return this.validation.getChapter(this.chapter).get(id);
    },

    resetError({ id }) {
      if (!this.validation.hasChapter(this.chapter)) {
        return false;
      }

      return this.validation.getChapter(this.chapter).remove(id);
    },

    getSurveyComponent({ type }) {
      return `apo-survey-${type}-question`;
    },

    onQuestionInput(event, question) {
      if (question.type === 'rating') {
        if (question.value.some(value => value.ratingId === event.item.id)) {
          const index = question.value.findIndex(value => value.ratingId === event.item.id);
          // eslint-disable-next-line no-param-reassign
          question.value[index].value = event.value;
        } else {
          question.value.push({ ratingId: event.item.id, value: event.value });
        }
        this.answeredQuestions.push(event.item.id);
      } else {
        if (this.answeredQuestions.indexOf(question.id) === -1) {
          this.answeredQuestions.push(question.id);
        } else if (!event) {
          this.answeredQuestions = this.answeredQuestions.filter(id => id !== question.id);
        }
        // eslint-disable-next-line no-param-reassign
        question.value = event;
      }
      if (this.validation.hasChapter(this.chapter)) {
        this.validateCurrentChapter();
        this.$forceUpdate();
      }
      if (question.type === 'rating') {
        if (event.value === 1 && !this.excludedHeadlines.includes(question.question)) {
          this.excludedHeadlines.push(question.question);
        } else if (event.value !== 1 && this.excludedHeadlines.includes(question.question)) {
          this.excludedHeadlines = this.excludedHeadlines.filter(headline => headline !== question.question);
        }
      }
    },

    filterQuestionsByRating() {
      if (this.chapter > 1) {
        this.survey.chapters[this.chapter - 1].questions.forEach(question => {
          if (question.type === 'rating') {
            question.items = question.items.filter(item => !this.excludedHeadlines.includes(item.question));
          }
        });
      }
    },


    showNestedQuestion(nestedQuestion, question) {
      return nestedQuestion.parentValue.split(',').find(e => e === question.value || (typeof question.value === 'object' && question.value.some(val => val.value === e || val === e)));
    },

    onPreviousButtonClick() {
      if (!this.isFirstChapter) {
        this.chapter = this.chapter - 1;
      }
    },

    onNextButtonClick() {
      this.resetExcludedHeadlines();
      this.validateCurrentChapter();

      if (this.validation.hasChapter(this.chapter)
&& !this.validation.getChapter(this.chapter).isValid) {
        this.$forceUpdate();
        return;
      }

      // Überprüfen und speichern der Überschriften von Fragen mit der Bewertung "1"
      this.currentChapter.questions.forEach(question => {
        if (question.type === 'rating' && question.value === 1) {
          this.excludedHeadlines.push(question.question);
        }
      });

      // Fragen basierend auf den Bewertungen filtern
      this.filterQuestionsByRating();

      // Antworten des aktuellen Kapitels im Vuex-Store speichern
      this.$store.commit('UPDATE_SURVEY_ANSWERS', {
        chapterId: this.chapter,
        answers: this.currentChapter.questions.map(q => q.value),
      });

      // Fortfahren zum nächsten Kapitel oder Abschluss des Fragebogens
      if (this.isLastChapter) {
        const params = {
          user_id: String(this.userId),
          survey_id: String(this.survey.id),
        };

        this[SURVEYS_STORE_RESULT](SurveyMapper.createSurveyPayload(this.survey, params))
          .then(survey => {
            this.user.surveyResults[survey.id] = { is_complete: survey.is_complete, result: survey.result };
          })
          .catch(error => {
            console.log('error storing result', error);
          });

        return;
      }

      this.chapter = this.chapter + 1;
    },


  },
};

</script>

<style lang="scss" scoped>

.survey__duration--position {
  top: 23%;
  left: 30%;
}

</style>
