<template>
  <div class="redeem-voucher-list">
    <apo-redeem-voucher-list-item
      v-for="item in items"
      :key="item.id"
      :item="item"
    />
  </div>
</template>

<script>
import RedeemVoucherListItem from '@/components/redeem/RedeemVoucherListItem.vue';

export default {

  components: {
    'apo-redeem-voucher-list-item': RedeemVoucherListItem,
  },

  props: {
    items: {
      type: Array,
      default: () => [],
      required: true,
    },
  },

};

</script>

<style lang="scss" scoped>

/* Component Styles */

</style>
