<template>
  <div class="registration">
    <apo-wait :for="`form.${formId}`">
      <template #waiting>
        <apo-loading-overlay
          class="my-15"
          :message="$t('loaders.form')"
        />
      </template>

      <apo-form-renderer
        v-if="form"
        v-bind="form"
        class="container"
      />
    </apo-wait>
  </div>
</template>

<script>

import { mapGetters, mapState, mapMutations } from 'vuex';
import { SALES_REP_RESET_SALES_REP_NAME } from '@/store/types/mutation-types';
import FormRenderer from '@/components/form-renderer/FormRenderer.vue';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import { canonicalTag, descriptionTag } from '@/services/utils';
import { FORMS_FETCH_FORM } from '@/store/types/action-types';

export default {
  components: {
    'apo-form-renderer': FormRenderer,
    'apo-loading-overlay': LoadingOverlay,
  },

  head() {
    return {
      title: {
        inner: this.$t('pages.registration.meta.title'),
      },
      meta: [
        descriptionTag(this.$t('pages.registration.meta.description')),
      ],
      link: [
        canonicalTag(this.$route),
      ],
    };
  },

  computed: {
    ...mapGetters(['isAuthenticated', 'getForm', 'settingsLoaded']),
    ...mapState({
      form(state) {
        return state.forms.forms.find(form => form.id === this.formId);
      },
    }),

    formId() {
      const formConfig = this.getForm('apo_register_form');

      return formConfig && formConfig.id ? formConfig.id : null;
    },
  },

  watch: {
    settingsLoaded: {
      immediate: true,
      handler(settingsLoaded) {
        if (settingsLoaded) {
          this.fetchRegistrationForm();
        }
      },
    },
  },

  methods: {
    ...mapMutations([SALES_REP_RESET_SALES_REP_NAME]),

    redirectIfAuthenticated() {
      if (this.isAuthenticated) {
        this.$router.replace('/');
      }
    },

    fetchRegistrationForm() {
      this.$store.dispatch(FORMS_FETCH_FORM, this.formId);
    },
  },

  created() {
    this.redirectIfAuthenticated();
  },

  destroyed() {
    this[SALES_REP_RESET_SALES_REP_NAME]();
  },
};

</script>
