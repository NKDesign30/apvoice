<template>
  <input
    type="hidden"
    :value="value"
    v-bind="$attrs"
    v-on="$listeners"
  >
</template>

<script>

export default {
  props: {
    value: {
      type: String,
      default: '',
    },
  },
};

</script>
