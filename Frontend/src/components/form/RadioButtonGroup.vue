<template>
  <div class="radio-button-group py-px">
    <slot />
  </div>
</template>

<script>

export default {
  props: {
    value: {
      type: String,
      required: true,
    },
  },

  provide() {
    return {
      radioButtonState: this.sharedState,
    };
  },

  data() {
    return {
      sharedState: {
        groupName: this.generateGroupName(),
        checkedValue: this.value,
      },
    };
  },

  watch: {
    value(value) {
      this.sharedState.checkedValue = value;
    },
  },

  methods: {
    generateGroupName() {
      // eslint-disable-next-line no-underscore-dangle
      return `radio-button-group-${this._uid}`;
    },
  },

  mounted() {
    this.$slots.default.forEach(radioButton => {
      radioButton.componentInstance.$on('change', value => {
        this.sharedState.checkedValue = value;

        this.$emit('input', this.sharedState.checkedValue);
      });
    });
  },
};

</script>
