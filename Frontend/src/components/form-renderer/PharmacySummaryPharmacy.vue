<template>
  <apo-wait :for="'pharmacy-' + uid">
    <template #waiting>
      <apo-loading-overlay
        class="my-15"
      />
    </template>
    <div
      v-if="pharmacy && pharmacy.name"
      class="pharmacy-summary-pharmacy py-8 px-4 mt-4 tablet:text-center bg-blue-100 force-full-width"
    >
      <div class="container static tablet:relative flex flex-col tablet:flex-row">
        <div class="tablet:px-4 w-full tablet:w-1/2 flex flex-col">
          <span
            class="inline-block font-bold text-gray-900"
            v-text="$t('general.pun')"
          />
          <span class="mt-2 inline-block text-gray-800">
            {{ computedPharmacy.pharmacyUniqueNumber || computedPharmacy.pgCustomerId | formattedNumber }}
          </span>
        </div>
        <div class="mt-6 tablet:mt-0 tablet:px-4 w-full tablet:w-1/2 flex flex-col">
          <span
            class="inline-block font-bold text-gray-900"
            v-text="$t('general.pharmacy')"
          />
          <span
            class="mt-2 inline-block text-gray-800"
            v-html="$options.filters.formatContent(computedPharmacy.name)"
          />
        </div>

        <slot name="after" />
      </div>
    </div>
  </apo-wait>
</template>

<script>

import PharmacyService from '@/services/api/PharmacyService';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';

export default {
  components: {
    'apo-loading-overlay': LoadingOverlay,
  },

  props: {
    number: {
      type: String,
      required: true,
    },
    uid: {
      type: Number,
      required: true,
    },
  },

  data() {
    return {
      pharmacy: null,
    };
  },

  computed: {
    computedPharmacy() {
      return this.pharmacy;
    },
  },

  created() {
    this.$store.dispatch('wait/start', `pharmacy-${this.uid}`, { root: true });
    PharmacyService.fetchById(this.number)
      .then(response => {
        this.pharmacy = response;
        this.$store.dispatch('wait/end', `pharmacy-${this.uid}`, { root: true });
      })
      .catch(() => {
        this.$store.dispatch('wait/end', `pharmacy-${this.uid}`, { root: true });
      });
  },
};

</script>

<style lang="scss" scoped>
  .force-full-width {
    margin-left: calc(-50vw + 50% + 7px);
    width: calc(100vw - 15px);
  }
</style>
