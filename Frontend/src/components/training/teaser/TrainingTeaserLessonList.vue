<template>
  <div class="training-teaser__lesson-list tablet:-mr-6 mb-6 flex flex-wrap">
    <apo-training-teaser-lesson-list-item
      v-for="lesson in lessons"
      :key="lesson.lesson_id"
      :lesson="lesson"
      :without-body="withoutBody"
      :seriesslug="seriesslug"
      :trainingslug="trainingslug"
      :theme="theme"
    />
  </div>
</template>

<script>
import TrainingTeaserLessonListItem from '@/components/training/teaser/TrainingTeaserLessonListItem.vue';

export default {
  components: {
    'apo-training-teaser-lesson-list-item': TrainingTeaserLessonListItem,
  },
  props: {
    lessons: {
      type: Array,
      required: true,
    },
    seriesslug: {
      type: String,
      required: true,
    },
    trainingslug: {
      type: String,
      required: true,
    },
    withoutBody: {
      type: Boolean,
      required: false,
      default: false,
    },
    theme: {
      type: String,
      required: true
    }
  },
  methods: {
    maxHeight(selectedElement) {
      let result = 0;
      let help = '';
      [].forEach.call(selectedElement, element => {
        help = Math.max(element.offsetHeight);
        if (result <= help) {
          result = help;
        }
      });
      return result;
    },
    setTeaserHeight(selectedElement, height) {
      [].forEach.call(selectedElement, setHeight => {
        // eslint-disable-next-line no-param-reassign
        setHeight.style.height = `${height}px`;
      });
    },
  },
  mounted() {
    const selectTeaserContainer = document.querySelectorAll('.training-teaser__lesson-list');

    [].forEach.call(selectTeaserContainer, container => {
      const selectHead = container.querySelectorAll('.training-lesson__head');
      const selectBody = container.querySelectorAll('.training-lesson__body');

      this.setTeaserHeight(selectHead, this.maxHeight(selectHead));
      this.setTeaserHeight(selectBody, this.maxHeight(selectBody));
    });
  },
};
</script>

<style>

</style>
