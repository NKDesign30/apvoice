export default class VoucherService {
  static fetchAll() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/vouchers/v1/user')
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static exchange() {
    return new Promise((resolve, reject) => {
      window.axios.post('/wp-json/vouchers/v1/assign')
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static redeem(voucherCode) {
    return new Promise((resolve, reject) => {
      window.axios.post('/wp-json/vouchers/v1/redeem', { voucher_code: voucherCode })
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }
}
