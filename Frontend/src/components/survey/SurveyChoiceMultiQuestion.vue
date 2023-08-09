<template>
  <div class="choice-multi-question">
    <div class="choice-multi-question__headlines">
      <h4
        class="text-3xl text-gray-900"
        v-html="$options.filters.formatContent(question)"
      />
    </div>

    <apo-survey-optional-hint v-if="isOptional" />

    <div class="mt-6 flex flex-wrap justify-center">
      <label
        v-for="choice in choices"
        :key="choice.id"
        class="choice-multi-question-label"
        :class="{ 'is-active': isChecked(choice) }"
        :for="choice.id"
      >
        <div class="choice-multi-question-checkbox-wrapper">
          <input
            :id="choice.id"
            class="choice-multi-question-checkbox"
            type="checkbox"
            :title="choice.tooltip"
            :value="choice.value"
            @change="onToggleChoice"
          >

          <span class="choice-multi-question-indicator" />
        </div>

        <span
          class="choice-multi-question-text text-center"
          v-html="$options.filters.formatContent(choice.value)"
        />
      </label>
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
    id: {
      type: String,
      required: true,
    },

    question: {
      type: String,
      required: true,
    },

    choices: {
      type: Array,
      required: true,
    },

    value: {
      type: Array,
      required: true,
    },

    isOptional: {
      type: Boolean,
      default: false,
    },
  },

  methods: {
    isChecked(choice) {
      return this.value.indexOf(choice.value) !== -1;
    },

    onToggleChoice(event) {
      let updatedValue = [...this.value];

      if (event.target.checked) {
        updatedValue.push(event.target.value);
      } else {
        updatedValue = updatedValue.filter(val => val !== event.target.value);
      }

      this.$emit('input', updatedValue);
    },
  },
};

</script>

<style lang="scss" scoped>

@import '../../assets/scss/utilities';

.choice-multi-question {
  @apply w-full #{!important};

  &-label {
    @apply cursor-pointer;
    @apply block;
    @apply flex;
    @apply flex-col;
    @apply items-center;
    @apply mb-8;
    @apply w-1/2;

    @screen tablet {
      @apply w-1/3;
    }

    @screen desktop {
      @apply w-1/6;
    }
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

  .survey-cluster-question &{

    &__headlines{
      h4{
        @apply text-xl;
      }
      p{
        @apply mt-0;
      }
    }
  }
}

</style>
