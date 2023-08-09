<template>
  <footer class="footer py-12 bg-gray-800">
    <div class="container flex-col-reverse desktop:flex-row flex text-white items-start">
      <div class="mt-8 desktop:mt-0 max-w-sm">
        <p
          class="text-sm"
          v-text="$t('template.footer.copyright.title', { date: new Date().getFullYear() })"
        />
        <p
          class="mt-4 text-sm leading-none"
          v-text="$t('template.footer.copyright.notice')"
        />
        <img
          :alt="$t('template.footer.logo.alt')"
          class="footer-logo mt-6 w-full"
          src="@/assets/img/template/p-g-health-logo-small.png"
        >
      </div>
      <div class="desktop:ml-4 flex-1 desktop:flex desktop:justify-between flex-wrap">
        <div
          v-for="item in menu.items"
          :key="item.id"
          class="mb-2 desktop:mb-3 desktop:inline-flex"
        >
          <a
            v-if="item.object === 'custom'"
            class="inline-block hover:underline"
            :href="item.url_path"
            target="_blank"
            v-html="$options.filters.formatContent(item.title)"
          />
          <router-link
            v-else
            class="inline-block hover:underline"
            :to="item.url_path"
            v-html="$options.filters.formatContent(item.title)"
          />
        </div>
      </div>
    </div>
  </footer>
</template>

<script>

import { mapState } from 'vuex';

export default {
  computed: {
    ...mapState({
      menu: state => state.pages.menus[process.env.VUE_APP_FOOTER_NAVIGATION_KEY] || { items: [] },
    }),
  },
};

</script>

<style lang="scss" scoped>

.footer {
  &-logo {
    max-width: 88px;
  }
}

</style>
