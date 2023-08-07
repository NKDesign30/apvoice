<template>
  <div
    class="selection-spacer"
    v-text="$t('modules.selection.or')"
  />
</template>

<style lang="scss" scoped>

.selection-spacer {
  @apply text-gray-900;
  @apply font-display;
  @apply text-4xl;
  @apply hidden;

  @screen desktop {
    @apply flex;
    @apply justify-center;
    @apply items-center;
  }
}

</style>
