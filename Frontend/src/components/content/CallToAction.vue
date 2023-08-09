<template>
  <div class="call-to-action flex flex-col items-center py-48 bg-white">
    <h3
      class="call-to-action-headline text-center text-6xl"
      v-html="$options.filters.formatContent(headline)"
    />

    <div
      v-if="text"
      class="mt-16 text-center text-3xl"
      v-html="$options.filters.formatContent(text)"
    />

    <apo-button
      class="mt-24"
      @click.native="onCtaClick"
      v-html="$options.filters.formatContent(button_label)"
    />
  </div>
</template>

<script>

export default {
  props: {
    headline: {
      type: String,
      required: true,
    },

    text: {
      type: String,
      default: '',
    },

    // eslint-disable-next-line vue/prop-name-casing
    button_label: {
      type: String,
      required: true,
    },

    // eslint-disable-next-line vue/prop-name-casing
    button_url: {
      type: String,
      required: true,
    },
  },

  methods: {
    onCtaClick() {
      window.location.href = this.button_url;
    },
  },
};

</script>
