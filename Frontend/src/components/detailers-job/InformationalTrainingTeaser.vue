<template>
  <div class="informational-training-teaser p-4 flex flex-wrap bg-gray-300">
    <div class="flex flex-1">
      <div class="flex items-center">
        <apo-icon
          class="w-12 text-blue-700"
          src="training"
        />
      </div>
      <div
        class="mx-12 flex items-center flex-1 headline-4"
        v-html="$options.filters.formatContent(informationalTraining.title)"
      />
    </div>
    <div class="mt-6 tablet:mt-0 w-full tablet:w-48 flex flex-col justify-center items-center tablet:items-end">
      <apo-button
        class="action-button button button--tiny"
        @click.native="start"
        v-text="buttonText"
      />
      <template v-if="hasSavedState">
        <small
          v-if="isFinished"
          class="mt-2 italic"
          v-text="$t('detailersJob.isFinished')"
        />
        <small
          v-else
          class="mt-2 italic"
          v-text="$t('detailersJob.lastSavedStep', { step: savedStateStep, totalSteps })"
        />
      </template>
    </div>
  </div>
</template>

<script>

import { mapState } from 'vuex';

export default {
  props: {
    informationalTraining: {
      type: Object,
      default: () => {},
    },

    pharmacy: {
      type: Object,
      default: () => {},
    },
  },

  computed: {
    ...mapState({
      savedStates: state => state.detailersJob.savedStates,
    }),

    savedState() {
      return this.savedStates.find(state => state.informationalTrainingId === this.informationalTraining.id && state.pharmacyId === this.pharmacy.id);
    },

    hasSavedState() {
      return this.savedState !== undefined;
    },

    savedStateStep() {
      if (!this.hasSavedState) {
        return null;
      }

      const questionIndex = this.informationalTraining.questions.findIndex(question => question.id === this.savedState.lastQuestionId);

      return questionIndex + 1;
    },

    totalSteps() {
      return this.informationalTraining.questions.length;
    },

    isOneStepLeft() {
      if (!this.hasSavedState) {
        return false;
      }

      return this.savedStateStep === this.totalSteps - 1;
    },

    isFinished() {
      if (!this.hasSavedState) {
        return false;
      }

      return this.savedStateStep === this.totalSteps;
    },

    buttonText() {
      if (this.isFinished) {
        return this.$t('detailersJob.buttons.lookup');
      }

      if (this.isOneStepLeft) {
        return this.$t('detailersJob.buttons.finish');
      }

      return this.$t('detailersJob.buttons.start');
    },
  },

  methods: {
    start() {
      let trainingUrl = `/detailers-job/training/${this.informationalTraining.id}/${this.pharmacy.id}`;

      if (this.hasSavedState && !this.isFinished) {
        trainingUrl += `/${this.savedState.lastQuestionId}`;
      }

      this.$router.push(trainingUrl);
    },
  },
};

</script>

<style lang="scss" scoped>

.action-button {
  @apply shadow-hard-dark;
  @apply text-blue-600;
  @apply bg-white #{!important};
  @apply py-2 #{!important};
  @apply px-12 #{!important};

  &:hover {
    @apply bg-gray-100 #{!important};
  }
}

</style>
