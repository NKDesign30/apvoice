<template>
  <apo-collapsible-content
    class="interactive-list-content py-6"
    :show="show"
  >
    <template v-if="item">
      <div class="container relative">
        <div class="px-6 py-4">
          <apo-cms-content-renderer
            :components="item.content || []"
          />

          <button
            class="mr-4 desktop:mr-0 -mt-3 desktop:mt-0 absolute right-0 top-0 text-gray-900 focus:outline-none"
            type="button"
            @click="$emit('close')"
          >
            <apo-icon
              class="w-4"
              src="close"
            />
          </button>
        </div>
      </div>
    </template>
  </apo-collapsible-content>
</template>

<script>
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

export default {
  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  props: {
    item: {
      validator: prop => typeof prop === 'object' || prop === null,
      required: true,
      default: null,
    },

    show: {
      type: Boolean,
      default: false,
    },
  },
};

</script>
