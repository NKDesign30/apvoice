<template>
  <apo-modal>
    <template
      v-if="!isBusy"
      #header
    >
      <h3>Hallo {{ firstName }}!</h3>
      <h5>Wir möchten dich bitten die Adresse deiner Apotheke nochmals zu bestätigen.</h5>
    </template>
    <apo-spinner
      v-if="isBusy"
      size="large"
    />
    <div v-else>
      <div class="mb-10 text-gray-800">
        <h4>
          Deine aktuelle Apotheke
        </h4>
        <ul>
          <li>{{ pharmacy.pharmacyName || '' }}</li>
          <li>{{ pharmacy.pharmacyStreet || '' }} {{ pharmacy.pharmacyStreetNo || '' }}</li>
          <li>{{ pharmacy.pharmacyZipCode || '' }} {{ pharmacy.pharmacyCity || '' }}</li>
        </ul>
      </div>

      <div>
        <div
          v-if="selectedPharmacy"
          class="px-4 py-4 mt-4 -ml-6 -mr-6 bg-blue-100 tablet:text-center"
        >
          <div class="mr-2 text-right">
            <button
              class="p-2"
              type="button"
              :title="$t('general.remove')"
              :disabled="isConfirming"
              @click="removeSelectedPharmacy"
            >
              <apo-icon
                class="w-4 tablet:w-6"
                src="close"
              />
            </button>
          </div>
          <div class="flex flex-wrap">
            <div
              v-for="(value, key) in selectedPharmacy"
              :key="key"
              class="flex flex-col w-full my-4 tablet:px-4 tablet:w-1/3"
            >
              <span
                class="inline-block font-bold text-gray-900"
                v-text="$t(`modules.pharmacySummary.form.${key}`)"
              />
              <span
                class="inline-block mt-2 text-gray-800"
                v-html="$options.filters.formatContent(value)"
              />
            </div>
          </div>
        </div>
        <apo-pharmacies-fuzzy-search
          v-else
          @selected="onSelect"
        >
          <div class="flex flex-col mt-2 tablet:flex-row">
            <span class="text-gray-900 tablet:mr-2">{{ $t('general.lookingForPharmacy') }} </span>
            <router-link
              :to="{name: 'contact'}"
              class="text-gray-800 underline"
            >
              {{ $t('general.getInTouch') }}
            </router-link>
          </div>
          <div
            class="w-full mt-4"
            v-html="$t('general.fuzzySearch.hint')"
          />
        </apo-pharmacies-fuzzy-search>
      </div>

      <div class="flex flex-col mt-16 text-right">
        <apo-button
          class="button button--primary button--small"
          :disabled="selectedPharmacy === null || isConfirming"
          @click.native="onConfirm"
        >
          <apo-spinner
            v-if="isConfirming"
            class="mr-4"
            size="small"
          />

          <span v-text="'Bestätigen'" />
        </apo-button>
        <small
          v-if="showErrorMessage"
          class="mt-2 text-xs font-bold text-red-500"
          v-text="'Oops, da ist etwas schief gelaufen. Bitte versuche es erneut oder kontatkiere unseren Support.'"
        />
      </div>
    </div>
  </apo-modal>
</template>

<script>
import { mapState } from 'vuex';
import Modal from '@/components/ui/Modal.vue';
import PharmaciesFuzzySearch from '@/components/form-renderer/PharmaciesFuzzySearch.vue';
import ConfirmPharmacyService from '@/services/api/ConfirmPharmacyService';
import LanguageService from '@/services/settings/LanguageService';
import { AUTH_UPDATE_SHOW_UPDATE_PHARMACY_MODAL } from '@/store/types/mutation-types';

export default {
  name: 'PharmacyConfirmationModal',

  components: {
    'apo-modal': Modal,
    'apo-pharmacies-fuzzy-search': PharmaciesFuzzySearch,
  },

  data() {
    return {
      isBusy: false,
      isConfirming: false,
      showErrorMessage: false,
      pharmacy: null,
      selectedPharmacy: null,
    };
  },

  computed: {
    ...mapState({
      firstName: state => state.auth.user.firstName,
    }),
  },

  methods: {
    onSelect(pharmacy) {
      this.selectedPharmacy = {
        pharmacyName: pharmacy.name,
        pharmacyStreet: pharmacy.street,
        pharmacyStreetNo: pharmacy.number,
        pharmacyZipCode: pharmacy.zip,
        pharmacyCity: pharmacy.city,
      };
    },
    removeSelectedPharmacy() {
      this.selectedPharmacy = null;
    },
    onConfirm() {
      this.showErrorMessage = false;
      this.isConfirming = true;
      ConfirmPharmacyService.store({
        name: this.selectedPharmacy.pharmacyName,
        street: this.selectedPharmacy.pharmacyStreet,
        number: this.selectedPharmacy.pharmacyStreetNo,
        zip: this.selectedPharmacy.pharmacyZipCode,
        city: this.selectedPharmacy.pharmacyCity,
        country: LanguageService.resolveCountry(),
      })
        .then(() => {
          this.isConfirming = false;
          this.$store.commit(AUTH_UPDATE_SHOW_UPDATE_PHARMACY_MODAL, false);
        })
        .catch(error => {
          console.error(error);
          this.showErrorMessage = true;
        })
        .finally(() => { this.isConfirming = false; });
    },
  },

  created() {
    this.isBusy = true;
    ConfirmPharmacyService.fetch()
      .then(data => {
        this.pharmacy = { ...data.pharmacy };
      })
      .catch(console.error)
      .finally(() => { this.isBusy = false; });
  },
};

</script>
