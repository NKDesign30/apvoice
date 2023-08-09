<template>
  <div
    v-if="voucherNotification.show"
    class="absolute z-10 mx-auto mb-10 w-full max-w-2xl p-4 rounded-full bg-red-300 text-white shadow-hard"
    style="left: 0; right: 0; top: 180px;"
  >
    <div class="notification-inner mx-auto relative w-11/12">
      <p
        class="w-5/6 mx-auto"
        v-html="$options.filters.formatContent(voucherNotification.message)"
      />
      <span
        class="absolute top-0 right-0"
      >
        <apo-icon
          class="w-5 cursor-pointer"
          src="close"
          @click="VOUCHERS_CLEAR_NOTIFICATION"
        />
      </span>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
import { VOUCHERS_UPDATE_NOTIFICATION, VOUCHERS_CLEAR_NOTIFICATION } from '@/store/types/mutation-types';

export default {

  computed: {
    ...mapGetters(['voucherNotification']),
  },

  methods: {
    ...mapMutations([VOUCHERS_UPDATE_NOTIFICATION, VOUCHERS_CLEAR_NOTIFICATION]),
  },

  destroyed() {
    this[VOUCHERS_CLEAR_NOTIFICATION]();
  },

};

</script>
