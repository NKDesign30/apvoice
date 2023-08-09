<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center overflow-hidden wrapper">
    <div class="w-11/12 bg-white rounded-lg shadow-lg modal desktop:w-1/2">
      <div
        v-if="$slots.header || $scopedSlots.header"
        class="px-6 py-4 text-white gradient-blue"
      >
        <slot name="header" />
      </div>
      <div class="px-6 py-4">
        <slot />
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Modal',
};

</script>

<style lang="scss" scoped>

.wrapper {
  background-color: rgba(0,0,0,0.65);
}

.modal{
  max-height: 95vh;
  overflow: auto;
}

.gradient-blue {
  background: linear-gradient(120deg, theme('colors.blue.700'), theme('colors.blue.500'));
}

</style>
