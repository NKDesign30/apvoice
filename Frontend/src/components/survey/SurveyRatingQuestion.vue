<template>
  <div class="survey-rating-question">
    <div
      ref="ratingHeader"
      class="mx-auto text-center survey-rating-question__headlines"
    >
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

    <div
      ref="ratingOptions"
      class="flex flex-wrap justify-center text-center flex-col"
    >
      <div
        v-for="item in filteredItems"
        :key="item.id"
        class="flex flex-col flex-wrap justify-center flex-auto mt-10"
        style="display: flex; flex-direction: column;align-content: center;"
      >
        <div
          v-if="item.image"
          class="relative px-1 py-2 mb-2 rounded-lg tablet:px-10"
          style="min-height:250px;width: 420px;"
        >
          <div class="absolute inset-0 w-full h-40 h-full overflow-hidden">
            <img
              v-if="item.image"
              :src="item.image"
              alt="Bild für das Rating-Item"
              class="object-scale-down object-top w-full h-full ml-auto"
            >
          </div>
        </div>


        <!-- Hier fügen Sie das img Tag hinzu -->
        <h5
          class="mb-6 text-xl text-gray-900"
          v-html="$options.filters.formatContent(item.headline)"
        />

        <div class="flex justify-center flex-auto -mx-2">
          <!-- eslint-disable max-len -->
          <div
            v-for="option in item.options"
            :key="option.id"
            class="px-1"
          >
            <label
              :for="option.id"
              class="survey-rating-question-label"
              :class="{ 'is-active': value.some(val => val.value === option.label && val.ratingId === item.id) }"
              :title="option.tooltip"
            >
              <!-- eslint-enablde max-len -->
              <input
                :id="option.id"
                class="w-full h-full cursor-pointer"
                :name="`survey-question-${id}`"
                type="radio"
                :value="option.id"
                @change="$emit('input', {value: option.label, item})"
              >

              <div
                class="survey-rating-question-number"
                v-html="$options.filters.formatContent(option.label)"
              />
            </label>
          </div>
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
      type: Array,
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

    items: {
      type: Array,
      required: true,
    },

    isOptional: {
      type: Boolean,
      default: false,
    },

    isCluster: {
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
      lastFilteredItems: null,
      lastDynamicFilterItems: null,
    };
  },


  computed: {
    filteredItems() {
      console.log('Aktueller Vuex surveys State in filteredItems:', this.$store.state.surveys);

      // Wenn wir uns im ersten Kapitel befinden, geben Sie alle Elemente zurück.
      if (this.currentChapter === 1) {
        this.lastFilteredItems = this.items;
        this.lastDynamicFilterItems = null;
        console.log('First Chapter - lastFilteredItems:', this.lastFilteredItems);
        return this.items;
      }

      // Zugriff auf den gespeicherten Umfragezustand im Vuex Store
      const surveyState = this.$store.state.surveys;

      // Überprüfen Sie, ob surveyState.surveys existiert und ein Array ist
      if (surveyState && Array.isArray(surveyState.surveys)) {
      // Extrahieren Sie die Headlines der Items, die mit "1" bewertet wurden
        const answeredHeadlinesWithRating1 = [];
        surveyState.surveys.forEach(survey => {
          survey.chapters.forEach((chapter, chapterIndex) => {
          // Nur Antworten aus vorherigen Kapiteln berücksichtigen
            if (chapterIndex < this.currentChapter - 1) {
              chapter.questions.forEach(question => {
                if (question.dynamic_filter && question.value && Array.isArray(question.value)) {
                  question.value.forEach(answer => {
                    if (answer.value === '1') {
                      const innerItem = question.items.find(item => item.id === answer.ratingId);
                      if (innerItem) {
                        answeredHeadlinesWithRating1.push(innerItem.headline);
                      }
                    }
                  });
                }
              });
            }
          });
        });

        // Wenn dynamic_filter für das aktuelle Kapitel aktiviert ist oder deaktiviert ist, filtern Sie die Elemente
        if (this.dynamic_filter || (!this.dynamic_filter && this.currentChapter > 1)) {
          const filtered = this.items.filter(item => !answeredHeadlinesWithRating1.includes(item.headline));
          this.lastFilteredItems = filtered; // Speichern der gefilterten Items
          this.lastDynamicFilterItems = filtered; // Aktualisieren von lastDynamicFilterItems
          console.log('Dynamic Filter Active - lastFilteredItems:', this.lastFilteredItems);
          console.log('Updated lastDynamicFilterItems:', this.lastDynamicFilterItems);
          return filtered;
        }
      }

      // Wenn dynamic_filter für das aktuelle Kapitel nicht aktiviert ist, verwenden Sie lastDynamicFilterItems
      if (!this.dynamic_filter) {
        console.log('Using lastDynamicFilterItems:', this.lastDynamicFilterItems);
        return this.lastDynamicFilterItems || this.items;
      }

      // Wenn surveyState.surveys nicht existiert oder kein Array ist, geben Sie die zuletzt gefilterten Items zurück
      console.log('Using lastFilteredItems:', this.lastFilteredItems);
      return this.lastFilteredItems || this.items;
    },
  },


  watch: {
    currentChapter() {
      console.log('Aktueller Vuex State beim Wechsel des Kapitels:', this.$store.state);
      // Aktualisieren Sie lastDynamicFilterItems immer, wenn sich die gefilterten Elemente ändern
      this.lastDynamicFilterItems = this.filteredItems;
      console.log('Updated lastDynamicFilterItems on chapter change:', this.lastDynamicFilterItems);
    },
  },


  methods: {
    updateLastFilteredItems() {
      console.log('updateLastFilteredItems called');
      if (this.currentChapter === 1) {
        this.lastFilteredItems = this.items;
      } else if (this.dynamic_filter) {
        const surveyState = this.$store.state.surveys;
        if (surveyState && Array.isArray(surveyState.surveys)) {
          const answeredHeadlinesWithRating1 = [];
          surveyState.surveys.forEach(survey => {
            survey.chapters.forEach((chapter, chapterIndex) => {
              if (chapterIndex < this.currentChapter - 1) {
                chapter.questions.forEach(question => {
                  if (question.dynamic_filter && question.value && Array.isArray(question.value)) {
                    question.value.forEach(answer => {
                      if (answer.value === '1') {
                        const innerItem = question.items.find(item => item.id === answer.ratingId);
                        if (innerItem) {
                          answeredHeadlinesWithRating1.push(innerItem.headline);
                        }
                      }
                    });
                  }
                });
              }
            });
          });
          this.lastFilteredItems = this.items.filter(item => !answeredHeadlinesWithRating1.includes(item.headline));
        }
      }
    },
  },

  mounted() {
    console.log('Initial lastDynamicFilterItems:', this.lastDynamicFilterItems);
    console.log('Vuex State: ', this.$store.state);
    console.log('dynamic_filter value:', this.dynamic_filter);
    console.log('currentChapter value:', this.currentChapter);
    console.log('value:', this.value);
    console.log('items:', this.items);
    if (this.isCluster) this.$refs.ratingHeader.style.maxWidth = `${this.$refs.ratingOptions.getBoundingClientRect().width}px`;
  },
};
</script>

<style lang="scss" scoped>

@import '../../assets/scss/utilities';

.survey-rating-question {
  @apply w-full;

  &-label {
    @apply border-gray-700;
    @apply block;
    @apply border-4;
    @apply cursor-pointer;
    @apply h-12;
    @apply overflow-hidden;
    @apply relative;
    @apply rounded-full;
    @apply w-12;

    @extend .transition-border-color;
    @extend .transition-ease;
    @extend .transition-fast;

    &:hover,
    &.is-active {
      @apply border-gray-900;
    }
  }
  .object-cover {
    object-fit: scale-down!important;
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
