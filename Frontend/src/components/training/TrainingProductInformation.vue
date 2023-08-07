<template>
  <div class="training-product-information">
    <apo-cms-content-renderer :components="components" />
  </div>
</template>

<script>

import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

export default {
  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  props: {
    productInformation: {
      type: [Array, Boolean],
      default: () => [],
    },
  },

  computed: {
    components() {
      return Array.isArray(this.productInformation) ? this.productInformation : [];
    },
  },
};

</script>
