<template>
  <!--eslint-disable max-len -->
  <div class="informational-training">
    <div class="py-24">
      <apo-wait for="detailersJob.informationalTrainings">
        <template #waiting>
          <apo-loading-overlay
            class="my-15"
            :message="$t('loaders.informationalTraining')"
          />
        </template>

        <div
          v-if="informationalTraining"
          class="container"
        >
          <h2
            class="text-center"
            v-text="informationalTraining.title"
          />
          <h4
            class="mt-4 text-center"
            v-text="$t('detailersJob.informationalTraining.subheadline')"
          />

          <div
            v-if="currentQuestion"
            class="mt-20"
          >
            <div v-if="showFinishPage">
              <apo-cms-content-renderer :components="informationalTraining.finishPage.content || []" />

              <div class="flex justify-center mt-12">
                <button
                  class="mt-24 text-gray-900 underline uppercase"
                  @click="restart"
                  v-text="$t('general.restart')"
                />
              </div>
            </div>
            <div v-else-if="showResultPage">
              <apo-cms-content-renderer :components="currentContent" />

              <div class="flex justify-center mt-12">
                <apo-button
                  class="text-white button button--primary button--tiny shadow-hard"
                  @click="next"
                  v-text="isLastStep ? $t('general.finish') : $t('general.continue')"
                />
              </div>
            </div>
            <div v-else>
              <h3
                class="text-center"
                v-text="currentQuestion.question"
              />

              <div class="max-w-4xl mx-auto mt-8">
                <apo-radio-button-group
                  v-model="answer"
                  class="flex flex-col"
                >
                  <apo-radio-button
                    :id="currentQuestion.answerA.id"
                    :key="currentQuestion.answerA.id"
                    :label="currentQuestion.answerA.answer"
                    :value="currentQuestion.answerA.id"
                    class="flex-1 mb-6"
                  />

                  <apo-radio-button
                    :id="currentQuestion.answerB.id"
                    :key="currentQuestion.answerB.id"
                    :label="currentQuestion.answerB.answer"
                    :value="currentQuestion.answerB.id"
                    class="flex-1 mb-6"
                  />
                </apo-radio-button-group>
              </div>

              <div class="flex flex-col items-center mb-3 mt-15">
                <apo-button
                  class="text-white button button--primary button--tiny shadow-hard"
                  :disabled="!hasQuestionBeenAnswered"
                  @click="submit"
                  v-text="$t('general.submit')"
                />
              </div>
            </div>
          </div>
        </div>
      </apo-wait>
    </div>
  </div>
</template>

<script>

import { mapGetters, mapState } from 'vuex';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';
import RadioButtonGroup from '@/components/form/RadioButtonGroup.vue';
import RadioButton from '@/components/form/RadioButton.vue';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import DetailersJobService from '@/services/api/DetailersJobService';
import { DETAILERS_JOB_UPDATE_SAVED_STATE, DETAILERS_JOB_REMOVE_SAVED_STATE } from '@/store/types/mutation-types';
import { canonicalTag } from '@/services/utils';

export default {
  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
    'apo-loading-overlay': LoadingOverlay,
    'apo-radio-button-group': RadioButtonGroup,
    'apo-radio-button': RadioButton,
  },

  data: () => ({
    answer: '',
    step: 1,
    showResultPage: false,
    showFinishPage: false,
  }),

  head() {
    return {
      title: {
        inner: this.$t('pages.detailersJob.informationalTraining.meta.title'),
      },
      link: [
        canonicalTag(this.$route),
      ],
    };
  },

  computed: {
    ...mapGetters(['userId']),
    ...mapState({
      informationalTrainings: state => state.detailersJob.informationalTrainings,
    }),

    hasSavedState() {
      return this.$route.params.lastQuestionId !== undefined;
    },

    totalSteps() {
      if (!this.informationalTraining) {
        return null;
      }

      return this.informationalTraining.questions.length;
    },

    isLastStep() {
      return this.step === this.totalSteps;
    },

    informationalTraining() {
      const { informationalTrainingId } = this.$route.params;

      return this.informationalTrainings.find(({ id }) => id === informationalTrainingId);
    },

    currentQuestion() {
      if (!this.informationalTraining) {
        return null;
      }

      const questionIndex = this.step - 1;

      if (!this.informationalTraining.questions[questionIndex]) {
        return null;
      }

      return this.informationalTraining.questions[questionIndex];
    },

    currentContent() {
      if (this.currentQuestion) {
        if (this.currentQuestion.answerA.id === this.answer) {
          return this.currentQuestion.answerA.content || [];
        }

        if (this.currentQuestion.answerB.id === this.answer) {
          return this.currentQuestion.answerB.content || [];
        }
      }

      return null;
    },

    hasQuestionBeenAnswered() {
      return this.answer !== '';
    },
  },

  methods: {
    restoreSavedState() {
      if (this.informationalTraining && this.hasSavedState) {
        const questionIndex = this.informationalTraining.questions
          .findIndex(question => question.id === this.$route.params.lastQuestionId);

        if (questionIndex !== undefined) {
          const nextQuestionIndex = questionIndex + 1;

          if (this.informationalTraining.questions[nextQuestionIndex]) {
            this.step = nextQuestionIndex + 1;
          }
        }
      }
    },

    submit() {
      this.showResultPage = true;

      DetailersJobService
        .saveState({
          informationalTrainingId: this.informationalTraining.id,
          pharmacyId: this.$route.params.pharmacyId,
          detailerUserId: this.userId,
          lastQuestionId: this.currentQuestion.id,
        })
        .then(savedState => {
          this.$store.commit(DETAILERS_JOB_UPDATE_SAVED_STATE, savedState);
        })
        .catch(error => {
          console.log('error while saving state', error);
        });
    },

    next() {
      this.showResultPage = false;
      this.answer = '';

      if (this.step + 1 <= this.totalSteps) {
        this.step += 1;
      } else {
        this.showFinishPage = true;
      }
    },

    previous() {
      this.showResultPage = false;
      this.answer = '';

      this.step -= 1;
    },

    restart() {
      this.showResultPage = false;
      this.showFinishPage = false;
      this.answer = '';
      this.step = 1;

      DetailersJobService
        .clearSavedState({
          informationalTrainingId: this.informationalTraining.id,
          pharmacyId: this.$route.params.pharmacyId,
          detailerUserId: this.userId,
        })
        .then(() => {
          this.$store.commit(DETAILERS_JOB_REMOVE_SAVED_STATE, {
            informationalTrainingId: this.informationalTraining.id,
            pharmacyId: this.$route.params.pharmacyId,
          });
        })
        .catch(error => {
          console.log('error while clearing saved state', error);
        });
    },
  },

  created() {
    const unwatch = this.$watch('informationalTraining', () => {
      this.restoreSavedState();
      unwatch();
    });
  },
};

</script>
