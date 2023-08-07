<template>
  <button
    class="button"
    v-bind="$attrs"
    v-on="$listeners"
  >
    <slot />
  </button>
</template>

<style lang="scss" scoped>

@screen tablet {
  .button {
    @apply px-12;
    @apply py-6;
    @apply text-2xl;
  }
}

.button {
  @apply font-bold;
  @apply inline-flex;
  @apply items-center;
  @apply justify-center;
  @apply px-8;
  @apply py-4;
  @apply rounded-full;
  @apply text-base;

  transition: background-color 0.3s ease;

  &.disbaled, &:disabled{
    opacity: 0.4;
    cursor: default;
  }

  &:focus {
    @apply outline-none;
  }

  &--primary {
    @apply bg-blue-600;
    @apply text-white;

    &:hover {
      @apply bg-blue-800;
    }
  }

  &--secondary,
  &--naked {
    @apply bg-white;

    &:hover {
      @apply bg-gray-100;
    }
  }

  .theme-survey &--primary {
    @apply bg-yellow-500;

    &:hover {
      @apply bg-yellow-600;
    }
  }

  .theme-training &--primary {
    @apply bg-training-500;
    @apply text-white;

    &:hover {
      @apply bg-training-700;
    }

    &.invert {
      @apply bg-white;
      @apply text-training-500;
      &:hover {
        @apply bg-gray-100;
      }
    }
  }

  .theme-knowledge-base &--primary,
  .theme-downloads &--primary {
    @apply bg-purple-500;
    @apply text-white;

    &:hover {
      @apply bg-purple-700;
    }

    &.invert {
      @apply bg-white;
      @apply text-purple-500;
      &:hover {
        @apply bg-gray-100;
      }
    }
  }

  .theme-raffle &--primary {
    @apply bg-green-500;
    @apply text-white;

    &:hover {
      @apply bg-green-700;
    }

    &.invert {
      @apply bg-white;
      @apply text-green-500;
      &:hover {
        @apply bg-gray-100;
      }
    }
  }

  &--small {
    @apply px-12;
    @apply py-3;
    @apply text-xl;
  }

  &--tiny {
    @apply px-8;
    @apply py-3;
    @apply text-base;
  }

  &--big {
    @apply px-12;
    @apply py-8;
    @apply text-base;
  }

  .theme-survey &--naked,
  .theme-survey &--secondary {
    @apply text-yellow-500;
  }

  .theme-training &--naked,
  .theme-training &--secondary  {
    @apply text-training-500;
  }

  .theme-knowledge-base &--naked,
  .theme-knowledge-base &--secondary
  .theme-downloads &--naked,
  .theme-downloads &--secondary  {
    @apply text-purple-500;
  }

  .theme-raffle &--naked,
  .theme-raffle &--secondary  {
    @apply text-green-700;
  }
}

</style>
