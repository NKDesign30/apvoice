<template>
  <div v-if="relatedTraining && relatedTraining.length">
    <h2 class="text-xl font-semibold mb-4">{{ $t('trainings.relatedTrainings') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="training in relatedTraining" :key="training.id" class="bg-white p-4 rounded shadow">
        <img :src="training.image" alt="Training Bild" class="w-full h-48 object-cover rounded-t">
        <div class="p-4">
          <h3 class="text-lg font-semibold">{{ training.title }}</h3>
          <p class="text-sm text-gray-500">{{ training.description }}</p>
        </div>
      </div>
    </div>
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
