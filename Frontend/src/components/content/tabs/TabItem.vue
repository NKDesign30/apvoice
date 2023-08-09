<template>
  <button
    class="tab-item"
    v-on="$listeners"
  >
    <p class="tab-item-label">
      <slot>
        <span v-html="$options.filters.formatContent(label)" />
      </slot>
    </p>
  </button>
</template>

<script>

export default {
  props: {
    label: {
      type: String,
      required: true,
    },
  },
};

</script>

<style lang="scss" scoped>

.tab-item {
  @apply py-4;
  @apply px-13;
  @apply border-l-2;
  @apply border-r-2;
  @apply border-b-2;
  @apply border-blue-400;
  @apply bg-white;
  @apply text-blue-400;
  @apply flex;
  @apply items-center;
  @apply w-full;

  height: auto;

  &:focus {
    @apply outline-none;
  }

  @screen desktop {
    @apply bg-blue-400;
    @apply text-white;
    @apply rounded-t-xl;
    @apply px-5;
    @apply max-w-xxs;
    @apply ml-6;
    @apply border-t-2;
  }

  &:first-child {
    @apply border-t-2;

    @screen desktop {
      @apply ml-0;
    }
  }

  &.is-active {
    @apply bg-blue-400;
    @apply text-white;
  }

  &-label {
    @apply p-0;
    @apply w-full;
    @apply text-2xl;
    @apply font-bold;
    @apply text-left;

    text-overflow: ellipsis;

    @screen desktop {
      @apply overflow-hidden;
      @apply text-center;
      @apply font-normal;
      @apply text-lg;
    }
  }
}

</style>
