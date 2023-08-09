<template>
  <div class="training-overview__filter">
    <span
      v-for="category in trainingCategories"
      :key="category.id"
      class="mr-6"
    >
      <input
        :id="category.id"
        type="checkbox"
        :value="category.id"
        v-bind="$attrs"
        :checked="isChecked(category.id)"
        v-on="listeners"
      >
      <label
        :for="category.id"
        class="cursor-pointer"
        v-html="$options.filters.formatContent(category.name)"
      />
    </span>
  </div>
</template>

<script>
export default {
  props: {
    activeCategories: {
      type: Array,
      required: true,
      default: () => [],
    },
    trainingCategories: {
      type: Array,
      required: true,
      default: () => [],
    },
  },

  computed: {
    listeners() {
      return {
        ...this.$listeners,
        input: event => {
          const value = parseInt(event.target.value, 10);
          if (event.target.checked) {
            this.$emit('input', [...this.activeCategories, value]);
          } else {
            this.$emit('input', this.activeCategories.filter(val => val !== value));
          }
        },
      };
    },
  },

  methods: {
    isChecked(value) {
      return this.activeCategories.indexOf(value) !== -1;
    },
  },

};
</script>
