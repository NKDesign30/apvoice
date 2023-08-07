<template>
  <div class="training-teaser__footer">
    <div
      class="flex flex-col items-baseline tablet:flex-row"
      :class="[showCertificate ? 'tablet:justify-between' : 'tablet:justify-end']"
    >
      <div
        v-if="showCertificate"
        class="flex-auto training-teaser__certificate"
      >
        <h4
          class="mb-6 font-bold"
          v-text="$t('trainings.yourCertificates')"
        />
        <template v-for="training in computedTrainings">
          <apo-button
            v-if="isComplete(training, user)"
            :key="training.id"
            class="mr-6 border-2 button--naked button--tiny"
            :class="[
              (user.trainingResults[training.id] && user.trainingResults[training.id].is_complete)
                ? 'border-training-500 text-training-500'
                : 'border-gray-600 text-gray-600 cursor-not-allowed'
            ]"
            :disabled="!(user.trainingResults[training.id] &&user.trainingResults[training.id].is_complete)"
            @click="download(training)"
          >
            {{ training.year }}
          </apo-button>
        </template>
      </div>
      <div class="mt-6 training-teaser__obligatory tablet:mt-0 tablet:text-right">
        <span
          v-if="hasDutyText"
          class="text-xl tracking-wide border-b border-gray-900 cursor-pointer"
          @click="showDutyText = !showDutyText"
          v-text="$t('trainings.dutyText')"
        />
      </div>
    </div>

    <apo-collapsible-content
      class="mt-8"
      :show="showDutyText"
    >
      <div
        class="container p-6 mx-auto break-all"
        v-html="$options.filters.formatContent(dutyText)"
      />
    </apo-collapsible-content>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import downloadCertificate from '@/mixins/download-certificate';

export default {

  mixins: [
    downloadCertificate(),
  ],

  props: {
    dutyText: {
      type: String,
      required: false,
      default: '',
    },
    trainings: {
      type: Array,
      required: true,
    },
    // required for downloadCertificate mixin
    currentTrainingId: {
      required: true,
      validator: prop => typeof prop === 'number' || prop === null,
    },
  },

  data() {
    return {
      showDutyText: false,
      showCertificate: true,
    };
  },
  computed: {
    ...mapGetters(['user']),
    computedTrainings() {
      return this.trainings.slice().reverse();
    },

    hasDutyText() {
      return this.dutyText && this.dutyText.length && this.dutyText.length > 0;
    },
  },
};
</script>
