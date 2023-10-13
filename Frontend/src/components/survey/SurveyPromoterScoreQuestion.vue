<template>
  <div
    v-if="shouldDisplayQuestion"
    class="survey-rating-question"
  >
    <div class="text-center survey-rating-question__headlines">
      <h4
        class="text-3xl text-gray-900"
        v-html="$options.filters.formatContent(question)"
      />
      <p
        v-if="subheadline"
        class="mt-2 italic text-gray-700 text-lg"
        v-html="$options.filters.formatContent(subheadline)"
      />
    </div>

    <apo-survey-optional-hint v-if="isOptional" />

    <div class="flex flex-wrap justify-center text-center">
      <div
        v-for="index in 11"
        :key="(index - 1)"
        class="survey-rating-question-item flex flex-col flex-wrap justify-center flex-auto mt-4 tablet:mt-10 w-2/3 tablet:w-auto"
      >
        <div
          class="flex justify-around flex-auto"
        >
          <!-- eslint-disable max-len -->
          <label
            class="survey-rating-question-label rating-icons w-full tablet:w-12"
            :class=" (value >= (index - 1) || hoveredOption >= index) ? 'is-active' : ''"
            :title="(index - 1)"
            @mouseover="onHover((index - 1))"
            @mouseleave="onHover(0)"
          >
            <!-- eslint-enablde max-len -->
            <input
              :id="(index - 1)"
              class="w-full h-full cursor-pointer"
              :name="`survey-question-${id}`"
              type="radio"
              :value="(index - 1)"
              @change="$emit('input', ''+(index - 1))"
            >

            <div
              class="survey-rating-question-number"
              v-text="(index - 1)"
            />
          </label>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import SurveyOptionalHint from '@/components/survey/SurveyOptionalHint.vue';

export default {
  components: {
    'apo-survey-optional-hint': SurveyOptionalHint,
  },

  props: {
    value: {
      type: String,
      required: true,
    },

    id: {
      type: String,
      required: true,
    },

    question: {
      type: String,
      required: true,
    },

    subheadline: {
      type: String,
      required: false,
      default: '',
    },

    isOptional: {
      type: Boolean,
      default: false,
    },
    dynamic_filter: {
      type: Boolean,
      default: false,
    },
    currentChapter: {
      type: Number,
      default: 1,
    },
  },

  data() {
    return {
      selectedOption: '',
      hoveredOption: '',
    };
  },

  computed: {
    shouldDisplayQuestion() {
    // Wenn dynamic_filter nicht aktiviert ist, oder wir uns im ersten Kapitel befinden, geben Sie true zurück.
      if (!this.dynamic_filter || this.currentChapter === 1) {
        return true;
      }

      // Zugriff auf den gespeicherten Umfragezustand im Vuex Store
      const surveyState = this.$store.state.surveys;

      // Überprüfen Sie, ob surveyState.surveys existiert und ein Array ist
      if (surveyState && Array.isArray(surveyState.surveys)) {
        let answeredWithRating1 = false;
        surveyState.surveys.forEach(survey => {
          survey.chapters.forEach((chapter, chapterIndex) => {
          // Nur Antworten aus vorherigen Kapiteln berücksichtigen
            if (chapterIndex < this.currentChapter - 1) {
              const previousAnswer = chapter.questions.find(q => q.question === this.question && q.dynamic_filter);
              if (previousAnswer && previousAnswer.value === '1') {
                answeredWithRating1 = true;
              }
            }
          });
        });

        // Wenn die Frage mit "1" beantwortet wurde, geben Sie false zurück, um sie auszublenden
        if (answeredWithRating1) {
          return false;
        }
      }

      // Standardmäßig wird die Frage angezeigt
      return true;
    },
  },


  methods: {
    onHover(index) {
      this.hoveredOption = index;
    },
  },
};
</script>


<style lang="scss" scoped>

@import '../../assets/scss/utilities';

.survey-rating-question {
  @apply w-full;

  &-item{
    flex-grow: 0;

    @screen tablet {
      flex-grow: 1;
    }
  }

  &-label {
    @apply border-gray-700;
    @apply block;
    @apply border-4;
    @apply cursor-pointer;
    @apply h-12;
    @apply overflow-hidden;
    @apply relative;
    @apply rounded-full;

    @extend .transition-border-color;
    @extend .transition-ease;
    @extend .transition-fast;

    &:hover,
    &.is-active {
      @apply border-gray-900;
    }
  }

  &-number {
    @apply absolute;
    @apply bg-white;
    @apply border-5;
    @apply border-white;
    @apply flex;
    @apply h-full;
    @apply items-center;
    @apply left-0;
    @apply justify-center;
    @apply rounded-full;
    @apply text-gray-700;
    @apply text-xl;
    @apply top-0;
    @apply w-full;

    @extend .transition-fast;
    @extend .transition-ease;
    @extend .transition-background-color;
  }

  &-label:hover &-number,
  &-label.is-active &-number {
    @apply bg-gray-900;
    @apply text-white;
  }
}

</style>
