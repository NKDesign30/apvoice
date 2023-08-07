<template>
  <div class="page-indicator-wrapper">
    <slot />
  </div>
</template>

<script>

export default {
  provide() {
    return {
      pageIndicatorsState: this.sharedState,
    };
  },
  data() {
    return {
      sharedState: {
        activePageIndicator: null,
        pageIndicators: [],
      },
    };
  },

  methods: {
    getNextPageIndicator(pageIndicatorId) {
      const pageIndicatorIndex = this.sharedState.pageIndicators
        .findIndex(pageIndicator => pageIndicator.id === pageIndicatorId);

      if (pageIndicatorIndex === -1) {
        return null;
      }

      return this.sharedState.pageIndicators[pageIndicatorIndex + 1] || null;
    },
  },

  created() {
    this.$on('continue', pageIndicatorId => {
      const nextPageIndicator = this.getNextPageIndicator(pageIndicatorId);

      if (nextPageIndicator !== null) {
        this.sharedState.activePageIndicator = nextPageIndicator.id;
      }
    });
  },
};
</script>
