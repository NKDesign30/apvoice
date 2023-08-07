<template>
  <div
    class="flyout-menu"
    :class="{ 'is-open': isMenuOpen }"
  >
    <div>
      <slot
        name="toggle"
        :toggle-menu="toggleMenu"
      />
    </div>

    <apo-drop-down-up-transition>
      <div
        v-if="isMenuOpen"
        class="flyout-menu-items z-20"
      >
        <button
          class="mt-2 mb-4 px-4 py-2 w-full flex justify-center text-white"
          type="button"
          @click="isMenuOpen = false"
        >
          <apo-icon
            class="w-6 tablet:w-8"
            src="close"
          />
        </button>

        <slot :toggle-menu="toggleMenu" />
      </div>
    </apo-drop-down-up-transition>
  </div>
</template>

<script>

export default {
  data() {
    return {
      isMenuOpen: false,
    };
  },

  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
  },
};

</script>

<style lang="scss" scoped>

.flyout-menu {
  &-items {
    @apply pb-2;
    @apply absolute;
    @apply top-0;
    @apply right-0;

    background-color: rgba(0, 0, 0, 0.8);
  }
}

</style>
