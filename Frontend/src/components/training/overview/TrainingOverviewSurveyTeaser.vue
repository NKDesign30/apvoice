<template>
  <div class="training-overview__survey-teaser py-24 text-center">
    <div class="container">
      <h2
        class="mb-6 text-3xl tablet:text-6xl"
        v-text="$t('trainings.surveyTeaser.headline')"
      />
      <p
        class="mb-8 text-2xl"
        v-text="$t('trainings.surveyTeaser.message')"
      />
      <router-link
        :to="{ name: 'surveys' }"
        tag="apo-button"
        class="bg-yellow-500 text-white hover:bg-yellow-600 shadow-hard-dark"
        v-text="$t('general.participate')"
      />
    </div>
  </div>
</template>
