<template>
  <div class="cms-page">
    <component
      :is="`apo-cms-${renderer}-renderer`"
      v-for="(components, renderer) in filteredContent"
      :key="`${renderer}-renderer`"
      :components="components || []"
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
      type: Object,
      default() {
        return {};
      },
    },
  },

  computed: {
    filteredContent() {
      const {
        /* eslint-disable */
        password, minimum_height, slides, public_resource, content_position, ...filtered
      } = this.content;
      /* eslint-enable */
      return filtered;
    },
  },
};

</script>
