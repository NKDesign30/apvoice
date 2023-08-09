<template>
  <div class="px-5 py-3 mb-10 text-lg text-gray-800 tablet:px-0">
    <div class="container flex flex-wrap ali items-center max-w-4xl">
      <div class="relative mr-12">
        <slot name="icon" />
      </div>

      <div class="self-center flex-1 mr-6">
        <slot />
      </div>

      <div class="w-full mt-6 text-center tablet:mt-0 tablet:w-auto">
        <slot name="actions" />
      </div>
    </div>
  </div>
</template>
