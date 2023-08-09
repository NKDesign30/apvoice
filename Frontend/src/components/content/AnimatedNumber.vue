<template>
  <div>{{ startValue }}</div>
</template>

<script>
export default {
  props: {
    value: {
      type: Number,
      default: 0,
    },
  },

  data() {
    return {
      startValue: 0,
      interval: false,
    };
  },

  methods: {
    animate() {
      clearInterval(this.interval);

      // avoid strict operator because value can be a string-number
      // eslint-disable-next-line eqeqeq
      if (this.value == this.startValue) {
        return;
      }

      this.interval = window.setInterval(() => {
        // avoid strict operator because value can be a string-number
        // eslint-disable-next-line eqeqeq
        if (this.startValue != this.value) {
          let updatedValue = (this.value - this.startValue) / 10;

          updatedValue = updatedValue >= 0 ? Math.ceil(updatedValue) : Math.floor(updatedValue);

          this.startValue = this.startValue + updatedValue;
        }
      }, 20);
    },

  },

  created() {
    this.animate();
  },
};
</script>
