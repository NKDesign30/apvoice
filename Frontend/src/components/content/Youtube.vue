<template>
  <div class="container youtube">
    <div
      v-if="headline"
      class="container mb-16 text-4xl text-center youtube__headline desktop:text-5xl"
      v-html="$options.filters.formatContent(headline)"
    />
    <div>
      <iframe
        style="margin: 0 auto"
        width="560"
        height="315"
        :src="link"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
      />
    </div>
  </div>
</template>

<script>
import get from 'lodash/get';

export default {
  props: {
    youtube: {
      type: Object,
      required: true,
    },
  },
  computed: {
    link() {
      return get(this.youtube, 'link', null);
    },
    headline() {
      return get(this.youtube, 'headline', null);
    },
  },
};
</script>

<style lang="scss" scoped>

  @tailwind components;

  .youtube {
    .youtube__headline {
      @apply headline-3;

      @screen desktop {
        @apply headline-3-desktop;
      }
    }
  }

</style>
