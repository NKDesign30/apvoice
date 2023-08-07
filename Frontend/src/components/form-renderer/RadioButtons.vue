<template>
  <div class="radio-buttons -mx-12 flex flex-wrap">
    <div
      v-for="choice in meta.choices"
      :key="getChoiceId(choice)"
      class="px-12"
    >
      <label
        :for="getChoiceId(choice)"
        class="flex items-center cursor-pointer"
      >
        <input
          :id="getChoiceId(choice)"
          v-model="selectedChoice"
          type="radio"
          :value="choice.value"
          v-bind="$attrs"
          v-on="listeners"
        >

        <div
          class="ml-4 text-2xl text-gray-800"
          v-html="$options.filters.formatContent(choice.text)"
        />
      </label>
    </div>
  </div>
</template>

<script>

import find from 'lodash/find';
import get from 'lodash/get';

export default {
  props: {
    meta: {
      type: Object,
      required: true,
    },

    value: {
      type: String,
      default: '',
    },

    id: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      selectedChoice: get(find(this.meta.choices, ['isSelected', true]), 'value', ''),
    };
  },

  computed: {
    listeners() {
      return {
        ...this.$listeners,
        input: event => this.$emit('input', event.target.value),
      };
    },
  },

  methods: {
    getChoiceId({ value }) {
      return `${this.id}-${value.toLowerCase()}`;
    },
  },
};

</script>
