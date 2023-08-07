<template>
  <div class="detailers-job">
    <div class="flex flex-col items-center py-24 detailers-job-splashscreen">
      <apo-profile-picture
        class="w-32 h-32"
        :user="user"
      />

      <h2
        class="mt-10 mb-12 text-3xl font-bold text-center text-white tablet:text-6xl font-display"
        v-text="fullName"
      />
    </div>

    <div class="py-24">
      <apo-wait for="pharmacies">
        <template #waiting>
          <apo-loading-overlay
            class="my-15"
            :message="$t('loaders.pharmacies')"
          />
        </template>

        <div class="container flex flex-col items-center">
          <h4 v-text="$t('detailersJob.selectPharmacy.headline')" />
          <h5
            class="mt-2"
            v-text="$t('detailersJob.selectPharmacy.subheadline')"
          />

          <div
            v-if="pharmacy !== null"
            class="w-full mt-6"
          >
            <apo-pharmacy-summary-pharmacy :number="pharmacy.pharmacyUniqueNumber" />

            <div class="tablet:flex tablet:justify-end">
              <div class="w-full mt-8 text-center tablet:mt-4 tablet:px-12 tablet:w-1/2 tablet:text-left">
                <button
                  class="text-gray-800 underline"
                  type="button"
                  @click="pharmacy = null"
                  v-text="$t('detailersJob.buttons.changePharmacy')"
                />
              </div>
            </div>

            <div class="mt-12">
              <apo-informational-training-teaser
                v-for="informationalTraining in informationalTrainings"
                :key="informationalTraining.id"
                class="mb-4"
                :informational-training="informationalTraining"
                :pharmacy="pharmacy"
              />
            </div>
          </div>
          <div
            v-else
            class="relative mt-6"
          >
            <apo-input-label
              class="detailers-job-label"
              v-text="$t('detailersJob.pharmacyName')"
            />

            <apo-select
              v-model="pharmacy"
              class="mt-2 w-72"
              label="name"
              :options="pharmacies"
            >
              <template #no-options>
                <span v-text="$t('detailersJob.noResults')" />
              </template>
            </apo-select>
          </div>
        </div>
      </apo-wait>
    </div>
  </div>
</template>

<script>

import { mapGetters, mapState } from 'vuex';
import InputLabel from '@/components/form-renderer/InputLabel.vue';
import PharmacySummaryPharmacy from '@/components/form-renderer/PharmacySummaryPharmacy.vue';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import InformationalTrainingTeaser from '@/components/detailers-job/InformationalTrainingTeaser.vue';
import { canonicalTag } from '@/services/utils';
import PharmacyService from '../../services/api/PharmacyService';

export default {
  components: {
    'apo-informational-training-teaser': InformationalTrainingTeaser,
    'apo-input-label': InputLabel,
    'apo-loading-overlay': LoadingOverlay,
    'apo-pharmacy-summary-pharmacy': PharmacySummaryPharmacy,
  },

  data: () => ({
    pharmacy: null,
    pharmacies: '',
  }),

  head() {
    return {
      title: {
        inner: this.$t('pages.detailersJob.main.meta.title'),
      },
      link: [
        canonicalTag(this.$route),
      ],
    };
  },

  computed: {
    ...mapGetters(['fullName']),
    ...mapState({
      user: state => state.auth.user,
      informationalTrainings: state => state.detailersJob.informationalTrainings,
    }),
  },

  created() {
    this.pharmacies = PharmacyService.fetchAll();
  },
};

</script>

<style lang="scss" scoped>

.detailers-job {
  &-splashscreen {
    background: linear-gradient(45deg, theme('colors.blue.700'), theme('colors.blue.500'));
  }

  &-label {
    @apply text-base;
  }

  /deep/ &-pharmacy-input {
    @apply px-6;
    @apply py-3;
    @apply text-gray-900;

    &:hover,
    &:focus {
      background-color: hsla(0, 0%, 100%, 0.08);
      border-color: theme('colors.white');
    }

    &-wrapper {
      @apply border-4;
      @apply border-gray-500;
    }
  }
}

/deep/ .vs {
  &__dropdown-toggle {
    @apply px-5;
    @apply py-2;
    @apply rounded-xl;
    @apply outline-none;
    @apply border-2;
    @apply border-gray-600;
    @apply shadow-inner-light;

    transition: all 0.3s ease;
  }

  &--open &__dropdown-toggle {
    @apply rounded-bl-xl;
    @apply rounded-br-xl;
  }

  &__dropdown-option {
    @apply py-2;
    @apply text-gray-900;

    transition: all 0.1s ease;

    &--highlight {
      @apply bg-blue-600;
      @apply text-white;
    }
  }

  &__dropdown-menu {
    @apply -mt-1;
    @apply shadow-lg;
    @apply border-0;
    @apply rounded-lg;
    @apply overflow-y-hidden;
    @apply overflow-x-auto;
  }

  &__search {
    @apply text-gray-900;
  }
}

</style>
