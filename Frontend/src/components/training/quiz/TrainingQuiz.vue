<template>
  <div class="p-12 mt-24 training-quiz force-full-width background-class">
    <div
      v-if="headline || subheadline"
      class="container text-gray-900 training-quiz__headlines mb-7"
    >
      <h2
        class="text-center"
        v-html="$options.filters.formatContent(headline)"
      />

      <h3
        v-if="subheadline"
        class="mt-6 text-center"
        v-html="$options.filters.formatContent(subheadline)"
      />
    </div>
    <div class="container training-quiz__body">
      <apo-training-quiz-item
        :quiz="currentChapter"
        :is-last-chapter="isLastChapter"
        @submit-answer="processAnswer"
        @update-chapter="updateChapter"
      >
        <apo-progress
          class="mt-4"
          :chapter="chapter"
          :total-chapters="chapters.length"
          :interactive="false"
        />
      </apo-training-quiz-item>
      <apo-references
        class="mt-8"
        :references="currentChapter.references"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
import {
  AUTH_UPDATE_USER,
  TRAININGS_UPDATE_ONE_TRAINING_SERIES,
} from '@/store/types/mutation-types';
import { AUTH_FETCH_CURRENT_USER, AUTH_FETCH_USER_LEVEL_DATA } from '@/store/types/action-types';
import TrainingQuizItem from '@/components/training/quiz/TrainingQuizItem.vue';
import Progress from '@/components/ui/Progress.vue';
import TrainingMapper from '@/services/mapper/TrainingMapper';
import TrainingService from '@/services/api/TrainingService';
import TrainingSeriesService from '@/services/api/TrainingSeriesService';

export default {
  inject: ['pageIndicatorsState', 'trainingsState'],

  components: {
    'apo-training-quiz-item': TrainingQuizItem,
    'apo-progress': Progress,
  },
  props: {
    trainingSeriesId: {
      required: true,
      validator: prop => typeof prop === 'number' || prop === null,
    },
    trainingId: {
      required: true,
      validator: prop => typeof prop === 'number' || prop === null,
    },
    lesson_id: {
      type: String,
      required: true,
    },
    headline: {
      type: String,
      required: false,
      default: '',
    },
    subheadline: {
      type: String,
      required: false,
      default: '',
    },
    chapters: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      chapter: 1,
      answers: [],
    };
  },
  computed: {
    ...mapGetters(['userId', 'user']),

    currentChapter() {
      return this.chapters[this.chapter - 1];
    },

    isFirstChapter() {
      return this.chapter === 1;
    },

    isLastChapter() {
      return this.chapter === this.chapters.length;
    },
  },
  methods: {
    ...mapMutations([AUTH_UPDATE_USER, TRAININGS_UPDATE_ONE_TRAINING_SERIES]),

    processAnswer(answer) {
      const currentAnswer = {
        ...answer,
        chapter: {
          id: this.currentChapter.id,
          chapter: this.chapter,
        },
      };
      this.answers.push(currentAnswer);
    },
    updateChapter() {
      if (this.isLastChapter) {
        this.checkRequirements();
        return;
      }
      this.chapter += 1;
    },
    checkRequirements() {
      if (this.hasRequiredElementsFilled()) {
        this.storeAnswers();
      }
    },
    hasRequiredElementsFilled() {
      const element = this.trainingsState.requiredElements.find(
        state => !state.hasSubmitted,
      );
      if (element) {
        this.pageIndicatorsState.activePageIndicator = element.pageIndicatorId;
        this.trainingsState.currentMissingElement = element.question_id;
        return false;
      }
      return true;
    },
    storeAnswers() {
      // eslint-disable-next-line camelcase
      const { id, lesson_id } = this.$route.params;
      const params = {
        user_id: this.userId,
        training_id: this.trainingId,
        lesson_id,
        training_series_id: this.trainingSeriesId,
      };
      this.$store.dispatch('wait/start', 'submitTrainingQuiz', { root: true });
      TrainingService.storeLessonResults(
        TrainingMapper.createPayload(this.answers, params),
      )
        .then(response => {
          const copiedUser = this.user;
          const completedLessons = {};
          response.result.forEach(item => {
            completedLessons[item.lesson_id] = item.lesson_id;
          });
          copiedUser.trainingResults[response.training_id] = {
            is_complete: response.is_complete,
            completed_lessons: completedLessons,
          };
          this[AUTH_UPDATE_USER](copiedUser);
          //this[AUTH_FETCH_USER_LEVEL_DATA](); // update user's points earned - ApoUserLevels plugin
          this.$store.dispatch(AUTH_FETCH_CURRENT_USER);

          TrainingSeriesService.fetch(this.trainingSeriesId).then(
            trainingSeries => {
              this[TRAININGS_UPDATE_ONE_TRAINING_SERIES](trainingSeries);
              this.$store.dispatch('wait/end', 'submitTrainingQuiz', { root: true });
              this.$store.dispatch(AUTH_FETCH_USER_LEVEL_DATA, {})
              this.$router.push({
                name: 'training-success-page',
                params: {
                  slug: trainingSeries.slug,
                  series_id: this.trainingSeriesId,
                  id,
                  lesson_id,
                  origin: this.$route.name
                },
              });
            },
          );
        })
        .catch(error => {
          this.$store.dispatch('wait/end', 'submitTrainingQuiz', { root: true });
          console.log('error storing training lesson result', error);
        });
    },
  },
  destroyed() {
    this.answers = [];
    this.chapter = 1;
  },
};
</script>

<style lang="scss" scoped>
  .force-full-width {
    margin-left: calc(-50vw + 50%);
    width: 100vw;
  }

  .theme-training {
    .background-class {
      @apply bg-training-50;
    }
  }
  .theme-scientific {
    .background-class {
      @apply bg-scientific-50;
    }
  }
</style>
