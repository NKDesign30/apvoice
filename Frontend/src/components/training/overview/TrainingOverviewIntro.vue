<template>
  <div class="container px-4 pt-24 pb-12 text-center training-overview__intro tablet:px-0">
    <h2
      class="mb-8 text-3xl tablet:text-6xl"
      v-text="$t('trainings.overview.headline')"
    />
    <p
      class="text-2xl"
      v-text="$t('trainings.overview.message')"
    />
    <p
      class="mt-2 text-sm"
      v-text="$t('trainings.overview.submessage')"
    />
  </div>
</template>
