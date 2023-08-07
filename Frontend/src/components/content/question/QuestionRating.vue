<template>
  <div class="question__rating">
    <div class="mt-6 flex justify-around">
      <label
        v-for="(option, index) in options"
        :key="option.id"
        :for="option.id"
        class="question__rating--label"
        :class="{ 'is-active': option.value === selectedOption }"
        :title="option.value"
        :disabled="selectedOption"
      >
        <input
          :id="option.id"
          v-model="selectedOption"
          class="h-full w-full cursor-pointer"
          :name="`question__rating-${option.id}`"
          type="radio"
          :value="option.value"
          :disabled="selectedOption"
          @change="emitOption(option)"
        >

        <div
          class="question__rating--number"
          v-text="index + 1"
        />
      </label>
    </div>
    <apo-question-response-message
      v-if="responseMessage"
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
      type: Array,
      requied: true,
      default: () => [],
    },
  },

  data() {
    return {
      selectedOption: null,
      responseIdentifier: null,
    };
  },

  computed: {
    responseMessage() {
      if (!this.responseIdentifier) return null;
      return this.responseMessages
        .find(msg => msg.related_to.indexOf(String(this.responseIdentifier)) !== -1)
        .response_message;
    },
  },

  methods: {
    emitOption(option) {
      this.responseIdentifier = this.options.findIndex(o => o.id === option.id) + 1;
      this.$emit('input', option);
    },
  },
};

</script>

<style lang="scss" scoped>

@import '../../../assets/scss/utilities';


.question__rating {
  &--label {
    @apply border-gray-700;
    @apply block;
    @apply border-4;
    @apply cursor-pointer;
    @apply h-16;
    @apply overflow-hidden;
    @apply relative;
    @apply rounded-full;
    @apply w-16;

    @extend .transition-border-color;
    @extend .transition-ease;
    @extend .transition-fast;

    &:hover,
    &.is-active {
      @apply border-gray-900;
    }
  }

  &--number {
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

  &--label:hover &--number,
  &--label.is-active &--number {
    @apply bg-gray-900;
    @apply text-white;
  }
}

</style>
