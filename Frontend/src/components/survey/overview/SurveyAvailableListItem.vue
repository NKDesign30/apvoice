<template>
  <apo-survey-list
    v-if="survey.status != 'Private' && (!survey.expires_at || getExpireDays(survey) >= 0)"
    class="bg-yellow-200"
  >
    <template #icon>
      <apo-icon
        src="time"
        class="w-8 h-8 text-yellow-500"
      />
      <span class="absolute text-sm text-yellow-500 whitespace-no-wrap survey__duration--position">
        {{ duration }}
      </span>
    </template>

    <div
      class="font-bold text-gray-900"
      v-html="$options.filters.formatContent(survey.title)"
    />
    <p :inner-html="survey.description | truncate | formatContent" />

    <template #actions>
      <router-link
        class="text-yellow-500 bg-white hover:text-yellow-600 button--tiny shadow-hard"
        tag="apo-button"
        :to="{ name: 'surveys', params: { id: survey.id } }"
        v-text="$t('general.participate')"
      />
      <div
        v-if="survey.expires_at"
        class="italic mt-2 text-base"
        v-text="$t('surveys.expiresAt', { days: getExpireDays(survey) })"
      />
    </template>
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

  computed: {
    duration() {
      const { type, time: amount } = this.survey.duration;

      return this.$tc(`general.time.short.${type}`, amount, { amount });
    },

    fullDuration() {
      const { type, time: amount } = this.survey.duration;

      return this.$tc(`general.time.full.${type}`, amount, { amount });
    },
  },

  methods: {
    getExpireDays(survey) {
      return Math.round((new Date(survey.expires_at) - new Date()) / (1000 * 60 * 60 * 24));
    },
  },
};
</script>

<style lang="scss" scoped>

.survey__duration--position {
  top: 23%;
  left: 30%;
}

</style>
