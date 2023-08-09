<template>
  <div class="mb-24 pharmacy-summary">
    <div class="mb-12">
      <div
        v-if="expertCode && salesRepName !== undefined"
        class="flex flex-col justify-start mb-8 tablet:justify-center tablet:flex-row tablet:text-center"
      >
        <div class="flex flex-col w-full mb-12 tablet:px-4 tablet:w-1/2 tablet:mb-0">
          <span
            class="inline-block font-bold text-gray-900"
            v-html="$t('general.expertCode')"
          />
          <span class="inline-block mt-2 text-gray-800">
            {{ expertCode | formattedNumber }}
          </span>
        </div>
        <div
          v-if="salesRepName !== ' '"
          class="flex flex-col w-full tablet:px-4 tablet:w-1/2"
        >
          <span
            class="inline-block font-bold text-gray-900"
            v-text="$t('modules.pharmacySummary.associatedSalesRep')"
          />
          <span
            class="inline-block mt-2 text-gray-800"
            v-html="$options.filters.formatContent(salesRepName)"
          />
        </div>
      </div>

      <div v-if="isExpertOnly">
        <div v-if="expertOnlyPharmacies.length === 0">
          <apo-pharmacies-fuzzy-search @selected="addPharmacy">
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
        <div v-else>
          <apo-pharmacy-summary-expert-only-pharmacy
            v-for="(pharmacy, index) in expertOnlyPharmacies"
            :key="'pharmacy' + index"
            class="relative"
            :data="pharmacy"
          >
            <template #after>
              <button
                class="p-2 close"
                type="button"
                :title="$t('general.remove')"
                @click="removePharmacy(index)"
              >
                <apo-icon
                  class="w-4 tablet:w-6"
                  src="close"
                />
              </button>
            </template>
          </apo-pharmacy-summary-expert-only-pharmacy>
        </div>
      </div>
      <div v-else>
        <apo-pharmacy-summary-pharmacy
          :number="pharmacyUniqueNumber"
          :uid="0"
        />

        <apo-pharmacy-summary-pharmacy
          v-for="(number, index) in associatedPharmacyUniqueNumbers"
          :key="number"
          class="relative"
          :number="number"
          :uid="index + 1"
        >
          <template #after>
            <button
              class="p-2 close"
              type="button"
              :title="$t('general.remove')"
              @click="removeAssociatedPharmacyUniqueNumber(number)"
            >
              <apo-icon
                class="w-4 tablet:w-6"
                src="close"
              />
            </button>
          </template>
        </apo-pharmacy-summary-pharmacy>
      </div>

      <div v-if="!isExpertOnly">
        <div class="flex mt-12 tablet:justify-start">
          <div class="flex flex-col w-full tablet:px-4 tablet:w-1/2">
            <span
              class="inline-block font-bold text-gray-900"
              v-text="$t('modules.pharmacySummary.workingInAnotherPharmacy')"
            />
            <span class="inline-block mt-2">
              <button
                class="text-gray-800 underline"
                type="button"
                @click="isPharmacyInputVisible = true"
                v-text="$t('modules.pharmacySummary.buttons.addMore')"
              />
            </span>
          </div>
        </div>
      </div>
    </div>

    <div v-if="isExpertOnly && expertOnlyPharmacies.length > 0">
      <!-- <div class="flex mt-12 tablet:justify-start">
        <div class="flex flex-col w-full tablet:px-4 tablet:w-1/2">
          <span
            class="inline-block font-bold text-gray-900"
            v-text="$t('modules.pharmacySummary.workingInAnotherPharmacy')"
          />
          <router-link
            :to="{name: 'contact'}"
            class="inline-block mt-2 text-gray-800 underline"
          >
            Kontaktiere uns
          </router-link>
        </div>
      </div> -->
    </div>

    <apo-collapsible-content
      v-else
      class="add-another-pharmacy"
      :show="isPharmacyInputVisible"
      @expanded="focusInputField"
    >
      <div
        v-if="!isExpertOnly"
        class="max-w-lg py-24 mx-auto"
      >
        <apo-input-label
          for="add-another-pharmacy-unique-number"
          v-text="$t('general.pun')"
        />

        <apo-text-input
          id="add-another-pharmacy-unique-number"
          ref="addAnotherPharmacyUniqueNumber"
          v-model="lookupPharmacyUniqueNumber"
          class="w-full mt-4"
          @input="isLookupPharmacyUniqueNumberValid = true"
          @keydown.enter="addPharmacyUniqueNumber"
        />

        <small
          v-if="!isLookupPharmacyUniqueNumberValid"
          class="absolute mt-1 text-xs font-bold text-red-500 pin-l pin-b"
          v-text="$t('modules.pharmacySummary.invalidPun')"
        />

        <div class="flex justify-center mt-12">
          <apo-button
            class="text-gray-900 button button--naked button--small shadow-hard"
            @click.native="onCancel"
            v-text="$t('general.cancel')"
          />

          <apo-button
            class="ml-6 text-white button button--primary button--small shadow-hard-dark"
            @click.native="addPharmacyUniqueNumber"
            v-text="$t('modules.pharmacySummary.buttons.lookup')"
          />
        </div>
      </div>
    </apo-collapsible-content>
  </div>
