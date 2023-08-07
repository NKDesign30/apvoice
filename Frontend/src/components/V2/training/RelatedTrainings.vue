<template>
  <div class="flex flex-col w-full pb-5 mb-5 border-b-2 text-left">
    <single-training :training="this.relatedTraining[0]" :theme="theme" :relation="true" />
  </div>
</template>
<script></script>
<script>
import { mapGetters, mapState } from "vuex";
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
      return this.trainingSeries.filter(
        item =>
          item.trainings.length > 0 &&
          parseInt(item.trainings[0].isPremium) === 0 &&
          this.currentTraining.training_label.ID == item.id
      );
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
