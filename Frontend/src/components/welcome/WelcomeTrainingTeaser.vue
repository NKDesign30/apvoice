<template>
  <div class="welcome-training-teaser theme-training py-6 bg-white">
    <div class="welcome-training-teaser__headline pb-24 text-center">
      <h2
        class="mb-5"
        v-text="$t('pages.welcome.trainingTeaser.yourTrainings')"
      />
      <hr class="border-training-500 border-2">
    </div>
    <apo-wait for="trainings.series">
      <template #waiting>
        <apo-loading-overlay
          class="my-15"
          :message="$t('loaders.trainingSeries')"
        />
      </template>

      <div
        v-if="availabeTrainingSeries.length > 0"
        class="bg-gray-100 py-24"
      >
        <apo-training-teaser
          v-for="series in availabeTrainingSeries"
          :key="series.id"
          :series="series"
        />

        <div class="training-teaser__show-all text-center bg-gray-100">
          <router-link
            class="button--naked shadow-hard-dark text-training-500"
            tag="apo-button"
            :to="{ name: 'trainings' }"
            v-text="$t('general.showAll')"
          />
        </div>
      </div>

      <!-- eslint-disable max-len -->
      <div
        v-else
        class="container max-w-4xl mx-auto font-display text-gray-800 text-center text-6xl leading-none tracking-wide"
        v-text="$t('trainings.messages.noTrainingsAvailable')"
      />
      <!-- eslint-enable max-len -->
    </apo-wait>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import {
  TRAININGS_FETCH_ALL_SERIES,
  TAXONOMIES_FETCH_TRAINING_CATEGORIES,
} from '@/store/types/action-types';
import TrainingTeaser from '@/components/training/TrainingTeaser.vue';

export default {
  components: {
    'apo-loading-overlay': LoadingOverlay,
    'apo-training-teaser': TrainingTeaser,
  },

  data() {
    return {
      sliceSize: 2,
    };
  },
  computed: {
    ...mapGetters(['trainingSeries']),

    availabeTrainingSeries() {
      return this.trainingSeries
        .filter(series => series.trainings.length > 0)
        .filter(series => !series.trainings[0].isComplete)
        .slice(0, this.sliceSize);
    },
  },

  methods: {
    ...mapActions([
      TRAININGS_FETCH_ALL_SERIES,
      TAXONOMIES_FETCH_TRAINING_CATEGORIES,
    ]),
  },

  created() {
    this[TAXONOMIES_FETCH_TRAINING_CATEGORIES]();
    this[TRAININGS_FETCH_ALL_SERIES]();
  },
};

</script>

<style lang="scss" scoped>

.welcome-training-teaser {
  .training-teaser {
    margin-bottom: 0;
    border-top: 1rem solid white;

    &:first-child {
      border-top: 0;
    }
  }
}

</style>
