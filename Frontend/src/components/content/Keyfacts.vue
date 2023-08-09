<template>
  <div class="keyfacts text-gray-900">
    <div class="container">
      <div
        v-if="headline || subheadline"
        class="keyfacts__headlines text-gray-900 mb-7"
      >
        <h2
          class="text-center"
          v-html="$options.filters.formatContent(headline)"
        />

        <h3
          v-if="subheadline"
          class="mt-6 text-center"
          v-html="$options.filters.formatContent(subheadline)"
        />
      </div>
      <!-- eslint-disable max-len -->
      <div class="mx-auto flex flex-col max-w-3xl tablet:flex-row tablet:flex-wrap justify-center text-center">
        <div
          v-for="item in keyfactItems"
          :key="item.id"
          class="keyfact mb-6 self-start max-w-sm tablet:w-1/3 mx-auto"
        >
          <div class="keyfact__value flex justify-center items-baseline flex-auto font-display">
            <span
              v-if="item.before_value"
              class="keyfact__value--before-value mr-1"
            >
              {{ item.before_value }}
            </span>

            <apo-count-up
              :to="Number(item.value)"
              class="keyfact__value--number text-6xl text-gray-900"
              when-in-viewport
            />

            <span
              v-if="item.after_value"
              class="keyfact__value--after-value ml-1 text-3xl text-gray-900"
            >
              {{ item.after_value }}
            </span>
          </div>

          <div
            v-if="item.description"
            class="keyfact__description description"
            v-html="$options.filters.formatContent(item.description)"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import uniqueId from 'lodash/uniqueId';

export default {
  props: {
    headline: {
      type: String,
      required: false,
      default: '',
    },
    subheadline: {
      type: String,
      required: false,
      default: '',
    },
    // eslint-disable-next-line vue/prop-name-casing
    keyfacts_item: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {
      keyfactItems: [],
    };
  },

  created() {
    this.keyfactItems = this.keyfacts_item.map(item => ({
      id: uniqueId(),
      ...item,
    }));
  },

};
</script>

<style>

</style>
