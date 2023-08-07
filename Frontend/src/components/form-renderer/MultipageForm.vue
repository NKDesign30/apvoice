<template>
  <div class="multipage-form">
    <transition
      name="fade"
      mode="out-in"
    >
      <div
        :key="getPageId(currentPage)"
        class="mt-20 flex flex-wrap flex-col tablet:flex-row tablet:items-end"
      >
        <div
          v-for="field in currentPage.fields"
          :key="field.id"
          class="px-4"
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
                v-for="(input, index) in field.inputs"
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
                  @input="onFieldInput($event, field, input, index)"
                  @keyup.enter="onEnterKey(field)"
                />
                <div
                  v-if="index === 0 && field.passwordDetails"
                >
                  <div class="passwordMask mb-3">
                    <div
                      class="passwordLengthMask flex text-gray-700"
                      v-text="$t('pages.registration.passwordMask.length')"
                    />
                    <div
                      class="passwordNumberMask flex text-gray-700"
                      v-text="$t('pages.registration.passwordMask.number')"
                    />
                    <div
                      class="passwordUpperMask flex text-gray-700"
                      v-text="$t('pages.registration.passwordMask.uppercase')"
                    />
                    <div
                      class="passwordLowerMask flex text-gray-700"
                      v-text="$t('pages.registration.passwordMask.lowercase')"
                    />
                  </div>
                </div>
              </div>

              <small
                v-if="validation.has(field.id)"
                class="-mt-3 absolute pin-l pin-b text-red-500 text-xs font-bold"
                v-text="validation.get(field.id)"
              />
            </div>
          </template>
        </div>

        <div class="my-20 w-full flex flex-col-reverse tablet:flex-row justify-center">
          <apo-button
            v-if="currentPage.previousButton"
            class="w-full tablet:w-auto mr-6 button button--naked button--small shadow-hard text-gray-900"
            @click.native="onPreviousButtonClick"
            v-text="currentPage.previousButton.text"
          />

          <apo-button
            v-if="currentPage.nextButton"
            class="w-full tablet:w-auto button button--primary button--small shadow-hard-dark text-white mb-6 tablet:mb-0"
            :class="{ 'is-busy cursor-wait': isBusy }"
            :disabled="isBusy"
            @click.native="onNextButtonClick"
          >
            <apo-spinner
              v-if="isBusy"
              class="mr-4"
              size="small"
            />

            <span v-text="currentPage.nextButton.text" />
          </apo-button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>

import { mapActions } from 'vuex';
import find from 'lodash/find';
import flatten from 'lodash/flatten';
import map from 'lodash/map';
import get from 'lodash/get';
import {
  SALES_REP_FETCH_BY_EXPERT_CODE,
} from '@/store/types/action-types';
import Checkbox from '@/components/form-renderer/Checkbox.vue';
import HiddenInput from '@/components/form-renderer/HiddenInput.vue';
import HtmlBlock from '@/components/form-renderer/HtmlBlock.vue';
import InputLabel from '@/components/form-renderer/InputLabel.vue';
import MultiSelectInput from '@/components/form-renderer/MultiSelectInput.vue';
import PharmacySummary from '@/components/form-renderer/PharmacySummary.vue';
import RadioButtons from '@/components/form-renderer/RadioButtons.vue';
import RegistrationInformation from '@/components/form-renderer/RegistrationInformation.vue';
import SelectInput from '@/components/form-renderer/SelectInput.vue';
import Textarea from '@/components/form-renderer/Textarea.vue';
import TextInput from '@/components/form-renderer/TextInput.vue';
import Captcha from '@/components/form-renderer/Captcha.vue';
import FormService from '@/services/api/FormService';
import FormValidation from '@/services/form/FormValidation';
import PharmaciesFuzzySearch from '@/components/form-renderer/PharmaciesFuzzySearch.vue';

