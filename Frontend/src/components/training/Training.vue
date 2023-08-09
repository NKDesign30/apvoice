<template>
  <div class="training">
    <apo-page-header
      :page_header="pageHeader"
      :show_return_button="true"
      class="mb-6"
    />
    <apo-page-indicator-wrapper>
      <apo-page-indicator
        v-for="(section, index) in lesson.sections"
        :id="index"
        :key="index"
        :title="section.title"
        :content="section.content"
        with-next-button
        class="mb-2"
      />

      <apo-page-indicator
        :id="lesson.sections.length"
        :key="lesson.sections.length"
        :title="$t('trainings.finalSectionName')"
      >
        <apo-summary
          :summary="summary"
        />
        <apo-training-quiz
          v-if="shouldRenderQuiz(lesson)"
          :chapters="lesson.quiz.chapters"
          :lesson_id="lesson.lesson_id"
          :training-series-id="training.trainingSeriesId"
          :training-id="training.id"
          :headline="lesson.quiz.headline"
          :subheadline="lesson.quiz.subheadline"
        />

        <apo-training-product-information
          v-if="hasProductInformation(lesson)"
          :product-information="lesson.productInformation"
        />

        <div
          v-if="(user.trainingResults[lesson.training_id] && user.trainingResults[lesson.training_id]['completed_lessons'][lesson.lesson_id])"
          class="mt-4 text-center bg-green-500w-full"
        >
          <router-link
            class="shadow-hard-dark text-white button-class"
            tag="apo-button"
            :to="{ name: `${this.$route.name}`}"
          >
            {{ $t('general.back') }}
          </router-link>
        </div>
      </apo-page-indicator>
    </apo-page-indicator-wrapper>
  </div>
</template>

<script>

import { mapGetters } from 'vuex';
import PageHeader from '@/components/content/PageHeader.vue';
import TrainingQuiz from '@/components/training/quiz/TrainingQuiz.vue';
import Summary from '@/components/content/Summary.vue';
import PageIndicatorWrapper from '@/components/content/page-indicator/PageIndicatorWrapper.vue';
import PageIndicator from '@/components/content/page-indicator/PageIndicator.vue';
import TrainingProductInformation from '@/components/training/TrainingProductInformation.vue';

export default {
  components: {
    'apo-page-header': PageHeader,
    'apo-training-quiz': TrainingQuiz,
    'apo-page-indicator-wrapper': PageIndicatorWrapper,
    'apo-page-indicator': PageIndicator,
    'apo-summary': Summary,
    'apo-training-product-information': TrainingProductInformation,
  },

  provide() {
    return {
      trainingsState: this.sharedState,
    };
  },

  data() {
    return {
      sharedState: {
        requiredElements: [],
        currentMissingElement: null,
      },
    };
  },

  computed: {
    ...mapGetters(['training', 'lesson', 'user']),
    pageHeader() {
      return this.lesson.page_header;
    },
    summary() {
      return this.lesson.summary;
    },
  },

  methods: {
    shouldRenderQuiz(lesson) {
      return lesson.quiz && !(this.user.trainingResults[lesson.training_id] && this.user.trainingResults[lesson.training_id].completed_lessons[lesson.lesson_id]);
    },

    hasProductInformation(lesson) {
      return lesson.productInformation.length > 0;
    },
  },

  created() {
    window.axios.get(`/wp-json/training-user-results/v1/registerTrainingParticipation/${this.lesson.training_id}`)
      .catch(error => console.log(error));
  },
};

</script>

<style lang="scss"  scoped>
.theme-training {
  .button-class {
    @apply bg-training-500;
  }
}
.theme-scientific {
  .button-class {
    @apply bg-scientific-500;
  }
}
</style>
