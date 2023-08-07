<template>
  <div
    :id="`form-${id}`"
    v-wow.fadeInUp
    class="form-renderer mt-20"
  >
    <h2
      v-if="!hideTitle && title"
      class="font-display text-center text-gray-800"
      v-html="$options.filters.formatContent(title)"
    />

    <div
      v-if="isSubmitted && confirmationMessage"
      class="my-24 flex w-full justify-center"
      v-html="$options.filters.formatContent(confirmationMessage)"
    />
    <template v-else>
      <div
        v-if="description"
        class="mt-10 font-display text-center text-2xl text-gray-800"
        v-html="$options.filters.formatContent(description)"
      />

      <apo-multipage-form
        v-if="isMultiPageForm"
        v-bind="meta"
        :pages="fields"
        @submitted="onSubmitted"
      />
      <apo-regular-form
        v-else
        v-bind="meta"
        :fields="fields"
        :submit-button-text="submitButtonText"
        @submitted="onSubmitted"
      />
    </template>
  </div>
</template>

<script>

import MultipageForm from '@/components/form-renderer/MultipageForm.vue';
import RegularForm from '@/components/form-renderer/RegularForm.vue';

export default {
  components: {
    'apo-multipage-form': MultipageForm,
    'apo-regular-form': RegularForm,
  },

  props: {
    id: {
      type: [String, Number],
      required: true,
    },

    title: {
      type: String,
      default: '',
    },

    description: {
      type: String,
      default: '',
    },

    meta: {
      type: Object,
      default() {
        return {};
      },
    },

    submitButtonText: {
      type: String,
      default: 'Submit',
    },

    isMultiPageForm: {
      type: Boolean,
      default: false,
    },

    isActive: {
      type: Boolean,
      default: true,
    },

    fields: {
      type: Array,
      required: true,
    },

    hideTitle: {
      type: Boolean,
      default: false,
    },

    withoutConfirmation: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      isSubmitted: false,
      confirmationMessage: '',
    };
  },

  methods: {
    onSubmitted({ confirmationType, confirmationMessage, confirmationRedirect }) {
      if (confirmationType === 'redirect') {
        this.$router.push(confirmationRedirect);

        return;
      }

      this.isSubmitted = true;

      if (!this.withoutConfirmation) {
        this.confirmationMessage = confirmationMessage;
      }

      this.$emit('submitted');
    },
  },

  mounted() {
    console.log('fields', this.fields)
  }
};

</script>
