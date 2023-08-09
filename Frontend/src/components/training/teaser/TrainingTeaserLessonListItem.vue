<template>
  <!-- eslint-disable max-len -->
  <div
    class="training-teaser__lesson-list-item h-full mb-6 tablet:mb-0 tablet:mr-6 flex flex-col flex-1 cursor-pointer"
    @click="loadLesson"
  >
    <!-- eslint-enable max-len -->
    <div
      :class="`training-lesson__head p-4 flex items-baseline ${backgroundClass}`"
    >
      <div
        v-if="lesson.meta_infos.duration.time"
        class="training-lesson__duration relative"
      >
        <apo-icon
          src="time"
          class="w-8 h-8"
        />
        <span class="absolute text-sm whitespace-no-wrap training-lesson__duration--position">
          {{ lesson.meta_infos.duration.time }} {{ lesson.meta_infos.duration.type }}
        </span>
      </div>
      <div class="training-lesson__topic flex-auto text-center mx-4">
        <h4
          class="font-bold text-lg"
          v-html="$options.filters.formatContent(lesson.meta_infos.title)"
        />
        <p
          v-if="lesson.meta_infos.sub_title"
          v-html="$options.filters.formatContent(lesson.meta_infos.sub_title)"
        />
      </div>
      <div class="training-lesson__status">
        <apo-icon
          v-if="(user.trainingResults[lesson.training_id] && user.trainingResults[lesson.training_id]['completed_lessons'][lesson.lesson_id])"
          src="radio_checked"
          class="training-lesson__icon--unchecked w-8 h-8 checkbox-class"
        />
        <apo-icon
          v-else
          src="radio"
          class="training-lesson__icon--checked w-8 h-8 checkbox-class"
        />
      </div>
    </div>
    <div
      v-if="!withoutBody && lesson.meta_infos.description !== ''"
      :class="`training-lesson__body mt-2 p-4 flex flex-col h-full ${backgroundClass}`"
    >
      <p v-html="$options.filters.formatContent(lesson.meta_infos.description)" />
      <small
        v-if="1 === 2"
        class="text-xs self-end"
      >*blabla</small>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  props: {
    lesson: {
      type: Object,
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
    }
  },
  computed: {
    ...mapGetters(['user']),
    backgroundClass() {
      let lessonDone = !!(this.user.trainingResults[this.lesson.training_id] && this.user.trainingResults[this.lesson.training_id]['completed_lessons'][this.lesson.lesson_id])
      if (lessonDone) {
        return 'background-lesson-done'
      } else {
        return 'background-lesson-not-done'
      }

    },
  },
  methods: {
    loadLesson() {
      this.$router.push({
        name: 'trainings',
        params: {
          series_id: this.lesson.trainingSeriesId,
          series_slug: this.seriesslug,
          id: this.lesson.training_id,
          training_slug: this.trainingslug,
          lesson_id: this.lesson.lesson_id,
        },
      });
    },
  },
};
</script>

<style lang="scss" scoped>

.training-lesson__duration--position {
  top: 23%;
  left: 30%;
}

.training-teaser__lesson-list-item {
  @screen desktop {
    max-width: 50%;
  }
}

.theme-training {
  .background-lesson-done {
    @apply bg-training-300;
  }
  .background-lesson-not-done {
    @apply bg-training-100;
  }
  .checkbox-class {
    @apply text-training-500;
  }
}
.theme-scientific {
  .background-lesson-done {
    @apply bg-scientific-300;
  }
  .background-lesson-not-done {
    @apply bg-scientific-100;
  }
  .checkbox-class {
    @apply text-scientific-500;
  }
}
</style>
