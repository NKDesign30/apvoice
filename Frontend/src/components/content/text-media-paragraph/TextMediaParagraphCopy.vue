<template>
  <apo-wysiwyg-content
    class="text-media-paragraph__copy"
    :content="copy"
  />
</template>

<script>

export default {
  props: {
    copy: {
      type: String,
      required: false,
      default: '',
    },
  },
};
</script>


<style lang="scss">

.text-media-paragraph__copy {
  @apply font-display;
}

</style>
