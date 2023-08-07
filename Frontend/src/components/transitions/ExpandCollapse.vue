<template>
  <transition
    name="expand-collapse"
    @enter="enter"
    @after-enter="afterEnter"
    @leave="leave"
  >
    <slot />
  </transition>
</template>

<script>

/* eslint-disable no-param-reassign, no-unused-expressions */
export default {
  methods: {
    enter(element) {
      const { width } = getComputedStyle(element);

      element.style.width = width;
      element.style.position = 'absolute';
      element.style.visibility = 'hidden';
      element.style.height = 'auto';

      const { height } = getComputedStyle(element);

      element.style.width = null;
      element.style.position = null;
      element.style.visibility = null;
      element.style.height = 0;

      // Force repaint to make sure the
      // animation is triggered correctly.
      getComputedStyle(element).height;

      // Trigger the animation.
      // We use `setTimeout` because we need
      // to make sure the browser has finished
      // painting after setting the `height`
      // to `0` in the line above.
      setTimeout(() => {
        element.style.height = height;
      });
    },

    afterEnter(element) {
      element.style.height = 'auto';
    },

    leave(element) {
      const { height } = getComputedStyle(element);

      element.style.height = height;

      // Force repaint to make sure the animation is triggered correctly.
      getComputedStyle(element).height;

      setTimeout(() => {
        element.style.height = 0;
      });
    },
  },
};
/* eslint-enable no-param-reassign, no-unused-expressions */

</script>

<style scoped>

* {
  will-change: height;
  transform: translateZ(0);
  backface-visibility: hidden;
  perspective: 1000px;
}

.expand-collapse-enter-active,
.expand-collapse-leave-active {
  @apply overflow-hidden;

  transition: height 0.25s ease-in-out;
}

.expand-collapse-enter,
.expand-collapse-leave-to {
  @apply h-0;
}

</style>
