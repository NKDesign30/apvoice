<template>
  <div class="page-progress">
    <vue-progress-bar />
  </div>
</template>

<style lang="scss" scoped>

.page-progress {
  /deep/ .__cov-progress {
    @apply bg-training-400 #{!important};

    position: relative !important;
  }
}

</style>
