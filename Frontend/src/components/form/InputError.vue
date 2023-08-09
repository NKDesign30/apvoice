<template>
  <small
    v-if="errors.has(field)"
    class="text-red-500 text-xs font-bold"
    v-html="$options.filters.formatContent(error)"
  />
</template>

<script>

import head from 'lodash/head';

export default {
  props: {
    // eslint-disable-next-line vue/require-prop-types
    errors: {
      required: true,
    },

    field: {
      type: String,
      required: true,
    },
  },

  computed: {
    error() {
      return head(this.errors.get(this.field)) || '';
    },
  },
};

</script>
