<template>
  <div
    class="situational-cases__mobile-dialog flex"
    :class="{ 'flex-row-reverse' : reverse}"
  >
    <div
      class="situational-cases__avatar flex-shrink-0"
      :style="{ 'background-image': `url(${avatar})` }"
    />
    <div
      class="situational-cases__mobile-dialog-text flex-1 px-4"
      v-html="$options.filters.formatContent(text)"
    />
  </div>
</template>

<script>

export default {

  props: {
    avatar: {
      type: String,
      required: true,
    },
    text: {
      type: String,
      required: true,
    },
    reverse: {
      type: Boolean,
      required: false,
      default: false,
    },
  },

};
</script>

<style lang="scss" scoped>

.situational-cases__avatar {
  @apply w-20;
  @apply h-20;
  @apply rounded-full;
  @apply bg-cover;
}
</style>
