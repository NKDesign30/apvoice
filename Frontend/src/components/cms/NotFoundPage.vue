<template>
  <div class="not-found-page">
    <h1
      class="text-center font-bold"
      v-html="$t('side_down.error_404.headline')"
    />
    <h4
      class="text-center font-bold"
      v-html="$t('side_down.error_404.sub_headline')"
    />
    <div class="text-center description">
      <p
        v-html="$t('side_down.error_404.description')"
      />
    </div>
    <div class="flex justify-center back-button">
      <apo-button
        class="text-white button button--primary shadow-hard-dark"
        type="button"
        @click.native="onHomeClick"
        v-text="$t('template.navigation.homepage')"
      />
    </div>
  </div>
</template>

<script>

export default {

  head() {
    return {
      title: {
        inner: 'Page not found',
      },
    };
  },
  methods: {
    onHomeClick() {
      this.$router.push('/');
    },
  },
};
</script>

<style lang="scss" scoped>

.not-found-page {
  display: flex;
  flex-direction: column;
  background-image: url('../../assets/img/template/404.gif');
  background-position: 85%;
  background-size: cover;
  height: 85vh;
  position: relative;

  h1 {
    margin-top: 0;
    font-size: 3rem;
    color: #0034B0;
  }

  h4 {
    color: #0034B0;
    margin-top: 2rem;
    display: none;
  }

  .description {
    margin-top: 0;
  }

  p {
    color: #fff;
  }

  .back-button {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 10%;
  }

  @media (min-width: theme('screens.desktop')) {
    h1 {
      margin-top: 7rem;
      font-size: 8rem;
    }

    h4 {
      display: block;
    }

    .description {
      margin-top: 1rem;
    }
  }
}

</style>
