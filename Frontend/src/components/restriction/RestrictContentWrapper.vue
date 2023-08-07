<template>
  <apo-wait for="pagePermissions">
    <template #waiting>
      <apo-loading-overlay
        class="my-15"
        :message="$t('loaders.pagePermissions')"
      />
    </template>

    <template v-if="hasPagePermissions">
      <slot />
    </template>

    <apo-restrict-user-dashboard-not-allowed-page-visit v-else />
  </apo-wait>
</template>

<script>
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import pagePermissionsCheck from '@/mixins/page-permissions-check';
import RestrictUserDashboardNotAllowedPageVisit from '@/components/restriction/RestrictUserDashboardNotAllowedPageVisit.vue';

export default {

  components: {
    'apo-loading-overlay': LoadingOverlay,
    'apo-restrict-user-dashboard-not-allowed-page-visit': RestrictUserDashboardNotAllowedPageVisit,
  },

  mixins: [
    pagePermissionsCheck(),
  ],
};

</script>
