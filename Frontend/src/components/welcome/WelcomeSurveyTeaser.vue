<template>
  <div class="welcome-survey-teaser">
    <div class="welcome-survey-teaser__headline py-6 text-center">
      <h2
        class="mb-5"
        v-text="$t('pages.welcome.surveyTeaser.yourSurveys')"
      />
      <hr class="border-yellow-500 border-2">
    </div>
    <div class="py-6 bg-yellow-100">
      <div class="container">
        <apo-wait for="surveys">
          <template #waiting>
            <apo-loading-overlay
              class="my-15"
              :message="$t('loaders.surveys')"
            />
          </template>

          <div
            v-if="availabeSurveys.length > 0"
            class="available-surveys"
          >
            <div class="mb-12 container max-w-4xl mx-auto text-gray-800 text-center">
              <p
                class="text-2xl"
                v-html="$t('surveys.messages.statusInfo', {
                  surveys: availabeSurveys.length,
                  points: availabePoints
                })"
              />
            </div>

            <apo-survey-available-list-item
              v-for="survey in availabeSurveys"
              :key="survey.id"
              :survey="survey"
            />

            <div class="survey-teaser__show-all text-center">
              <router-link
                class="button--naked shadow-hard-dark text-yellow-500"
                tag="apo-button"
                :to="{ name: 'surveys' }"
                v-text="$t('general.showAll')"
              />
            </div>
          </div>

          <!-- eslint-disable max-len -->
          <div
            v-else
            class="container max-w-4xl mx-auto font-display text-center font-bold text-gray-900 leading-none tracking-wide"
            v-text="$t('surveys.messages.noSurveysAvailable')"
          />
          <!-- eslint-enable max-len -->
        </apo-wait>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import SurveyAvailableListItem from '@/components/survey/overview/SurveyAvailableListItem.vue';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import { SURVEYS_FETCH_ALL } from '@/store/types/action-types';

export default {
  components: {
    'apo-loading-overlay': LoadingOverlay,
    'apo-survey-available-list-item': SurveyAvailableListItem,
  },

  data() {
    return {
      sliceSize: 3,
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


      return this.surveys.filter(survey => !(this.user.surveyResults !== undefined && this.user.surveyResults[survey.id] !== undefined && this.user.surveyResults[survey.id].is_complete) && !isExpired(survey.expires_at) && survey.status !== 'Private');
    },

    availabePoints() {
      return this.availabeSurveys.reduce((summary, survey) => summary + survey.points, 0);
    },

    surveySlices() {
      return this.availabeSurveys.slice(0, this.sliceSize);
    },
  },

  methods: {
    ...mapActions([SURVEYS_FETCH_ALL]),
  },

  created() {
    this[SURVEYS_FETCH_ALL]()
      .catch(error => {
        console.log('error retrieving the surveys', error);
      });
  },
};

</script>

<style lang="scss" scoped>

.welcome-survey-teaser {
  .container {
    max-width: 100%;
  }
}

</style>
