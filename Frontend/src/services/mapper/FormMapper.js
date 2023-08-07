import find from 'lodash/find';
import findIndex from 'lodash/findIndex';
import get from 'lodash/get';
import groupBy from 'lodash/groupBy';
import keys from 'lodash/keys';
import pickBy from 'lodash/pickBy';
import transform from 'lodash/transform';
import { stripHostnameFromUrl } from '@/services/utils';

export default class FormMapper {
  static mapForm(data) {
    const form = {
      id: String(get(data, 'id', '')),
      title: get(data, 'title', ''),
      description: get(data, 'description', ''),
      meta: FormMapper.mapFormMeta(data),
      submitButtonText: get(data, 'button.text', 'Submit'),
      isMultiPageForm: get(data, 'pagination') !== null,
      isActive: parseInt(get(data, 'is_active', '0'), 10) === 1,
    };

    if (form.isMultiPageForm) {
      form.fields = FormMapper.mapMultiPageFormFields(data);
    } else {
      form.fields = FormMapper.mapFields(data.fields);
    }

    return form;
  }

  static mapMultiPageFormFields(data) {
    const fields = data.fields || [];
    const fieldsGroupedByPageNumber = groupBy(fields, field => field.pageNumber);

    return transform(fieldsGroupedByPageNumber, (result, pageFields, pageNumber) => {
      const pageField = find(pageFields, ['type', 'page']);
      const page = {
        pageNumber,
        nextButton: {
          text: get(data, 'button.text', 'Submit'),
        },
        previousButton: null,
        fields: [],
      };

      if (pageField && pageNumber !== '1') {
        page.nextButton.text = get(pageField, 'nextButton.text');
        page.previousButton = { text: get(pageField, 'previousButton.text') };
      }

      page.fields = FormMapper.mapFields(pageFields);

      result.push(page);
    }, []);
  }

  static mapFields(fieldsData) {
    const skip = ['page'];

    return fieldsData
      .filter(data => skip.indexOf(data.type) === -1)
      .map(data => FormMapper.mapField(data));
  }

  static findPageFieldIndices(fields) {
    return keys(pickBy(fields, { type: 'page' }));
  }

  static mapFormMeta(data) {
    return {
      labelPlacement: FormMapper.parseLabelPlacement(get(data, 'label_placement', '')),
      subLabelPlacement: FormMapper.parseLabelPlacement(get(data, 'subLabelPlacement', '')),
      descriptionPlacement: get(data, 'descriptionPlacement', 'below'),
      submissionUrl: `/wp-json/gf/v2/forms/${get(data, 'id', '')}/submissions`,
    };
  }

  static mapField(data) {
    const field = {
      type: get(data, 'type', ''),
      id: String(get(data, 'id', '')),
      label: get(data, 'label', ''),
      errorMessage: get(data, 'errorMessage', ''),
      isVisible: get(data, 'visibility', 'visible') === 'visible',
      description: get(data, 'description', ''),
      descriptionPlacement: get(data, 'descriptionPlacement', 'below'),
      subLabelPlacement: FormMapper.parseLabelPlacement(get(data, 'subLabelPlacement', '')),
      placeholder: get(data, 'placeholder', ''),
      cssClass: get(data, 'cssClass', ''),
      defaultValue: get(data, 'defaultValue', ''),
      isDisplayOnly: get(data, 'displayOnly', false) === true,
      isRequired: get(data, 'isRequired', false),
      passwordDetails: get(data, 'passwordStrengthEnabled', false),
      size: get(data, 'size', 'medium'),
      labelPlacement: FormMapper.parseLabelPlacement(get(data, 'labelPlacement', 'top')),
    };

    field.inputs = FormMapper.mapFieldInputs(data, field);

    return field;
  }

  static mapFieldInputs(data, field) {
    // If the field has no sub-inputs, create an input
    // from the already mapped field
    if (get(data, 'inputs', null) === null) {
      // eslint-disable-next-line no-param-reassign
      data.inputs = [FormMapper.createFieldInput(field)];
    }

    return data.inputs.map(inputData => FormMapper.mapFieldInput(inputData, data, field));
  }

  static createFieldInput(field) {
    return {
      id: field.id,
      label: '',
    };
  }

  static mapFieldInput(inputData, data, field) {
    const fieldInput = {
      id: get(inputData, 'id', ''),
      label: get(inputData, 'label', ''),
      customLabel: get(inputData, 'customLabel', ''),
      placeholder: get(inputData, 'placeholder', ''),
      value: field.defaultValue || '',
      meta: FormMapper.mapFieldInputMeta(inputData, data, field),
    };

    // eslint-disable-next-line default-case
    switch (field.type) {
      case 'select':
        fieldInput.value = get(find(data.choices, ['isSelected', true]), 'value', '');

        break;

      case 'multiselect':
        fieldInput.value = data.choices
          .filter(choice => choice.isSelected)
          .map(({ value }) => value);

        break;

      case 'checkbox':
        fieldInput.label = fieldInput.customLabel || '';

        break;
    }

    return fieldInput;
  }

  static mapFieldInputMeta(inputData, data, field) {
    switch (field.type) {
      case 'text':
      case 'textarea':
        return {
          maxLength: get(data, 'maxLength', ''),
        };

      case 'select':
      case 'multiselect':
        return {
          options: data.choices.map(choice => FormMapper.mapChoice(choice)),
        };

      case 'html':
        return {
          content: get(data, 'content', ''),
        };

      case 'checkbox':
        return {
          choice: FormMapper.mapChoice(data.choices[findIndex(data.inputs, ['id', inputData.id])]),
        };

      case 'radio':
        return {
          choices: data.choices.map(choice => FormMapper.mapChoice(choice)),
        };

      default:
        return {};
    }
  }

  static mapChoice(data) {
    return {
      isSelected: get(data, 'isSelected', false),
      text: get(data, 'text', ''),
      value: get(data, 'value', ''),
    };
  }

  // Possible values can be 'top_label', 'bottom_label', 'hidden_label'
  // where we are most interested in the 'hidden' placement in order to
  // hide the form label.
  static parseLabelPlacement(placement) {
    const matches = placement.match(/(\w+)_label$/);

    return matches !== null ? matches[1] : 'top';
  }

  static mapSubmissionResponse(data) {
    return {
      confirmationMessage: get(data, 'confirmation_message', ''),
      confirmationType: get(data, 'confirmation_type', 'message'),
      confirmationRedirect: stripHostnameFromUrl(get(data, 'confirmation_redirect', '')),
      isValid: get(data, 'is_valid', false),
      pageNumber: parseInt(get(data, 'page_number', 0), 10),
      sourcePageNumber: parseInt(get(data, 'source_page_number', 0), 10),
    };
  }

  static mapErrorResponse(data) {
    return {
      isValid: get(data, 'is_valid', false),
      pageNumber: parseInt(get(data, 'page_number', 0), 10),
      sourcePageNumber: parseInt(get(data, 'source_page_number', 0), 10),
      validationMessages: FormMapper.mapErrorValidationMessages(get(data, 'validation_messages', 2)),
    };
  }

  static mapErrorValidationMessages(data) {
    return transform(data, (result, message, id) => {
      result.push({ id, message });
    }, []);
  }
}
