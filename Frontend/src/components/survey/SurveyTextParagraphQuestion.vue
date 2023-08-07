<template>
  <div class="survey-text-paragraph-question">
    <apo-wysiwyg-content :content="value" />
  </div>
</template>

<script>

export default {
  props: {
    id: {
      type: String,
      required: true,
    },

    value: {
      type: String,
      required: true,
    },
  },
};

</script>
