<template>
  <div class="contact">
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

import { mapGetters, mapState } from 'vuex';
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
        inner: this.$t('pages.contact.meta.title'),
      },
      meta: [
        descriptionTag(this.$t('pages.contact.meta.description')),
      ],
      link: [
        canonicalTag(this.$route),
      ],
    };
  },

  computed: {
    ...mapGetters(['getForm', 'settingsLoaded']),
    ...mapState({
      form(state) {
        return state.forms.forms.find(form => form.id === this.formId);
      },
    }),

    formId() {
      const formConfig = this.getForm('apo_contact_form');

      return formConfig && formConfig.id ? formConfig.id : null;
    },
  },

  watch: {
    settingsLoaded: {
      immediate: true,
      handler(settingsLoaded) {
        if (settingsLoaded) {
          this.fetchForgottenPasswordForm();
        }
      },
    },
  },

  methods: {
    fetchForgottenPasswordForm() {
      this.$store.dispatch(FORMS_FETCH_FORM, this.formId);
    },
  },
};

</script>
