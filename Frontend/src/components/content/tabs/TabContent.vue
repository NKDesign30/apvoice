<template>
  <div class="tab-content tablet:mx-20 desktop:mx-0">
    <apo-cms-content-renderer
      :components="content"
    />
  </div>
</template>

<script>

import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

export default {
  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  props: {
    content: {
      type: Array,
      required: true,
    },
  },
};

</script>

<style lang="scss">

.tab-content {
  .cms-content-renderer {
    @apply pt-20;

    > * {
      &:first-child {
        padding-top: 0;
        margin-top: 0;
      }
    }
  }
}

</style>
