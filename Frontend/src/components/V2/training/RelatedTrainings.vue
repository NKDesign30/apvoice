<template>
  <div id="related">
    <h3 class="mt-10 mb-10 text-gray-700">{{ $t('trainings.successPage.hint.latestIncompleteT') }}</h3>
    <div v-for="training in relatedTraining" :key="training.id" class="flex flex-col w-full pb-5 mb-5 border-b-2 text-left">
      <single-training :training="training.trainings[0]" :theme="theme"></single-training>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import training from "@/components/V2/training/training.vue";
import premiumTraining from "@/components/V2/training/premiumTraining.vue";

export default {
  props: {
    currentTraining: Object,
    theme: {
      type: String,
      required: true
    }
  },
  components: {
    "single-training": training,
    "single-premium": premiumTraining
  },
  computed: {
    ...mapGetters([
      "trainingSeries",
      "trainingCategories",
      "premiumTrainingSeries",
      "availableTrainingSeries",
      "user"
    ]),
    relatedTraining() {
      console.log("Training Series:", this.trainingSeries); // Debugging line
      const related = this.trainingSeries.filter(
        item =>
          item.trainings.length > 0 &&
          parseInt(item.trainings[0].isPremium) === 0 &&
          this.currentTraining.training_label.ID == item.id
      );
      console.log("Related Training:", related); // Debugging line
      return related;
    },
    trainingSeries() {
      return this.$store.state.trainings.trainingSeries;
    },
    success() {
      return this.currentTrainingSeries;
    }
  },
  watch: {},
  methods: {}
};
</script>
