<template>
  <!--eslint-disable max-len -->
  <div class="training-success-page">
    <apo-user-dashboard>
      <template #logo>
        <img
          v-if="logo"
          class="training-success-page__logo logo"
          :src="logo"
          :alt="logoAlt"
        >
      </template>
      <template #head>
        <h2 class="container -mt-24 text-3xl font-bold tablet:text-6xl">
          {{ success.title }}
        </h2>
      </template>
      <template #profile>
        <apo-training-overview-user-dashboard-training-activity />
      </template>
      <template #body>
        <h3 class="mb-4 text-3xl">
          {{ success.success_message }}
        </h3>
        <div class="text-xl description">
          <p>
            {{ success.copy_success_message }}
          </p>
        </div>
        <div class="mt-8 training-success-page__cta-button">
          <router-link
            v-if="!complete"
            :to="{
              name: origin,
              params: {
                series_slug: currentTrainingSeries.slug,
                training_slug: training.slug,
                lesson_id: nextLesson.lesson_id
              }
            }"
            tag="apo-button"
            class="text-white button--tiny shadow-hard-dark training-success-continue button-class"
            v-text="
              $t('trainings.buttons.continueWithLesson', { lesson: nextLesson.meta_infos.title })
            "
          />
          <apo-button
            v-else
            class="text-white  button--tiny shadow-hard-dark training-success-certificate button-class"
            @click="download(training)"
            v-text="$t('trainings.yourCertificate')"
          />
        </div>
      </template>
    </apo-user-dashboard>
    <div class="container py-12 mx-auto text-center training-sucess-page__copy">
      <p>{{ success.copy }}</p>
      <div
        v-if="complete"
        class="mt-6 training-sucess-page__summary-btn"
      >
        <router-link
          :to="{
            name: 'training-summary',
            params: { slug: slug, id: trainingSeriesId, theme: theme, origin: origin }
          }"
          tag="apo-button"
          class="text-white button--tiny shadow-hard-dark training-success-summary button-class"
          v-text="$t('general.summary')"
        />
      </div>
    </div>
    <div class="px-4 py-6 mb-4 training-teaser tablet:px-0">
      <div class="container training-teaser__item">
        <apo-training-lesson-list
          :lessons="training.lessons"
          :seriesslug="currentTrainingSeries.slug"
          :trainingslug="training.slug"
          without-body
        />
      </div>
    </div>
    <div class="container pb-12 mx-auto text-center training-sucess-page__hint">
      <p
        v-if="success.footer_copy"
        class="mb-4"
      >
        {{ success.footer_copy }}
      </p>
      <template v-if="complete">
        <p
          class="mb-4"
          v-text="$t('trainings.successPage.hint.nextTraining')"
        />
        <router-link
          :to="{ name: origin }"
          tag="apo-button"
          class="text-white  button--tiny shadow-hard-dark training-success-nextTraining button-class"
          v-text="$t('trainings.buttons.nextTraining')"
        />
        <div
          id="related"
        >
          <h3
            v-if="!isAllRelatedcomplete"
            class="mt-10 mb-10 text-gray-700"
          >
            Related Trainings
          </h3>
          <h3
            v-if="isAllRelatedcomplete"
            class="mt-10 mb-10 text-gray-700"
            v-text="$t('trainings.successPage.hint.latestIncompleteT')"
          />
          <div
            v-for="(training, index) in this.currentTrainingSeries.related"
            v-if="!isAllRelatedcomplete"
            :key="index"
          >
            <related-training
              :current-training="training"
              :theme="theme"
            />
          </div>
          <div
            v-if="isAllRelatedcomplete"
            class="flex flex-col w-full pb-5 mb-5 border-b-2 text-left"
          >
            <single-training
              :training="LatestIncompleteTrainings[0]"
              :theme="theme"
              :relation="false"
            />
          </div>
        </div>
      </template>
      <template v-else>
        <p v-text="$t('trainings.successPage.hint.noTime')" />
        <p>
          <span
            class="mr-1"
            v-text="$t('trainings.successPage.hint.readHere')"
          />
          <router-link
            class="inline-block underline training-success-summary"
            :to="{ name: 'training-summary', params: { slug: slug, id: trainingSeriesId } }"
            v-text="$t('general.summary')"
          />
        </p>
        <router-link
          :to="{ name: origin }"
          class="inline-block mt-4 underline training-success-abort"
          v-text="$t('general.abort')"
        />
      </template>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import get from 'lodash/get';
import { TRAININGS_UPDATE_CURRENT_TRAINING } from '@/store/types/action-types';
import TrainingTeaserLessonList from '@/components/training/teaser/TrainingTeaserLessonList.vue';
import UserDashboard from '@/components/ui/UserDashboard.vue';
import downloadCertificate from '@/mixins/download-certificate';
import SurveyService from '@/services/api/SurveyService';
import SurveyAvailableListItem from '@/components/survey/overview/SurveyAvailableListItem.vue';
import TrainingOverviewUserDashboardTrainingActivity from '@/components/training/overview/TrainingOverviewUserDashboardTrainingActivity.vue';
import TrainingOverviewSurveyTeaser from '@/components/training/overview/TrainingOverviewSurveyTeaser.vue';
import { canonicalTag } from '@/services/utils';
import relatedTrainings from '@/components/V2/training/RelatedTrainings.vue';
import training from '@/components/V2/training/training.vue';

