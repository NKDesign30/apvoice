<template>
  <!-- eslint-disable max-len -->
  <div class="container flex flex-col items-center mt-16 text-center survey-exit tablet:mt-24">
    <h3
      class="text-4xl leading-snug text-gray-900 tablet:text-5xl font-display"
      v-text="$t('surveys.messages.success.title')"
    />
    <div class="flex items-center justify-center w-32 h-32 mt-6 text-center text-yellow-500 border-yellow-500 rounded-full stroke-current tablet:mt-10 tablet:w-48 tablet:h-48 border-5">
      <apo-icon
        src="check"
        class="w-20 h-20"
      />
    </div>
    <p
      class="mt-6 tablet:mt-10"
      v-html="$t('surveys.messages.success.message', [$options.filters.formatContent(survey.title)])"
    />
    <div class="mt-12">
      <router-link
        to="/"
        tag="apo-button"
        class="mr-6 text-white button button--secondary shadow-hard-dark"
        v-text="$t('template.navigation.homepage')"
      />
      <router-link
        tag="apo-button"
        class="text-white button button--primary shadow-hard-dark"
        :to="{ name: 'surveys' }"
        v-text="$t('template.navigation.surveys')"
      />
    </div>
  </div>
  <!-- eslint-enable max-len -->
</template>

<script>
export default {
  props: {
    survey: {
      type: Object,
      required: true,
    },
  },
};
</script>
