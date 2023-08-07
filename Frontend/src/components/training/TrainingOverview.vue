<template>
  <div class="training-overview">
    <div class="training-overview__body font-display">
      <apo-training-overview-intro />

      <apo-training-overview-category-filter
        v-if="computedTrainingCategories.length > 1"
        class="container mb-6"
        :training-categories="computedTrainingCategories"
        :active-categories="activeCategories"
        @input="activeCategories = $event"
      />

      <apo-training-teaser
        v-for="series in filteredTrainingSeries"
        :key="series.id"
        :series="series"
      />

      {{ premiumContent }}
      <apo-training-overview-survey-teaser />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import TrainingOverviewIntro from "@/components/training/overview/TrainingOverviewIntro.vue";
import TrainingTeaser from "@/components/training/TrainingTeaser.vue";
import TrainingOverviewSurveyTeaser from "@/components/training/overview/TrainingOverviewSurveyTeaser.vue";
import TrainingOverviewCategoryFilter from "@/components/training/overview/TrainingOverviewCategoryFilter.vue";

export default {
  components: {
    "apo-training-teaser": TrainingTeaser,
    "apo-training-overview-intro": TrainingOverviewIntro,
    "apo-training-overview-survey-teaser": TrainingOverviewSurveyTeaser,
    "apo-training-overview-category-filter": TrainingOverviewCategoryFilter,
  },

  data() {
    return {
      activeCategories: [],
    };
  },

  computed: {
    ...mapGetters(["trainingSeries", "trainingCategories"]),
    premiumContent() {
      let trainings = this.trainingSeries.filter((training) => {
        console.log('training', training)
        return (
          training.trainings[0].isPremium == "1" ||
          training.trainings[0].isPremium == 1
        );
      });

      console.log('trainings', trainings)

      // return trainings;
    },
    filteredTrainingSeries() {
      return this.trainingSeries
        .filter((training) => training.trainings.length > 0)
        .filter(
          (training) =>
            training.categories.length === 0 ||
            training.categories.some((category) =>
              this.activeCategories.includes(category)
            )
        );
    },

    computedTrainingCategories() {
      const availabeCategories = this.trainingSeries.flatMap(
        (series) => series.categories
      );

      return this.trainingCategories
        .filter((categorie) => categorie.count > 0)
        .filter((categorie) => availabeCategories.includes(categorie.id));
    },
  },

  watch: {
    computedTrainingCategories: {
      immediate: true,
      handler(categories) {
        this.activeCategories = categories.map((category) => category.id);
      },
    },
  },
};
</script>
