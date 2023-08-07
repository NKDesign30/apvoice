<template>
  <div class="surveys-overview">
    <div class="surveys-body py-32  bg-yellow-100">
      <div
        v-if="availabeSurveys.length > 0"
        class="available-surveys"
      >
        <div class="mb-12 container max-w-4xl mx-auto text-gray-800 text-center">
          <h2
            class="headline-3 mb-8 leading-none tracking-wide"
            v-text="$t('surveys.headlines.availableSurveys')"
          />
          <p
            class="text-2xl"
            v-html="$t('surveys.messages.statusInfo', {
              surveys: availabeSurveys.length,
              points: availabePoints
            })"
          />
        </div>

        <apo-survey-available-list-item
          v-for="survey in surveySlices"
          :key="survey.id"
          :survey="survey"
        />

        <div
          v-if="surveySlices.length < availabeSurveys.length"
          class="text-center text-yellow-500 fill-current"
          @click="loadMoreSurveys"
          v-text="$t('general.showMore')"
        />
      </div>

      <!-- eslint-disable max-len -->
      <div
        v-else
        class="container max-w-4xl mx-auto font-display text-gray-800 text-center"
      >
        <h2
          class="leading-none tracking-wide"
          v-text="$t('surveys.messages.noSurveysAvailable')"
        />
      </div>
      <!-- eslint-enable max-len -->
    </div>

    <!-- eslint-disable max-len -->
    <div class="survey-evaluation py-32 bg-white WAS-GEHT">
      <div class="container mb-8 max-w-4xl mx-auto font-display text-gray-800 text-center">
        <h2
          class="leading-none tracking-wide"
          v-text="$t('surveys.messages.evaluation')"
        />
      </div>

      <div class="mb-8 font-display text-center headline-3">
        <p
          v-if="evaluatedSurveySlices.length <= 0"
          v-text="$t('surveys.messages.noEvaluationsAvailable')"
        />
        <p
          v-else
          v-text="$t('surveys.messages.availabeEvaluations')"
        />
      </div>

      <apo-survey-evaluation-list-item
        v-for="survey in evaluatedSurveySlices"
        :key="survey.id"
        :survey="survey"
      />

      <div
        v-if="evaluatedSurveySlices.length < evaluatedSurveys.length"
        class="text-center text-yellow-500 fill-current"
        @click="loadMoreEvaluatedSurveys"
        v-text="$t('general.showMore')"
      />
    </div>
    <!-- eslint-enable max-len -->
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import SurveyAvailableListItem from '@/components/survey/overview/SurveyAvailableListItem.vue';
import SurveyEvaluationListItem from '@/components/survey/overview/SurveyEvaluationListItem.vue';

export default {
  components: {
    'apo-survey-available-list-item': SurveyAvailableListItem,
    'apo-survey-evaluation-list-item': SurveyEvaluationListItem,
  },

  data() {
    return {
      sliceSize: 5,
      evaluatedSliceSize: 3,
    };
  },

  computed: {
    ...mapGetters(['surveys', 'user']),
    availabeSurveys() {
      const isExpired = expireDate => {
        if (expireDate) {
          return new Date(expireDate) < new Date();
        }
        return false;
      };

      return this.surveys.filter(survey => !(this.user.surveyResults[survey.id] !== undefined && this.user.surveyResults[survey.id].is_complete) && !isExpired(survey.expires_at) && survey.status !== 'Private');
    },

    availabePoints() {
      return this.availabeSurveys.reduce((summary, survey) => summary + survey.points, 0);
    },

    surveySlices() {
      return this.availabeSurveys.slice(0, this.sliceSize);
    },

    evaluatedSurveys() {
      return this.surveys.filter(survey => (this.user.surveyResults[survey.id] !== undefined && this.user.surveyResults[survey.id].is_complete));
    },

    evaluatedSurveySlices() {
      return this.evaluatedSurveys.slice(0, this.evaluatedSliceSize);
    },

  },

  methods: {
    loadMoreSurveys() {
      this.sliceSize += 3;
    },
    loadMoreEvaluatedSurveys() {
      this.sliceSize += 3;
    },
  },

};
</script>