</template>

<script>

import find from 'lodash/find';
import flatten from 'lodash/flatten';
import get from 'lodash/get';
import { mapGetters } from 'vuex';
import InputLabel from '@/components/form-renderer/InputLabel.vue';
import PharmacySummaryPharmacy from '@/components/form-renderer/PharmacySummaryPharmacy.vue';
import PharmacySummaryExpertOnlyPharmacy from '@/components/form-renderer/PharmacySummaryExpertOnlyPharmacy.vue';
import TextInput from '@/components/form-renderer/TextInput.vue';
import PharmacyService from '../../services/api/PharmacyService';
import PharmaciesFuzzySearch from '@/components/form-renderer/PharmaciesFuzzySearch.vue';
import LanguageService from '@/services/settings/LanguageService';

export default {
  components: {
    'apo-input-label': InputLabel,
    'apo-pharmacy-summary-pharmacy': PharmacySummaryPharmacy,
    'apo-pharmacy-summary-expert-only-pharmacy': PharmacySummaryExpertOnlyPharmacy,
    'apo-text-input': TextInput,
    'apo-pharmacies-fuzzy-search': PharmaciesFuzzySearch,
  },

  props: {
    value: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      expertCode: '',
      pharmacyUniqueNumber: '',
      lookupPharmacyUniqueNumber: '',
      isLookupPharmacyUniqueNumberValid: true,
      isPharmacyInputVisible: false,
      associatedPharmacyUniqueNumbers: [],
      isExpertOnly: false,
      expertOnlyPharmacies: [],
      pharmacyForm: [
        {
          type: 'textInput',
          id: 'pharmacy-name',
          ref: 'pharmacyName',
          model: '',
        },
        {
          type: 'selectInput',
          id: 'pharmacy-country',
          ref: 'pharmacyCountry',
          model: 'germany',
          options: [
            {
              value: 'germany',
              text: this.$t('modules.pharmacySummary.form.germany'),
            },
            {
              value: 'denmark',
              text: this.$t('modules.pharmacySummary.form.denmark'),
            },
            {
              value: 'poland',
              text: this.$t('modules.pharmacySummary.form.poland'),
            },
            {
              value: 'czechRepublic',
              text: this.$t('modules.pharmacySummary.form.czechRepublic'),
            },
            {
              value: 'austria',
              text: this.$t('modules.pharmacySummary.form.austria'),
            },
            {
              value: 'switzerland',
              text: this.$t('modules.pharmacySummary.form.switzerland'),
            },
            {
              value: 'france',
              text: this.$t('modules.pharmacySummary.form.france'),
            },
            {
              value: 'luxembourg',
              text: this.$t('modules.pharmacySummary.form.luxembourg'),
            },
            {
              value: 'belgium',
              text: this.$t('modules.pharmacySummary.form.belgium'),
            },
            {
              value: 'netherlands',
              text: this.$t('modules.pharmacySummary.form.netherlands'),
            },
          ],
        },
        {
          type: 'textInput',
          id: 'pharmacy-street',
          ref: 'pharmacyStreet',
          model: '',
        },
        {
          type: 'textInput',
          id: 'pharmacy-street-no',
          ref: 'pharmacyStreetNo',
          model: '',
        },
        {
          type: 'textInput',
          id: 'pharmacy-zip-code',
          ref: 'pharmacyZipCode',
          model: '',
        },
        {
          type: 'textInput',
          id: 'pharmacy-city',
          ref: 'pharmacyCity',
          model: '',
        },
      ],
    };
  },

  computed: {
    ...mapGetters(['salesRepName']),
  },

  watch: {
    value: {
      immediate: true,
      handler(value) {
        this.associatedPharmacyUniqueNumbers = this.parsePharmacyUniqueNumbersValueString(value);
      },
    },
  },

  methods: {
    focusInputField() {
      try {
        this.$refs.addAnotherPharmacyUniqueNumber.$el.querySelector('input').focus();
      } catch (e) {
        // left blank intentionally
      }
    },

    getAllFields() {
      return flatten(this.$parent.pages.map(page => page.fields));
    },

    findEnteredExpertCode() {
      const uniquePharmacyNumberField = find(
        this.getAllFields(),
        field => field.cssClass.match(/validate-expert-code/),
      );

      return get(uniquePharmacyNumberField, 'inputs.0.value', '');
    },

    findEnteredPharmacyUniqueNumber() {
      const uniquePharmacyNumberField = find(
        this.getAllFields(),
        field => field.cssClass.match(/validate-pharmacy-unique-number/),
      );

      return get(uniquePharmacyNumberField, 'inputs.0.value', '');
    },

    findEnteredPgCustomerId() {
      const uniqueCustomerIdField = find(
        this.getAllFields(),
        field => field.cssClass.match(/validate-pg_customer_id/),
      );

      return get(uniqueCustomerIdField, 'inputs.0.value', '');
    },

    findExpertOnlyPharmacies() {
      const uniqueCustomerIdField = find(
        this.getAllFields(),
        field => field.cssClass.match(/validate-expert_only_pharmacies/),
      );

      return uniqueCustomerIdField;
    },

    addPharmacy(pharmacy) {
      this.pharmacyForm[0].model = pharmacy.name;
      this.pharmacyForm[1].model = LanguageService.resolveCountry();
      this.pharmacyForm[2].model = pharmacy.street;
      this.pharmacyForm[3].model = pharmacy.number;
      this.pharmacyForm[4].model = pharmacy.zip;
      this.pharmacyForm[5].model = pharmacy.city;
      this.expertOnlyPharmacies.push(this.pharmacyForm.map(field => ({ title: field.ref, value: field.model })));

      const field = this.findExpertOnlyPharmacies();

      field.inputs[0].value = JSON.stringify(this.expertOnlyPharmacies);
    },

    removePharmacy(index) {
      this.expertOnlyPharmacies = this.expertOnlyPharmacies.filter((expertOnlyPharmacy, i) => i !== index);

      const field = this.findExpertOnlyPharmacies();
      field.inputs[0].value = JSON.stringify(this.expertOnlyPharmacies);
    },

    addPharmacyUniqueNumber() {
      this.isLookupPharmacyUniqueNumberValid = PharmacyService.fetchById(this.lookupPharmacyUniqueNumber);

      if (this.lookupPharmacyUniqueNumber === this.pharmacyUniqueNumber) {
        this.isLookupPharmacyUniqueNumberValid = false;
      }

      const isPharmacyUniqueNumberUnique = this.associatedPharmacyUniqueNumbers
        .every(number => number !== this.lookupPharmacyUniqueNumber);

      if (!isPharmacyUniqueNumberUnique) {
        this.isLookupPharmacyUniqueNumberValid = false;
      }

      if (this.isLookupPharmacyUniqueNumberValid) {
        const updatedPharmacyUniqueNumbers = this.associatedPharmacyUniqueNumbers
          .concat([this.lookupPharmacyUniqueNumber]);

        this.$emit('input', this.buildPharmacyUniqueNumbersValueString(updatedPharmacyUniqueNumbers));

        this.lookupPharmacyUniqueNumber = '';
        this.isPharmacyInputVisible = false;
      }
    },

    removeAssociatedPharmacyUniqueNumber(pharmacyUniqueNumber) {
      const updatedPharmacyUniqueNumbers = this.associatedPharmacyUniqueNumbers.filter(
        number => number !== pharmacyUniqueNumber,
      );

      this.$emit('input', this.buildPharmacyUniqueNumbersValueString(updatedPharmacyUniqueNumbers));
    },

    buildPharmacyUniqueNumbersValueString(pharmacyUniqueNumbers) {
      return pharmacyUniqueNumbers.join(',');
    },

    parsePharmacyUniqueNumbersValueString(pharmacyUniqueNumbersStrings) {
      return pharmacyUniqueNumbersStrings.split(',').filter(val => val !== '');
    },

    onCancel() {
      this.isPharmacyInputVisible = false;
      this.isLookupPharmacyUniqueNumberValid = true;
    },
  },

  created() {
    this.expertCode = this.findEnteredExpertCode();
    this.pharmacyUniqueNumber = this.expertCode && this.findEnteredPharmacyUniqueNumber() ? this.findEnteredPharmacyUniqueNumber() : this.findEnteredPgCustomerId();
    this.isExpertOnly = !((!this.expertCode && this.findEnteredPgCustomerId()) || (this.expertCode && this.findEnteredPharmacyUniqueNumber() !== '') || this.salesRepName === undefined);
  },
};

</script>

<style lang="scss" scoped>
  .close {
    position: absolute;
    top: 0;
    right: 0;

    @media (min-width: theme('screens.tablet')) {
      top: 50%;
      transform: translateY(-50%);
    }
  }
</style>
