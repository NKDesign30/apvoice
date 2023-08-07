<template>
  <div class="registration-information mt-12">
    <div class="flex justify-center">
      <button
        class="text-2xl text-gray-900 underline"
        type="button"
        @click="isInformationVisible = !isInformationVisible"
        v-text="$t('pages.registration.information.headline')"
      />
    </div>

    <apo-collapsible-content
      class="py-12 relative"
      :class="{ 'mt-12': isInformationVisible }"
      :show="isInformationVisible"
    >
      <div
        class="container"
        v-html="$options.filters.formatContent(field.description)"
      />

      <button
        class="mr-12 mt-4 absolute top-0 right-0 text-gray-900"
        type="button"
        :title="$t('general.close')"
        @click="isInformationVisible = false"
      >
        <apo-icon
          class="w-4"
          src="close"
        />
      </button>
    </apo-collapsible-content>
  </div>
</template>

<script>

export default {
  props: {
    field: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      isInformationVisible: false,
    };
  },
};

</script>
