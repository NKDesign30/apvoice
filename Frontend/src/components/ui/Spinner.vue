<template>
  <vue-simple-spinner
    v-bind="attrs"
    v-on="$listeners"
  />
</template>

<script>

import Spinner from 'vue-simple-spinner';

export default {
  components: {
    'vue-simple-spinner': Spinner,
  },

  computed: {
    attrs() {
      return {
        speed: 0.9,
        ...this.$attrs,
      };
    },
  },
};

</script>

<style lang="scss">

/deep/ .vue-simple-spinner {
  border-color:
    theme('colors.white')
    theme('colors.blue.600')
    theme('colors.blue.600')
    #{!important};
}

.theme-training /deep/ .vue-simple-spinner {
  border-color:
    theme('colors.transparent')
    theme('colors.training.500')
    theme('colors.training.500')
    #{!important};
}

.theme-survey /deep/ .vue-simple-spinner {
  border-color:
    theme('colors.transparent')
    theme('colors.orange.600')
    theme('colors.orange.600')
    #{!important};
}

.theme-knowledge-base /deep/ .vue-simple-spinner,
.theme-downloads /deep/ .vue-simple-spinner {
  border-color:
    theme('colors.transparent')
    theme('colors.purple.300')
    theme('colors.purple.300')
    #{!important};
}

.theme-raffle /deep/ .vue-simple-spinner {
  border-color:
    theme('colors.transparent')
    theme('colors.green.500')
    theme('colors.green.500')
    #{!important};
}

</style>
