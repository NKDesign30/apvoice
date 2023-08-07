<template>
  <div
    class="html-block"
    v-bind="$attrs"
    v-on="$listeners"
    v-html="$options.filters.formatContent(meta.content)"
  />
</template>

<script>

export default {
  props: {
    meta: {
      type: Object,
      required: true,
    },
  },
};

</script>
