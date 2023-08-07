<template>
  <div class="landing-page mt-12">
    <apo-cms-content-renderer
      v-if="content"
      :components="content"
    />
  </div>
</template>

<script>
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
      title: '',
    };
  },

  methods: {
    loadFrontpage() {
      PageService.getFrontPage()
        .then(({ acf, title }) => {
          this.title = title;
          this.content = acf.content;
          this.$emit('updateHead');
        })
        .catch(console.error);
    },
  },

  created() {
    this.loadFrontpage();
  },
};

</script>
