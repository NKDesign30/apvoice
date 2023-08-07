<template>
  <apo-expand-collapse-transition>
    <div
      v-if="show"
      class="collapsible-content"
      :class="{ 'force-full-width': forceFullWidth }"
    >
      <slot />
    </div>
  </apo-expand-collapse-transition>
</template>

<script>

export default {
  props: {
    show: {
      type: Boolean,
      default: false,
    },

    forceFullWidth: {
      type: Boolean,
      default: true,
    },
  },

  watch: {
    show: {
      immediate: true,
      handler(show) {
        document.body.classList[show ? 'add' : 'remove']('overflow-x-hidden');

        this.$nextTick(() => this.$emit(show ? 'expanded' : 'collapsed'));
      },
    },
  },
};

</script>

<style lang="scss" scoped>

.collapsible-content {
  box-shadow: inset 1px 4px 9px -6px, inset 1px -4px 9px -6px;

  &.force-full-width {
    margin-left: calc(-50vw + 50%);
    width: 100vw;
  }
}

</style>
