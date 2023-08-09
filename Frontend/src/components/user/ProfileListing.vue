<template>
  <div class="profile-listing">
  <div>
      <h2
        class="text-3xl tablet:text-5xl font-display"
        v-html="$options.filters.formatContent(headline)"
      ></h2>
  
    <div
      v-if="items"
    >
      <ul class="pl-4 mt-6 text-xl text-gray-700 list-disc tablet:text-2xl">
        <li
          v-for="item in items"
          :key="item"
          style="color: #3C3C3B; font-size: 20px;"
        >
          <slot
            name="item"
            :item="item"
          />
        </li>
      </ul>
    </div>
    <li
      v-else
      class="w-2/3 mt-5 "
      style="color:#3C3C3B; font-size: 20px;"
      v-text="$t('pages.profile.noTasksOrPriorities')"
    />
     <apo-button
          class="w-64 mt-12 text-white bg-blue-600"
          v-show="this.iconTraining"
          tag="apo-button"
          @click.native="$router.push({ name: 'profile.edit', hash: '#tasks-and-priorities' })"
          v-text="$t('general.edit')"
        />
  </div>
     
  </div>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      default() {
        return [];
      },
    },
    icon: {
      type: String,
      required: true,
    },
  
    headline: {
      type: String,
      required: true,
    },
  },
computed: {
      iconTraining(){
        return(this.icon=="training")
    }
  },
};
</script>