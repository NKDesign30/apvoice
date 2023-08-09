<template>
  <div class="question__response-message mx-auto max-w-lg text-training-500 text-center">
    <p>{{ msg }}</p>
  </div>
</template>

<script>

export default {
  props: {
    msg: {
      type: String,
      required: true,
      default: '',
    },
  },
};

</script>
