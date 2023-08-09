<template>
  <button
    class="choice-button"
    :class="{ 'is-active': isActive }"
    v-bind="$attrs"
    v-on="$listeners"
  >
    <span class="choice-button-inner">
      <slot />
    </span>
  </button>
</template>

<script>

export default {
  props: {
    isActive: {
      type: Boolean,
      default: false,
    },
  },
};

</script>

<style lang="scss" scoped>

@import '../../assets/scss/utilities';

.choice-button {
  @apply bg-gray-700;
  @apply inline-flex;
  @apply p-1;
  @apply rounded-full;
  flex-basis: 100%;

  @extend .transition-background-color;
  @extend .transition-ease;
  @extend .transition-fast;

  &-inner {
    @apply bg-white;
    @apply border-4;
    @apply border-white;
    @apply inline-block;
    @apply py-4;
    @apply rounded-full;
    @apply text-center;
    @apply text-gray-700;
    @apply text-xl;
    @apply w-full;

    @extend .transition-background-color;
    @extend .transition-color;
    @extend .transition-ease;
    @extend .transition-fast;

  }

  &:hover,
  &.is-active {
    @apply bg-gray-900;
  }

  &:hover &-inner,
  &.is-active &-inner {
    @apply bg-gray-900;
    @apply text-white;
  }

  &:focus {
    @apply outline-none;
  }

  @screen desktop {
    @apply min-w-48;
  }
}

</style>
