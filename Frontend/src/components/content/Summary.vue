<template>
  <div class="summary container text-center">
    <div class="summary-head max-w-4xl mx-auto">
      <h1
        v-if="headline"
        class="summary-headline font-display text-3xl tablet:text-4xl leading-3xl"
        v-html="$options.filters.formatContent(headline)"
      />
      <h2
        v-if="sub_headline"
        class="summary-subheadline mt-2 font-display text-3xl tablet:text-4xl font-bold mb-8 tablet:mb-10 leading-3xl"
        v-html="$options.filters.formatContent(sub_headline)"
      />
    </div>
    <div
      v-if="copy"
      class="summary-copy max-w-4xl mx-auto text-left"
      v-html="$options.filters.formatContent(copy)"
    />
    <small
      v-if="references"
      class="summary-references mt-5 block max-w-4xl mx-auto text-left"
      v-html="$options.filters.formatContent(references)"
    />
  </div>
</template>

<script>
import get from 'lodash/get';

export default {

  props: {
    summary: {
      type: Object,
      required: false,
      default: () => {},
    },
  },

  computed: {

    headline() {
      return get(this.summary, 'headline', '');
    },

    sub_headline() {
      return get(this.summary, 'sub_headline', '');
    },

    copy() {
      return get(this.summary, 'copy', '');
    },

    references() {
      return get(this.summary, 'references', '');
    },

  },
};

</script>

<style lang="scss">

.summary-copy {
  @apply font-display;

  ul {
    list-style-type: disc;
  }

  ol {
    list-style-type: decimal;
  }

  ul, ol {
    display: block;
    list-style-type: disc;
    margin-top: 1rem;
    margin-bottom: 1rem;
    margin-left: 0;
    margin-right: 0;
    padding-left: 40px;
  }

  li {
    display: list-item;
  }
}


</style>
