<template>
  <!--eslint-disable max-len -->
  <div
    class="py-8 mb-10 redeem__voucher-code"
    :class="[isRedeemed ? 'voucher-code--is-redeemed' : 'voucher-code--is-assigned'] "
  >
    <div class="container flex flex-col items-center justify-between tablet:flex-row">
      <div class="flex flex-col items-center voucher-code tablet:flex-row tablet:w-5/6">
        <p class="w-full mb-4 text-4xl uppercase voucher-code__code tablet:mr-8 tablet:max-w-xs tablet:mb-0">
          {{ item.voucher_code }}
        </p>
        <div class="mb-4 text-sm voucher-code__expires-at tablet:text-2xl tablet:mb-0">
          {{ $t('pages.redeem.messages.expiresAt', { date: item.expires_at }) }}
        </div>
      </div>
      <div
        class="voucher-code__action tablet:w-1/6 text-center"
        :class="{ 'flex flex-col items-center' : isRedeemed}"
      >
        <template v-if="isRedeemed">
          <apo-icon
            v-if="isRedeemed"
            class="w-24 fill-current tablet:w-16"
            style="color: #bebebe"
            src="check"
          />
          <a
            target="_blank"
            :href="`${bonagoVoucherUrl}${item.voucher_code}`"
            class="cursor-pointer mt-2 text-sm underline text-gray-900"
            v-text="$t('general.show')"
          />
        </template>
        <apo-button
          v-else
          class="text-yellow-500 button--naked button--tiny shadow-hard"
          @click="onRedeem"
          v-text="$t('pages.redeem.buttons.use')"
        >
          <apo-spinner
            v-if="isBusy"
            class="ml-4"
            size="small"
          />
        </apo-button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { VOUCHERS_REDEEM_VOUCHER } from '@/store/types/action-types';

export default {
  props: {
    item: {
      type: Object,
      default: () => {},
      required: true,
    },
  },

  data() {
    return {
      isBusy: false,
    };
  },


  computed: {
    ...mapGetters(['bonagoVoucherUrl']),

    isRedeemed() {
      // eslint-disable-next-line eqeqeq
      return this.item.redeemed == '1';
    },
    isiOSSafari() {
      return /iPhone|iPad|iPod/i.test(window.navigator.userAgent);
    },
  },

  methods: {
    ...mapActions([VOUCHERS_REDEEM_VOUCHER]),

    onRedeem() {
      this.isBusy = true;

      let windowReference = null;

      if (this.isiOSSafari) {
        windowReference = window.open();
      }

      this[VOUCHERS_REDEEM_VOUCHER](this.item)
        .then(voucher => {
          if (this.isiOSSafari) {
            windowReference.location = voucher.bonago_url;
          } else {
            window.open(voucher.bonago_url, '_blank');
          }
        })
        .catch(error => {
          if (this.isiOSSafari) {
            windowReference.close();
          }
          console.log('error on redeeming this voucher', error);
        })
        .finally(() => {
          this.isBusy = false;
        });
    },

  },
};

</script>

<style lang="scss" scoped>


.voucher-code {

  &--is-assigned {
    @apply bg-yellow-200;

    .voucher-code__code {
      @apply text-yellow-500;
    }

    .voucher-code__expires-at {
      @apply text-gray-800;
    }
  }

  &--is-redeemed {
    background-color: #f0eee0;

    .voucher-code__code, .voucher-code__expires-at {
      color: #bebebe;
    }
  }
}

</style>
