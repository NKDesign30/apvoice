<template>
  <div class="regular-form">
    <div class="mt-20 -mx-12 flex flex-wrap">
      <div
        v-for="field in fields"
        :key="field.id"
        class="px-12"
        :class="{
          [getFieldClasses(field)]: true,
          'hidden': field.type === 'hidden',
        }"
      >
        <template v-if="field.isVisible">
          <div class="mb-8 relative">
            <apo-input-label
              v-if="field.labelPlacement !== 'hidden' && field.label"
              :for="getFieldId(field)"
              class="mb-4"
              v-html="field.label"
            />

            <div
              v-for="input in field.inputs"
              :key="input.id"
            >
              <apo-input-label
                v-if="field.subLabelPlacement !== 'hidden' && (input.label || input.customLabel)"
                :for="getFieldId(input)"
                class="mb-4"
                v-html="input.customLabel || input.label"
              />

              <component
                :is="getFormInputName(field)"
                :id="getFieldId(input)"
                class="mb-4"
                v-bind="input"
                :field="field"
                :value="input.value"
                @input="onFieldInput($event, field, input)"
                @keydown.enter="onEnterKey"
              />
            </div>

            <small
              v-if="validation.has(field.id)"
              class="-mt-3 absolute pin-l pin-b text-red-500 text-xs font-bold"
              v-text="validation.get(field.id)"
            />
          </div>
        </template>
      </div>

      <div class="my-20 w-full flex justify-center">
        <apo-button
          class="regular-form-submit-button button button--primary button--small"
          :class="{ 'is-busy cursor-wait': isBusy }"
          :disabled="isBusy"
          @click.native="submit"
        >
          <apo-spinner
            v-if="isBusy"
            class="mr-4"
            size="small"
          />

          <span v-text="submitButtonText" />
        </apo-button>
      </div>
    </div>
  </div>
</template>

<script>

import Checkbox from '@/components/form-renderer/Checkbox.vue';
import HiddenInput from '@/components/form-renderer/HiddenInput.vue';
import HtmlBlock from '@/components/form-renderer/HtmlBlock.vue';
import InputLabel from '@/components/form-renderer/InputLabel.vue';
import MultiSelectInput from '@/components/form-renderer/MultiSelectInput.vue';
import PharmacySummary from '@/components/form-renderer/PharmacySummary.vue';
import RadioButtons from '@/components/form-renderer/RadioButtons.vue';
import SelectInput from '@/components/form-renderer/SelectInput.vue';
import Textarea from '@/components/form-renderer/Textarea.vue';
import TextInput from '@/components/form-renderer/TextInput.vue';
import FormService from '@/services/api/FormService';
import FormValidation from '@/services/form/FormValidation';

export default {
  components: {
    'apo-checkbox': Checkbox,
    'apo-hidden-input': HiddenInput,
    'apo-html-block': HtmlBlock,
    'apo-input-label': InputLabel,
    'apo-multi-select-input': MultiSelectInput,
    'apo-pharmacy-summary': PharmacySummary,
    'apo-radio-buttons': RadioButtons,
    'apo-select-input': SelectInput,
    'apo-textarea': Textarea,
    'apo-text-input': TextInput,
  },

  props: {
    fields: {
      type: Array,
      required: true,
    },

    submissionUrl: {
      type: String,
      required: true,
    },

    submitButtonText: {
      type: String,
      default: 'Submit',
    },
  },

  data() {
    return {
      validation: new FormValidation(),
      isBusy: false,
    };
  },

  methods: {
    getFieldId({ id }) {
      return `form-field-${id.replace(/\./g, '-')}`;
    },

    getFormInputName(field) {
      return FormService.getFormComponent(field);
    },

    getFieldClasses(field) {
      let classes = 'w-full';

      // "Interpret" the fields custom classes
      // see: https://www.gravityforms.com/css-ready-classes/
      if (field.cssClass.match(/gf_.+_half/)) {
        classes = 'w-1/2';
      } else if (field.cssClass.match(/gf_.+_third/)) {
        classes = 'w-1/3';
      }

      return classes;
    },

    onFieldInput(event, field, input) {
      // eslint-disable-next-line no-param-reassign
      input.value = event;
      this.validation.reset(input.id);
    },

    onEnterKey(event) {
      const submittableFields = ['input'];
      const fieldType = event.target.tagName.toLowerCase();

      if (submittableFields.indexOf(fieldType) !== -1) {
        this.submit();
      }
    },

    submit() {
      const pagePayload = {};

      this.isBusy = true;

      this.fields.forEach(field => {
        field.inputs.forEach(input => {
          if ((field.isDisplayOnly && field.type !== 'password') || (field.type === 'checkbox' && input.value === '')) {
            return;
          }

          pagePayload[`input_${input.id.replace(/\./g, '_')}`] = input.value;
        });
      });

      FormService.submit(this.submissionUrl, pagePayload)
        .then(({
          isValid,
          confirmationType,
          confirmationMessage,
          confirmationRedirect,
        }) => {
          if (isValid) {
            this.$emit('submitted', { confirmationType, confirmationMessage, confirmationRedirect });
          }
        })
        .catch(error => {
          if (error.validationMessages) {
            this.validation.fill(error);
          } else {
            console.log('unexpected error', error);
          }
        })
        .finally(() => {
          this.isBusy = false;
        });
    },
  },
};

</script>

<style lang="scss" scoped>

.regular-form {
  &-submit-button {
    @apply shadow-hard-dark;
    @apply text-white;

    &.is-busy {
      @apply pl-6 #{!important};
    }
  }
}

</style>
