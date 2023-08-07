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
      class="inline-flex flex-wrap justify-center text-center"
    >
      <div
        v-for="item in items"
        :key="item.id"
        class="flex flex-col flex-wrap justify-center flex-auto mt-10"
      >
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
  },

  data() {
    return {
      selectedOption: '',
    };
  },
  mounted() {
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
