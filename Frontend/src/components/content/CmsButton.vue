<template>
  <div class="cms-button text-center">
    <router-link
      v-if="isInternalUrl"
      :to="url"
      class="shadow-hard-dark"
      :class="`button--${cmsButton.button_style}`"
      tag="apo-button"
      v-text="title"
    />
    <apo-button
      v-else
      class="shadow-hard-dark"
      :class="`button--${cmsButton.button_style}`"
    >
      <a
        :href="url"
        target="_blank"
        v-html="$options.filters.formatContent(title)"
      />
    </apo-button>
  </div>
</template>

<script>
import get from 'lodash/get';
import { stripHostnameFromUrl } from '@/services/utils';

export default {
  props: {
    cmsButton: {
      type: Object,
      required: true,
    },
  },
  computed: {
    isInternalUrl() {
      return window.location.host === new URL(this.cmsButton.link).host;
    },
    url() {
      if (this.isInternalUrl) {
        return stripHostnameFromUrl(this.cmsButton.link);
      }
      return this.cmsButton.link;
    },
    title() {
      return get(this.cmsButton, 'title', '');
    },
  },
};

</script>

<style lang="scss" scoped>

/* Component Styles */

</style>
