<template>
  <div class="cms-content-renderer">
    <component
      :is="resolveComponentName(component.acf_fc_layout)"
      v-for="component in components"
      :key="contentId(component.acf_fc_layout)"
      :parent-id="id"
      v-bind="component"
      class="spacer-module"
    />
  </div>
</template>

<script>

import { contentId, resolveComponentName } from '@/services/utils';

export default {
  props: {
    components: {
      type: Array,
      default() {
        return [];
      },
    },
    id: {
      type: Number,
      required: false,
      default: null,
      validator: prop => typeof prop === 'number' || prop === null,
    },
  },

  methods: {
    contentId(layoutName) {
      return contentId(layoutName);
    },

    resolveComponentName(layoutName) {
      return resolveComponentName(layoutName);
    },
  },
};

</script>

<style lang="scss" scoped>

/deep/ .cms-content-renderer {
  > .spacer-module {
    &:first-child {
      @apply pt-0 #{!important};
    }
  }
}

</style>
