<template>
  <div class="training-teaser mb-4 px-4 tablet:px-0 py-6 bg-gray-100">
    <div class="training-teaser__item container">
      <apo-training-teaser-head
        :id="series.id"
        v-wow.fadeInUp
        :infos="series.informations"
        :slug="series.slug"
        :first-lesson="firstLesson"
        :next-lesson="nextLesson"
        :training="training"
        :current-training-id="trainingId"
        :current-training-slug="trainingSlug"
        :categories="series.categories"
      />

      <apo-training-lesson-list
        v-wow.fadeInUp
        :lessons="lessons"
        :seriesslug="series.slug"
        :trainingslug="trainingSlug"
      />
      <apo-training-footer
        v-wow.fadeInUp
        :trainings="series.trainings"
        :current-training-id="trainingId"
        :duty-text="series.dutyText"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import get from 'lodash/get';
import TrainingTeaserHead from '@/components/training/teaser/TrainingTeaserHead.vue';
import TrainingTeaserLessonList from '@/components/training/teaser/TrainingTeaserLessonList.vue';
import TrainingTeaserFooter from '@/components/training/teaser/TrainingTeaserFooter.vue';

export default {
  components: {
    'apo-training-teaser-head': TrainingTeaserHead,
    'apo-training-lesson-list': TrainingTeaserLessonList,
    'apo-training-footer': TrainingTeaserFooter,
  },
  props: {
    series: {
      type: Object,
      default: () => {},
    },
  },
  computed: {
    ...mapGetters(['user']),
    training() {
      return this.series.trainings.slice().shift();
    },
    trainingId() {
      return get(this.training, 'id', null);
    },
    trainingSlug() {
      return get(this.training, 'slug', null);
    },
    lessons() {
      return get(this.training, 'lessons', []);
    },
    nextLesson() {
      const nextLesson = this.lessons.find(lesson => !(this.user.trainingResults[lesson.training_id] && this.user.trainingResults[lesson.training_id].completed_lessons[lesson.lesson_id]));
      return get(nextLesson, 'lesson_id', null);
    },
    firstLesson() {
      return this.lessons.slice().shift().lesson_id;
    },
    lastLesson() {
      return this.lessons.slice().pop().lesson_id;
    },
  },
};
</script>

<style>

</style>
