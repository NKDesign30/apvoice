<template>
  <div
    v-if="data"
    class="pharmacy-summary-pharmacy py-4 px-4 mt-4 tablet:text-center bg-blue-100 force-full-width"
  >
    <div class="container static tablet:relative flex flex-col tablet:flex-row flex-wrap">
      <div
        v-for="(element, index) in data"
        :key="'element' + index"
        class="tablet:px-4 my-4 w-full tablet:w-1/3 flex flex-col"
        :class="{'hidden' : element.title === 'pharmacyCountry'}"
      >
        <span
          class="inline-block font-bold text-gray-900"
          v-text="$t(`modules.pharmacySummary.form.${element.title}`)"
        />
        <span
          class="mt-2 inline-block text-gray-800"
          v-html="$options.filters.formatContent(element.value)"
        />
      </div>

      <slot name="after" />
    </div>
  </div>
</template>

<script>

export default {
  props: {
    data: {
      type: Array,
      required: true,
    },
  },
};

</script>

<style lang="scss" scoped>
  .force-full-width {
    margin-left: calc(-50vw + 50% + 7px);
    width: calc(100vw - 15px);
  }
</style>