export default {
  components: {
    'apo-training-lesson-list': TrainingTeaserLessonList,
    'apo-user-dashboard': UserDashboard,
    'apo-survey-available-list-item': SurveyAvailableListItem,
    'apo-training-overview-user-dashboard-training-activity': TrainingOverviewUserDashboardTrainingActivity,
    'apo-training-overview-survey-teaser': TrainingOverviewSurveyTeaser,
    'related-training': relatedTrainings,
    'single-training': training,
  },

  mixins: [downloadCertificate()],

  props: {
    origin: {
      type: String,
      required: true,
      validator(value) {
        return ['scientific', 'trainings'].includes(value);
      },
    },
  },

  data() {
    return {
      survey: null,
      second_survey: null,
    };
  },

  head() {
    return {
      title: {
        inner: this.$t('pages.trainings.success.meta.title'),
      },
      link: [canonicalTag(this.$route)],
    };
  },

  computed: {
    ...mapGetters([
      'training',
      'lesson',
      'currentTrainingSeries',
      'user',
      'theme',
      'trainingSeries',
      'language',
    ]),

    // do not name this property isComplete, it comes to clashes with the downloadCertificate mixin
    complete() {
      return Boolean(
        this.user.trainingResults[this.training.id]
          && this.user.trainingResults[this.training.id].is_complete === '1',
      );
    },
    LatestIncompleteTrainings() {
      return this.trainingSeries
        .filter(
          item => item.trainings.length > 0
            && parseInt(item.trainings[0].isPremium) === 0
            && !this.istrainingcomplete(item),
        )
        .sort((a, b) => this.sortTrainings(a, b));
    },
    isAllRelatedcomplete() {
      if (this.currentTrainingSeries.related.length == 0) {
        return 1;
      }
      let check = 0;
      /* this.currentTrainingSeries.related.forEach(item => {
        this.istrainingcomplete(item) ? (check = 1) : "";
      }); */
      for (let i = 0; i < this.currentTrainingSeries.related.length; i++) {
        this.istrainingcomplete(this.currentTrainingSeries.related[i]) ? (check = 1) : '';
      }
      if (check == 0) {
        return 1;
      }
      return 0;
    },
    success() {
      if (this.complete) {
        return this.currentTrainingSeries.finishPage;
      }
      return this.lesson.success_page;
    },
    logo() {
      return get(this.success, 'logo.sizes.large', false);
    },
    logoAlt() {
      return get(this.success, 'logo.alt', '');
    },
    slug() {
      return this.$route.params.slug;
    },
    trainingSeriesId() {
      return this.training.trainingSeriesId;
    },
    nextLesson() {
      return this.training.lessons.find(
        lesson => !(
          this.user.trainingResults[lesson.training_id]
            && this.user.trainingResults[lesson.training_id].completed_lessons[lesson.lesson_id]
        ),
      );
    },
    // this property is necessary for the downloadCertificate mixin
    currentTrainingId() {
      return this.training.id;
    },
    hasActivatableSurvey() {
      return false && !!parseInt(this.training.globals.survey_relation.has_activatable_survey, 10);
    },
    getSurveyId() {
      return this.training.globals.survey_relation.survey;
    },
    getSecondSurveyId() {
      return this.training.globals.survey_relation.second_survey;
    },
  },
  watch: {
    $route: {
      immediate: true,
      handler(route) {
        if (route.params.id) {
          this[TRAININGS_UPDATE_CURRENT_TRAINING](route.params);
        }
      },
    },
  },

  methods: {
    ...mapActions([TRAININGS_UPDATE_CURRENT_TRAINING]),
    istrainingcomplete(item) {
      return Boolean(
        this.user.trainingResults[item.id] && this.user.trainingResults[item.id].is_complete === '1',
      );
    },
    sortTrainings(a, b) {
      {
        const trainingResultA = this.user.trainingResults[a.trainings[0].id];
        const trainingResultB = this.user.trainingResults[b.trainings[0].id];

        if (parseInt(a.informations.boost) < parseInt(b.informations.boost)) {
          console.log('ok');
          return 1;
        }

        // first - put first those for which there no training result
        if (trainingResultA !== undefined && trainingResultB === undefined) {
          return 1;
        }
        if (trainingResultB !== undefined && trainingResultA === undefined) {
          return -1;
        }
        if (trainingResultA !== undefined && trainingResultB !== undefined) {
          // both trainings started => check for completion: first incomplete
          if (trainingResultB.is_complete === '0' && trainingResultA.is_complete === '1') {
            return 1;
          }
          if (trainingResultB.is_complete === '1' && trainingResultA.is_complete === '0') {
            return -1;
          }
          if (trainingResultB.is_complete === '1' && trainingResultA.is_complete === '1') {
            // both complete - order does not matter (completion date not available)
            return 1;
          }
          if (trainingResultB.is_complete === '0' && trainingResultA.is_complete === '0') {
            // neither complete => lessons completed?
            const lessonsCompletedA = trainingResultA.completed_lessons.length;
            const lessonsCompletedB = trainingResultA.completed_lessons.length;
            if (lessonsCompletedA > lessonsCompletedB) {
              return 1;
            }
            if (lessonsCompletedA >= lessonsCompletedB) {
              // same number of lessons done - order does not matter
              return -1;
            }
          }
        } else if (trainingResultA === undefined && trainingResultB === undefined) {
          // neither training started - order does not matter
          return -1;
        }
      }
    },
  },

  created() {
    if (this.hasActivatableSurvey) {
      SurveyService.fetch(this.getSurveyId).then(survey => {
        this.survey = survey;
      });
      if (this.getSecondSurveyId) {
        SurveyService.fetch(this.getSecondSurveyId).then(survey => {
          this.second_survey = survey;
        });
      }
    }
  },
};
</script>

<style lang="scss" scoped>
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
