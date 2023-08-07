<template>
  <!-- eslint-disable-next-line max-len -->
  <div class="flex justify-center items-center rounded-full font-display font-bold font text-yellow-500 bg-white score-shadow">
    <apo-count-up
      :to="parseInt(expertPoints)"
      when-in-viewport
    />
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters(['expertPoints']),
  },
};

</script>

<style lang="scss" scoped>
.score-shadow {
  box-shadow: 0 4px 0 1px rgba(0,0,0,.2),
  inset 0px 0px 0px 3px white,
  inset 0px 0px 0px 5px theme('colors.yellow.500');
}

@screen tablet {
  .score-shadow {
    box-shadow: 0 4px 0 1px rgba(0,0,0,.2),
    inset 0px 0px 0px 5px white,
    inset 0px 0px 0px 9px theme('colors.yellow.500');
  }
}
</style>
