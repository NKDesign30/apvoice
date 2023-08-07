<template>
  <!-- eslint-disable max-len -->
  <div class="flex flex-col items-center py-24 user-summary">
    <h2 class="text-5xl text-white font-display">
      <span>Hallo, </span>
      <strong>apovoice User!</strong>
    </h2>

    <img
      src="/assets/img/user/no-profile-picture.png"
      alt="User profile picture"
      class="w-56 h-56 mt-24 border-white rounded-full user-summary__picture border-10"
    >

    <div class="flex mt-24">
      <div class="flex">
        <div class="w-32 h-32 p-1 bg-white bg-orange-600 border-white rounded-full border-5 shadow-hard">
          <div class="flex items-center justify-center w-full h-full text-6xl font-semibold text-orange-600 bg-white rounded-full font-display">
            10
          </div>
        </div>
        <div class="ml-6">
          <h4 class="text-3xl tracking-wide text-white font-display">
            Expertenpunkte
          </h4>
          <apo-button class="mt-5 text-orange-600 button--small button--naked button--theme-survey shadow-hard-dark">
            Jetzt einlösen
          </apo-button>
        </div>
      </div>
      <div class="flex ml-12">
        <div class="w-32 h-32 p-1 bg-white bg-orange-600 border-white rounded-full border-5 shadow-hard">
          <div class="flex items-center justify-center w-full h-full text-6xl font-semibold text-orange-600 bg-white rounded-full font-display">
            ?
          </div>
        </div>
        <div class="ml-6">
          <h4 class="text-3xl tracking-wide text-white font-display">
            Trainingsaktivität
          </h4>
          <apo-button class="mt-5 text-green-400 button--small button--naked button--theme-survey shadow-hard-dark">
            Zu den eTrainings
          </apo-button>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>

.user-summary {
  background: linear-gradient(120deg, theme('colors.blue.600'), theme('colors.blue.400'));

  &__picture {
    box-shadow: 0 4px 0 1px rgba(0, 0, 0,0.2), inset 0 1px 60px rgba(0, 0, 0, 0.35);
  }
}

</style>
