<template>
  <div class="reset-password my-12 tablet:my-24 px-8 tablet:px-0 mx-auto max-w-2xl">
    <apo-wait :for="`form.${formId}`">
      <template #waiting>
        <apo-loading-overlay
          class="my-15"
          :message="$t('loaders.form')"
        />
      </template>

      <apo-form-renderer
        v-if="form"
        ref="form"
        v-bind="form"
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
        inner: this.$t('pages.reset.meta.title'),
      },
      meta: [
        descriptionTag(this.$t('pages.reset.meta.description')),
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
      const formConfig = this.getForm('apo_reset_password_form');

      return formConfig && formConfig.id ? formConfig.id : null;
    },
  },

  watch: {
    settingsLoaded: {
      immediate: true,
      handler(settingsLoaded) {
        if (settingsLoaded) {
          this.fetchResetPasswordForm();
        }
      },
    },

    form() {
      this.$nextTick(() => {
        // extract the password reset key from url and set value in the first hidden input field
        this.form.fields
          .find(field => field.type === 'hidden')
          .inputs[0].value = this.getPasswordResetKey();
      });
    },
  },

  methods: {
    getPasswordResetKey() {
      return atob(this.$route.params.key);
    },

    fetchResetPasswordForm() {
      this.$store.dispatch(FORMS_FETCH_FORM, this.formId);
    },
  },
};

</script>
