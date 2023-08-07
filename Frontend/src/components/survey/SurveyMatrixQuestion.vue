<template>
  <div class="survey-matrix-question w-full">
    <div class="text-center survey-rating-question__headlines">
      <h4
        class="text-3xl text-gray-900"
        v-html="$options.filters.formatContent(question)"
      />
      <p
        v-if="subheadline"
        class="mt-2 italic text-gray-700 text-lg mb-6"
        v-html="$options.filters.formatContent(subheadline)"
      />
    </div>

    <apo-survey-optional-hint v-if="isOptional" />

    <div
      ref="matrixWrapper"
      class="survey-matrix-question-wrapper"
    >
      <div class="flex flex-full survey-matrix-question-row">
        <div
          ref="placerItem"
          class="w-1/5 p-4 flex-shrink-0 survey-matrix-question-item"
        />
        <div
          v-for="answer in answers"
          :key="answer.id"
          class="flex-auto flex items-center justify-center p-4 bg-gray-900 text-white border border-white w-8 flex-shrink-0 survey-matrix-question-item"
          v-html="$options.filters.formatContent(answer.answerTitle)"
        />
      </div>
      <div
        v-for="(section, index) in sections"
        :key="section.id"
        class="flex survey-matrix-question-row"
      >
        <div
          class="w-full tablet:w-1/5 p-4 border border-gray-500 flex items-center justify-center flex-shrink-0 survey-matrix-question-item"
          :class="index % 2 == 0 ? 'bg-gray-100' : ''"
          v-html="$options.filters.formatContent(section.sectionTitle)"
        />
        <div
          v-for="answer in answers"
          :key="answer.id"
          class="flex-auto p-4 border border-gray-500 survey-matrix-question-item"
          :class="index % 2 == 0 ? 'bg-gray-100' : ''"
        >
          <apo-survey-choice-button
            v-if="matrixType == 'single'"
            :id="section.id+'-'+answer.id"
            class="w-8 scaleable flex-shrink-1"
            :is-active="value[section.id] && value[section.id]['id'] === answer.id"
            @click="(event) => onToggleChoice(event, section, answer)"
          />

          <apo-survey-choice-button
            v-if="matrixType == 'promoter_score'"
            :id="section.id+'-'+answer.id"
            class="w-8 scaleable flex-shrink-1"
            :is-active="(hoveredOption[section.id] >= answer.answerTitle) || (value[section.id] && answer.answerTitle <= value[section.id]['answer'])"
            @click="(event) => onToggleChoice(event, section, answer)"
            @mouseover="onHover(section.id, answer.answerTitle)"
            @mouseleave="onHover(section.id, -1)"
          />

          <label
            v-if="matrixType == 'multi'"
            class="survey-matrix-question-label"
            :for="section.id+'-'+answer.id"
            :class="{ 'is-active': value[section.id] && value[section.id]['answer'][answer.id] }"
          >
            <div class="survey-matrix-question-checkbox-wrapper">
              <input
                :id="section.id+'-'+answer.id"
                class="survey-matrix-question-checkbox"
                type="checkbox"
                @change="(event) => onToggleChoice(event, section, answer)"
              >

              <span class="survey-matrix-question-indicator" />
            </div>

            <span
              class="survey-matrix-question-text text-center"
            />
          </label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import SurveyChoiceButton from '@/components/survey/SurveyChoiceButton.vue';
import SurveyOptionalHint from '@/components/survey/SurveyOptionalHint.vue';

export default {
  components: {
    'apo-survey-choice-button': SurveyChoiceButton,
    'apo-survey-optional-hint': SurveyOptionalHint,
  },

  props: {
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
      required: true,
    },

    sections: {
      type: Array,
      required: true,
    },

    answers: {
      type: Array,
      required: true,
    },

    value: {
      type: Object,
      required: true,
    },

    matrixType: {
      type: String,
      required: true,
    },

    isOptional: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      hoveredOption: {},
    };
  },

  methods: {
    calculatePlacer() {
      let itemHeight = 0;
      if (this.$refs.matrixWrapper) {
        Array.from(this.$refs.matrixWrapper.querySelectorAll('.survey-matrix-question-row')).forEach((row, index) => {
          if (index === 0 || window.innerWidth > 639) return;
          const item = row.querySelector('.survey-matrix-question-item');
          if (item !== this.$refs.placerItem) {
            itemHeight = Math.max(itemHeight, item.offsetHeight);
          }
        });
        this.$refs.placerItem.style.height = `${itemHeight}px`;
      }
    },

    onHover(section, index) {
      this.hoveredOption = {};
      this.hoveredOption[section] = index;
    },

    isChecked(section, answer) {
      return this.value[section] && this.value[section][answer];
    },

    onToggleChoice(event, section, answer) {
      const updatedValue = this.value;

      if (this.matrixType === 'single' || this.matrixType === 'promoter_score') {
        updatedValue[section.id] = { id: answer.id, question: section.sectionTitle, answer: answer.answerTitle };
      }

      if (this.matrixType === 'multi') {
        if (event.target.checked) {
          updatedValue[section.id] = updatedValue[section.id] ? updatedValue[section.id] : { question: section.sectionTitle, answer: {} };
          updatedValue[section.id].answer[answer.id] = answer.answerTitle;
        } else {
          delete updatedValue[section.id][answer.id];
          if (Object.keys(updatedValue[section.id]).length <= 0) delete updatedValue[section.id];
        }
      }

      this.$emit('input', updatedValue);
      this.$forceUpdate();
    },
  },

  mounted() {
    this.$nextTick(function () {
      window.addEventListener('resize', () => {
        this.calculatePlacer();
      });
    });
    this.calculatePlacer();
  },
};

</script>

<style lang="scss" scoped>

@import '../../assets/scss/utilities';

.survey-matrix-question {

  &-wrapper{
    max-width: 100%;
    overflow: auto;
    display: flex;

    @screen tablet {
      display: block;
    }
  }

  &-item{
    min-width: 66px;
  }

  &-row{
    flex-direction: column;

    @screen tablet {
      flex-direction: row;
    }
  }

  &-label {
    @apply cursor-pointer;
    @apply block;
    @apply flex;
    @apply flex-col;
    @apply items-center;
  }

  &-checkbox {
    @apply h-full;
    @apply invisible;
    @apply relative;
    @apply w-full;
    @apply z-20;

    &-wrapper {
      @apply bg-gray-700;
      @apply h-8;
      @apply p-1;
      @apply relative;
      @apply w-8;

      @extend .transition-background-color;
      @extend .transition-ease;
      @extend .transition-fast;

       @screen desktop {
        &:hover {
          @apply bg-gray-900;

          .choice-multi-question-text {
            @apply text-gray-900 #{!important};
          }

        }
      }

    }
  }

  &-indicator {
    @apply absolute;
    @apply bg-white;
    @apply block;
    @apply h-6;
    @apply left-0;
    @apply ml-1;
    @apply mt-1;
    @apply top-0;
    @apply w-6;
    @apply z-10;

    @extend .transition-background-color;
    @extend .transition-border-color;
    @extend .transition-ease;
    @extend .transition-fast;
  }

  &-text {
    @apply mt-2;
    @apply text-xl;
    @apply text-gray-700;

    @extend .transition-color;
  }

  &-label.is-active &-checkbox-wrapper {
    @apply bg-gray-900;
  }

  &-label.is-active &-indicator {
    @apply bg-gray-900;
    @apply border-4;
    @apply border-white;
  }

  &-label.is-active &-text {
    @apply text-gray-900;
  }
}

</style>
