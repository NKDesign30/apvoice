<template>
  <div class="question__multiple-answers">
    <div class="mt-6 flex flex-wrap justify-center">
      <label
        v-for="option in options"
        :key="option.id"
        class="question__multiple-answers-label"
        :class="{ 'is-active': isChecked(option) }"
        :for="option.id"
        :disabled="hasSubmitted"
      >
        <div class="question__multiple-answers-checkbox-wrapper text-center">
          <input
            :id="option.id"
            class="question__multiple-answers-checkbox"
            type="checkbox"
            :value="option.id"
            :disabled="hasSubmitted"
            @change="onToggleOption"
          >

          <span class="question__multiple-answers-indicator"/>

        </div>
        <span
          class="question__multiple-answers-text text-center"
          v-html="$options.filters.formatContent(option.value)"
        />

      </label>
    </div>
    <div class="question__button text-center">
      <apo-button
        class="text-white button shadow-hard mt-10 primary-button"
        :disabled="hasSubmitted"
        @click="submitAnswers"
        v-text="$t('general.submit')"
      />
    </div>
    <apo-question-response-message
      v-if="hasSubmitted"
      class="mt-13"
      :msg="responseMessage"
    />
  </div>
</template>

<script>
import QuestionResponseMessage from '@/components/content/question/QuestionResponseMessage.vue';

export default {

  components: {
    'apo-question-response-message': QuestionResponseMessage,
  },

  props: {
    options: {
      type: Array,
      requied: true,
      default: () => [],
    },
    responseMessages: {
      type: Object,
      requied: true,
      default: () => {
      },
    },
  },

  data() {
    return {
      selectedIds: [],
      hasSubmitted: false,
      percentageSum: 0,
    };
  },

  computed: {
    responseMessage() {
      // eslint-disable-next-line no-nested-ternary
      return this.hasSubmitted
        ? Number(this.responseMessages.percentage_sum) <= this.percentageSum
          ? this.responseMessages.higher_than_response
          : this.responseMessages.lower_or_equal_than_response
        : null;
    },
  },

  methods: {
    isChecked(option) {
      return this.selectedIds.indexOf(option.id) !== -1;
    },

    onToggleOption(event) {
      if (event.target.checked) {
        this.selectedIds.push(event.target.value);
      } else {
        this.selectedIds = this.selectedIds.filter(val => val !== event.target.value);
      }
    },

    submitAnswers() {
      this.hasSubmitted = true;

      const answers = this.options
        .filter(option => this.selectedIds.indexOf(option.id) !== -1);

      this.percentageSum = answers
        .reduce((acc, currentOption) => acc + Number(currentOption.percentage_value), 0);

      this.$emit('input', answers);
    },
  },

};

</script>

<style lang="scss" scoped>

  @import '../../../assets/scss/utilities';

  .theme-training {
    .primary-button {
      @apply bg-training-500;
    }
  }

  .theme-scientific {
    .primary-button {
      @apply bg-scientific-500;
    }
  }

  .question__multiple-answers {
    @apply w-full #{!important};

    &-label {
      @apply block;
      @apply flex;
      @apply flex-col;
      @apply items-center;
      @apply mb-15;
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
      @apply mb-3;

      &-wrapper {
        @apply cursor-pointer;
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

            .question__multiple-answers-text {
              @apply text-gray-900;
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
