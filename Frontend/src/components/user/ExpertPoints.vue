<template>
  <div class="expert-points">
    <div class="expert-points-inner">
      <apo-count-up
        class="expert-points-text"
        :class="{
          'text-6xl': points <= 99,
          'text-5xl': points > 99 && points <= 999,
          'text-4xl': points > 999,
        }"
        :from="0"
        :to="points"
        when-in-viewport
      />
    </div>
  </div>
</template>

<script>

export default {
  props: {
    points: {
      type: Number,
      default: 0,
    },
  },
};

</script>

<style lang="scss" scoped>

.expert-points {
  @apply flex;
  @apply bg-orange-600;
  @apply border-5;
  @apply border-white;
  @apply rounded-full;

  padding: calc(theme('padding.px') * 2);
  box-shadow: 0 4px 0 1px rgba(0, 0, 0, 0.2);
  min-height: theme('height.32');
  min-width: theme('width.32');

  // width: 120px;
  // height: 120px;
  // padding: 2px;
  // background-color: #ff7000;
  // border-radius: 100%;
  // overflow: hidden;
  // border: 5px solid #fff;
  // box-shadow: 0 4px 0 1px rgba(0,0,0,.2);

  &-inner {
    @apply w-full;
    @apply bg-white;
    @apply rounded-full;
    @apply flex;
    @apply justify-center;
    @apply items-center;
  }

  &-text {
    @apply text-orange-600;
    @apply font-bold;
    @apply tracking-wide;
  }
}

</style>
