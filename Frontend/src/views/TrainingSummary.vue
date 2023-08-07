<template>
  <div class="training-summary">
    <div class="flex flex-col items-center pb-24 training-summary__head">
      <apo-page-header :page_header="pageHeader" />
    </div>
    <div class="container py-24 mx-auto training-summary__body">
      <apo-wysiwyg-content
        class="training-summary__copy"
        :content="copy"
      />
      <div class="my-16 text-center training-summary__actions">
        <router-link
          class="text-white shadow-hard-dark button-class"
          tag="apo-button"
          :to="{ name: origin }"
          v-text="$t('goBackButton')"
        />
      </div>
      <div class="training-summary__references">
        <small
          v-html="references"
        />
      </div>
    </div>
  </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';
import { TRAININGS_UPDATE_CURRENT_TRAINING_SERIES } from '@/store/types/action-types';
import PageHeader from '@/components/content/PageHeader.vue';
import { canonicalTag } from '@/services/utils';

export default {
  components: {
    'apo-page-header': PageHeader,
  },

  head() {
    return {
      title: {
        inner: this.$t('pages.trainings.success.meta.title'),
      },
      link: [
        canonicalTag(this.$route),
      ],
    };
  },

  props: {
    origin: {
      type: String,
      required: true,
      validator: function (value) {
        return ['scientific', 'trainings'].includes(value)
      }
    }
  },

  computed: {
    ...mapGetters(['currentTrainingSeries']),
    pageHeader() {
      return this.currentTrainingSeries.summaryPage.page_header;
    },
    copy() {
      return this.currentTrainingSeries.summaryPage.copy;
    },
    references() {
      return this.currentTrainingSeries.summaryPage.references;
    }
  },
  watch: {
    $route: {
      immediate: true,
      handler(route) {
        if (route.params.id) {
          this[TRAININGS_UPDATE_CURRENT_TRAINING_SERIES](route.params);
        }
      },
    },
  },

  methods: {
    ...mapActions([
      TRAININGS_UPDATE_CURRENT_TRAINING_SERIES,
    ]),
  },

};

</script>

<style lang="scss" scoped>
 .theme-training {
   .training-summary__head {
     background: linear-gradient(60deg, theme('colors.training.500'), theme('colors.training.400'));
   }
   .button-class {
     @apply bg-training-500;
   }
 }
 .theme-scientific {
   .training-summary__head {
     background: linear-gradient(60deg, theme('colors.scientific.500'), theme('colors.scientific.300'));
   }
   .button-class {
     @apply bg-scientific-500;
   }
 }
</style>