export default {
  components: {
    'apo-checkbox': Checkbox,
    'apo-hidden-input': HiddenInput,
    'apo-html-block': HtmlBlock,
    'apo-input-label': InputLabel,
    'apo-multi-select-input': MultiSelectInput,
    'apo-pharmacy-summary': PharmacySummary,
    'apo-radio-buttons': RadioButtons,
    'apo-registration-information': RegistrationInformation,
    'apo-select-input': SelectInput,
    'apo-textarea': Textarea,
    'apo-text-input': TextInput,
    'apo-captcha': Captcha,
    'apo-pharmacies-fuzzy-search': PharmaciesFuzzySearch,
  },

  props: {
    pages: {
      type: Array,
      required: true,
    },

    submissionUrl: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      currentPageNumber: '1',
      validation: new FormValidation(),
      isBusy: false,
    };
  },

  computed: {
    currentPage() {
      return find(
        this.pages, page => parseInt(page.pageNumber, 10) === parseInt(this.currentPageNumber, 10),
      );
    },

    totalPages() {
      return this.pages.length;
    },
  },

  methods: {
    ...mapActions([SALES_REP_FETCH_BY_EXPERT_CODE]),

    checkPasswordMask(event) {
      // Test for length
      if (event.match(/^[a-zA-Z\d\W_][^\s]{8,}$/)) {
        document.querySelector('.passwordLengthMask').classList.remove('failure');
        document.querySelector('.passwordLengthMask').classList.add('success');
      } else {
        document.querySelector('.passwordLengthMask').classList.remove('success');
        document.querySelector('.passwordLengthMask').classList.add('failure');
      }

      // test for number
      if (event.match(/^(?=.*\d)/)) {
        document.querySelector('.passwordNumberMask').classList.remove('failure');
        document.querySelector('.passwordNumberMask').classList.add('success');
      } else {
        document.querySelector('.passwordNumberMask').classList.remove('success');
        document.querySelector('.passwordNumberMask').classList.add('failure');
      }

      // test for uppercase
      if (event.match(/^(?=.*[A-Z])/)) {
        document.querySelector('.passwordUpperMask').classList.remove('failure');
        document.querySelector('.passwordUpperMask').classList.add('success');
      } else {
        document.querySelector('.passwordUpperMask').classList.remove('success');
        document.querySelector('.passwordUpperMask').classList.add('failure');
      }

      // test for lowercase
      if (event.match(/^(?=.*[a-z])/)) {
        document.querySelector('.passwordLowerMask').classList.remove('failure');
        document.querySelector('.passwordLowerMask').classList.add('success');
      } else {
        document.querySelector('.passwordLowerMask').classList.remove('success');
        document.querySelector('.passwordLowerMask').classList.add('failure');
      }
    },

    getPageId({ pageNumber }) {
      return `page-${pageNumber}`;
    },

    getFieldId({ id }) {
      return `form-field-${id.replace(/\./g, '-')}`;
    },

    isCurrentPage({ pageNumber }) {
      return parseInt(pageNumber, 10) === parseInt(this.currentPageNumber, 10);
    },

    getFormInputName(field) {
      return FormService.getFormComponent(field);
    },

    getFieldClasses(field) {
      let classes = 'w-full';

      // "Interpret" the fields custom classes
      // see: https://www.gravityforms.com/css-ready-classes/
      if (field.cssClass.match(/gf_.+_half/)) {
        classes = 'tablet:w-1/2';
      } else if (field.cssClass.match(/gf_.+_third/)) {
        classes = 'tablet:w-1/3';
      }

      // eslint-disable-next-line prefer-template
      return classes + ' ' + field.cssClass;
    },

    getPageFields(pageNumber) {
      return flatten(map(this.pages.filter(page => parseInt(page.pageNumber, 10) <= parseInt(pageNumber, 10)), 'fields'));
    },

    onFieldInput(event, field, input, index) {
      if (index === 0 && field.passwordDetails) this.checkPasswordMask(event, field, input);
      // eslint-disable-next-line no-param-reassign
      input.value = event;
      this.validation.reset(input.id);
    },

    onPreviousButtonClick() {
      this.currentPageNumber = String(parseInt(this.currentPageNumber, 10) - 1);
    },

    onEnterKey(field) {
      if (this.getFormInputName(field) === 'apo-text-input') {
        this.onNextButtonClick();
      }
    },

    onNextButtonClick() {
      this.isBusy = true;

      const currentPageNumber = parseInt(this.currentPageNumber, 10);
      const pagePayload = {
        source_page: currentPageNumber,
        target_page: currentPageNumber < this.totalPages ? currentPageNumber + 1 : 0,
      };

      this.getPageFields(currentPageNumber).forEach(field => {
        field.inputs.forEach(input => {
          if (field.type === 'captcha') {
            pagePayload['g-recaptcha-response'] = document.querySelector('.g-recaptcha-response').value;
            return;
          }

          if ((field.isDisplayOnly && field.type !== 'password') || (field.type === 'checkbox' && input.value === '')) {
            return;
          }

          pagePayload[`input_${input.id.replace(/\./g, '_')}`] = input.value;
        });
      });

      this.preloadSalesRepByExpertCodeIfNecessary(currentPageNumber);

      FormService.submit(this.submissionUrl, pagePayload)
        .then(({
          isValid,
          pageNumber,
          confirmationType,
          confirmationMessage,
          confirmationRedirect,
        }) => {
          if (isValid) {
            if (pageNumber === 0) {
              this.$emit('submitted', { confirmationType, confirmationMessage, confirmationRedirect });
            } else {
              this.currentPageNumber = pageNumber;
              window.scrollTo(0, 0);
            }
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

    preloadSalesRepByExpertCodeIfNecessary(currentPageNumber) {
      if (currentPageNumber !== 1) return;
      const field = this.getPageFields(currentPageNumber)
        .find(f => f.cssClass.match(/validate-expert-code/));
      const expertCode = get(field, 'inputs[0].value', '');
      this[SALES_REP_FETCH_BY_EXPERT_CODE](expertCode);
    },
  },
};

</script>

<style lang="scss" scoped>

.passwordMask{

  .success{
    color: green;
    display: flex;
    align-items: center;

    &:before{
      content: "\2713";
      display: block;
      width: 20px;
    }
  }

  .failure{
    color: red;
    display: flex;
    align-items: center;

    &:before{
      content: "\2717";
      display: block;
      width: 20px;
    }
  }
}

.validate-pg_customer_id,
.validate-expert-code {
  width: 48%;

  &.w-full {
    width: 100%;
  }
}

.or-helper {
  width: 3%;
  text-align: center;
  padding: 0;
}

@media only screen and (max-width: 640px) {
  .validate-pg_customer_id,
  .validate-expert-code,
  .or-helper {
    width: 100%;
  }
}

.fade {
  &-enter-active,
  &-leave-active {
    transition: opacity 0.3s ease;
  }

  &-enter,
  &-leave-to {
    opacity: 0;
  }
}

</style>
