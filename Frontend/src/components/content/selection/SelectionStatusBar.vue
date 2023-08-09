<template>
  <div
    v-if="status !== ''"
    class="selection-status-bar"
    :class="`is-${status}`"
  />
</template>

<script>

export default {
  props: {
    status: {
      type: String,
      default: '',
    },
  },
};

</script>

<style lang="scss" scoped>

.selection-status-bar {
  @apply opacity-50;
  @apply h-2.5;

  animation-name: flash;
  animation-duration: 1s;
  animation-timing-function: ease;

  &.is-success {
    @apply bg-green-200;
  }

  &.is-failure {
    @apply bg-red-500;
  }
}

@keyframes flash {
  0%,
  25%,
  75% {
    @apply opacity-0;
  }

  50%,
  100% {
    @apply opacity-50;
  }
}

</style>
