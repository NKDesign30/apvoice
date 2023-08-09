<template>
  <div class="flex flex-wrap justify-center">
    <div v-for="field in form" :key="field.id" class="tablet:px-4 my-4 w-full tablet:w-1/2">
      <apo-input-label :for="field.id" v-text="$t(getTranslationString(field.ref))" />
      <apo-text-input
        v-if="field.type === 'textInput'"
        :id="field.id"
        :ref="field.ref"
        v-model="field.model"
        :disabled="readOnly"
        class="mt-4 w-full"
      />
      <apo-select-input
        v-else
        :id="field.id"
        :ref="field.ref"
        v-model="field.model"
        :disabled="readOnly"
        :meta="{ options: field.options }"
        class="mt-4 w-full"
      />
    </div>
  </div>
</template>

<script>
import InputLabel from "@/components/form-renderer/InputLabel.vue";
import TextInput from "@/components/form-renderer/TextInput.vue";
import SelectInput from "@/components/form-renderer/SelectInput.vue";

export default {
  components: {
    "apo-input-label": InputLabel,
    "apo-text-input": TextInput,
    "apo-select-input": SelectInput
  },

  props: {
    form: {
      type: Array,
      required: true
    },
    readOnly: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  methods: {
    getTranslationString(key) {
      return `modules.pharmacySummary.form.${key}`;
    }
  }
};
</script>
