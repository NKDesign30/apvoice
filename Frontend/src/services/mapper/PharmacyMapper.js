import get from 'lodash/get';

export default class PharmacyMapper {
  static mapPharmacy(data) {
    return {
      id: get(data, 'id', ''),
      name: get(data, 'name', ''),
      pharmacyUniqueNumber: get(data, 'pharmacy_unique_number', ''),
      pgCustomerId: get(data, 'pg_customer_id', ''),
    };
  }
}
