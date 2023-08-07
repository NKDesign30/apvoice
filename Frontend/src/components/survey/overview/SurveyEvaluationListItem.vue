<template>
  <apo-survey-list
    v-if="survey.status != 'Private'"
    class="bg-gray-100"
  >
    <template #icon>
      <apo-icon
        src="statistics"
        class="w-20 h-20 text-yellow-500"
      />
    </template>

    <div
      class="font-bold text-gray-900"
      v-html="$options.filters.formatContent(survey.title)"
    />
    <p :inner-html="survey.description | truncate | formatContent" />
  </apo-survey-list>
</template>

<script>
import SurveyList from '@/components/survey/overview/SurveyList.vue';

export default {
  components: {
    'apo-survey-list': SurveyList,
  },
  props: {
    survey: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style>

</style>
