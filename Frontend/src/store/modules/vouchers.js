import VoucherService from '@/services/api/VoucherService';
import {
  VOUCHERS_FETCH_ALL,
  VOUCHERS_EXCHANGE_POINTS,
  VOUCHERS_REDEEM_VOUCHER,
  AUTH_FETCH_CURRENT_USER,
} from '@/store/types/action-types';
import {
  VOUCHERS_UPDATE_ALL,
  VOUCHERS_UPDATE_NOTIFICATION,
  VOUCHERS_CLEAR_NOTIFICATION,
} from '@/store/types/mutation-types';
// eslint-disable-next-line import/no-cycle
import i18n from '@/i18n';

export default {
  state: {
    vouchers: [],
    voucherNotification: {
      show: false,
      message: null,
    },
  },

  mutations: {
    [VOUCHERS_UPDATE_ALL](state, updatedVouchers) {
      state.vouchers = updatedVouchers;
    },
    [VOUCHERS_UPDATE_NOTIFICATION](state, updatedNotification) {
      state.voucherNotification = updatedNotification;
    },
    [VOUCHERS_CLEAR_NOTIFICATION](state) {
      state.voucherNotification = {
        show: false,
        message: null,
      };
    },
  },

  actions: {
    [VOUCHERS_FETCH_ALL]({ dispatch, commit, state }) {
      if (state.vouchers.length === 0) {
        dispatch('wait/start', 'vouchers', { root: true });
      }

      return new Promise((resolve, reject) => {
        VoucherService.fetchAll()
          .then(vouchers => {
            commit(VOUCHERS_UPDATE_ALL, vouchers);
            dispatch('wait/end', 'vouchers', { root: true });
            resolve(vouchers);
          }).catch(reject);
      });
    },

    [VOUCHERS_EXCHANGE_POINTS]({ dispatch, commit }) {
      commit(VOUCHERS_CLEAR_NOTIFICATION);
      return new Promise((resolve, reject) => {
        VoucherService.exchange()
          .then(voucher => {
            dispatch(VOUCHERS_FETCH_ALL);
            dispatch(AUTH_FETCH_CURRENT_USER);
            commit(VOUCHERS_UPDATE_NOTIFICATION, {
              show: true,
              message: i18n.t('pages.redeem.notifications.success', {
                points: 50,
                voucherCode: voucher.voucher_code,
              }),
            });
            resolve(voucher);
          }).catch(error => {
            commit(VOUCHERS_UPDATE_NOTIFICATION, {
              show: true,
              message: (error.response.data.code === 'exceeded_voucher_capping' ? error.response.data.message : i18n.t(`pages.redeem.error.text`)),
            });
            reject(error);
          });
      });
    },

    // eslint-disable-next-line camelcase
    [VOUCHERS_REDEEM_VOUCHER]({ dispatch, commit }, { voucher_code }) {
      commit(VOUCHERS_CLEAR_NOTIFICATION);
      return new Promise((resolve, reject) => {
        VoucherService.redeem(voucher_code)
          .then(voucher => {
            dispatch(VOUCHERS_FETCH_ALL);
            resolve(voucher);
          }).catch(reject);
      });
    },
  },

  getters: {
    vouchers(state) {
      return state.vouchers;
    },
    assignedVouchers(state) {
      // eslint-disable-next-line eqeqeq
      return state.vouchers.filter(voucher => voucher.redeemed == 0);
    },
    redeemedVouchers(state) {
      // eslint-disable-next-line eqeqeq
      return state.vouchers.filter(voucher => voucher.redeemed == 1);
    },
    voucherNotification(state) {
      return state.voucherNotification;
    },
  },
};
