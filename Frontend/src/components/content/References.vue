<template>
  <apo-wysiwyg-content
    class="container text-xs"
    :content="references"
  />
</template>

<script>
export default {
  props: {
    references: {
      type: String,
      default: '',
      required: false,
    },
  },
};
</script>
