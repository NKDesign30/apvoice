<template>
  <div
    class="wysiwyg-content"
    v-html="$options.filters.formatContent(content)"
  />
</template>

<script>

export default {
  props: {
    content: {
      type: String,
      required: true,
    },
  },
};

</script>

<style lang="scss">

.wysiwyg-content {

  ul {
    list-style: disc;
  }

  ol {
    list-style: decimal;
  }

  ul, ol {
    margin-block-start: 1rem;
    margin-block-end: 1rem;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
  }

}

</style>
