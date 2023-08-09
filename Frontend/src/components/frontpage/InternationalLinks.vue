<template>
  <div class="landing-page-international">
    <div
      v-if="wordpressContent"
      class="cms-content-content"
      v-html="$options.filters.formatContent(wordpressContent)"
    />
    <apo-cms-content-renderer
      v-if="content"
      :components="content"
    />

    <div class="landing-page-international__links container justify-center">
      <div
        v-for="site in filteredSites"
        :key="site.id"
        class="landing-page-international__link"
      >
        <a :href="site.url">
          <img
            :src="'/wp-json/apovoice/v1/media?p=/mediauploads/sites/'+site.iso+'.png'"
            alt=""
          >

          <div
            class="landing-page-international__title"
            v-html="$options.filters.formatContent(site.title)"
          />
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import PageService from '@/services/api/PageService';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

export default {
  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  head() {
    return {
      title: {
        inner: this.title,
      },
    };
  },

  data() {
    return {
      content: [],
      wordpressContent: '',
      title: '',
    };
  },

  computed: {
    ...mapGetters(['filteredSites']),
  },

  methods: {
    loadFrontpage() {
      PageService.getFrontPage()
        .then(({ acf, title, content }) => {
          this.title = title;
          this.content = acf.content;
          this.wordpressContent = content;
          this.$emit('updateHead');
        })
        .catch(console.error);
    },

    linkContainerHeight() {
      const linkContainer = document.querySelector('.cms-container');
      const linkContainerParent = linkContainer.parentElement;
      const containerElement = linkContainerParent.parentElement;

      linkContainer.setAttribute('style', 'height: 100%;');
      linkContainerParent.setAttribute('style', 'display: flex; flex: 1; flex-direction: column;');
      containerElement.setAttribute('style', 'display: flex; flex: 1;');
    },
  },

  created() {
    this.loadFrontpage();
  },

  mounted() {
    this.linkContainerHeight();
  },
};

</script>

<style lang="scss" scoped>

.landing-page-international {
  background: linear-gradient(120deg, theme('colors.blue.600'), theme('colors.blue.400'));
  height: 100%;
  display: flex;
  align-items: center;
  color: white;
  flex-direction: column;
  justify-content: center;

  &__links{
    display: flex;
    padding: 50px 0;
    flex-wrap: wrap;
  }

  &__link{
    flex-basis: 0;
    flex: 1 1 0px;
    padding: 10px 20px;

    a{
      background: white;
      border-radius: 15px;
      padding: 10px;
      align-items: center;
      display: flex;
      flex-direction: column;
      font-size: 37px;
      color: #0033af;
      @apply shadow-lg;
    }
  }

  &__title{
    padding-top: 8px;
  }
}


</style>
