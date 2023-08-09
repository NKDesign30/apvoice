<template>
  <div class="pharmacy-summary">
    <div class="mb-12">
      <apo-pharmacy-summary-pharmacy
        v-for="(number, index) in associatedPharmacyUniqueNumbers"
        :key="number"
        class="relative"
        :number="number"
      >
        <template
          v-if="index > 0"
          #after
        >
          <button
            class="mr-12 absolute top-0 right-0"
            type="button"
            :title="$t('general.remove')"
            @click="removeAssociatedPharmacyUniqueNumber(number)"
          >
            <apo-icon
              class="w-4"
              src="close"
            />
          </button>
        </template>
      </apo-pharmacy-summary-pharmacy>

      <div class="-mx-12 mt-12 flex justify-center text-positioning">
        <div class="px-12 w-1/2 flex flex-col">
          <span
            class="inline-block font-bold text-gray-900"
            v-text="$t('modules.pharmacySummary.workingInAnotherPharmacy')"
          />
          <span class="mt-2 inline-block">
            <button
              class="underline text-gray-800"
              type="button"
              @click="isPharmacyInputVisible = true"
              v-text="$t('modules.pharmacySummary.buttons.addMore')"
            />
          </span>
        </div>
      </div>
    </div>

    <apo-collapsible-content
      class="add-another-pharmacy"
      :show="isPharmacyInputVisible"
      @expanded="focusInputField"
    >
      <div class="max-w-lg mx-auto py-24">
        <apo-input-label
          for="add-another-pharmacy-unique-number"
          v-text="$t('general.pun')"
        />

        <apo-text-input
          id="add-another-pharmacy-unique-number"
          ref="addAnotherPharmacyUniqueNumber"
          v-model="lookupPharmacyUniqueNumber"
          class="mt-4 w-full"
          @input="isLookupPharmacyUniqueNumberValid = true"
          @keydown.enter="addPharmacyUniqueNumber"
        />

        <small
          v-if="!isLookupPharmacyUniqueNumberValid"
          class="mt-1 absolute pin-l pin-b text-red-500 text-xs font-bold"
          v-text="$t('modules.pharmacySummary.invalidPun')"
        />

        <div class="mt-12 flex justify-center">
          <apo-button
            class="button button--naked button--small shadow-hard text-gray-900"
            @click.native="onCancel"
            v-text="$t('general.cancel')"
          />

          <apo-button
            class="ml-6 button button--primary button--small shadow-hard-dark text-white"
            @click.native="addPharmacyUniqueNumber"
            v-text="$t('modules.pharmacySummary.buttons.lookup')"
          />
        </div>
      </div>
    </apo-collapsible-content>
  </div>
</template>

<script>

import flatten from 'lodash/flatten';
import { mapState } from 'vuex';
import PharmacyService from '@/services/api/PharmacyService';
import InputLabel from '@/components/form-renderer/InputLabel.vue';
import PharmacySummaryPharmacy from '@/components/form-renderer/PharmacySummaryPharmacy.vue';
import TextInput from '@/components/form-renderer/TextInput.vue';

export default {
  components: {
    'apo-input-label': InputLabel,
    'apo-pharmacy-summary-pharmacy': PharmacySummaryPharmacy,
    'apo-text-input': TextInput,
  },

  props: {
    value: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      lookupPharmacyUniqueNumber: '',
      isLookupPharmacyUniqueNumberValid: true,
      isPharmacyInputVisible: false,
      associatedPharmacyUniqueNumbers: [],
    };
  },

  computed: {
    ...mapState({
      pharmacies: state => state.pharmacies.pharmacies,
      user: state => state.auth.user,
    }),

    firstPharmacyUniqueNumber() {
      return this.associatedPharmacyUniqueNumbers[0];
    },
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
};

</script>

<style lang="scss">

.validate-expert_only_pharmacies{
  > div{
    display: flex;
    justify-content: center;
  }

  .text-input-wrapper{
    display: none;
  }
}

</style>

<style lang="scss" scoped>


.text-positioning {
  > div {
    flex-basis: 100%;
  }

  span {
    text-align: center;
  }
}

</style>
