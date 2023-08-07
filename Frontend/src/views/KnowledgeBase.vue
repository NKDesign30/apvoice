<template>
  <div>
    <apo-wait
      for="knowledgeBasePosts"
    >
      <template #waiting>
        <apo-loading-overlay
          class="my-15"
          :message="$t('loaders.knowledgeBase')"
        />
      </template>
      <div
        v-if="isOverview"
        class="relative"
      >
        <div class="container">
          <div class="downloads-teaser-container">
            <div
              class="flex flex-col items-center justify-center cursor-pointer"
              @click="gotoDownloads()"
            >
              <apo-icon
                class="w-8 h-8 mb-2"
                src="database"
              />
              <div v-text="$t('knowledgeBase.prmDatabase')" />
              <div class="hidden tablet:block">
                <router-link
                  class="button--secondary shadow-hard-dark text-purple-500 mt-6"
                  tag="apo-button"
                  :to="{ name: 'downloads' }"
                  v-text="$t('knowledgeBase.toDatabase')"
                />
              </div>
            </div>
          </div>
          <div v-if="content && contentPosition === 'before'">
            <component
              :is="`apo-cms-${renderer}-renderer`"
              v-for="(components, renderer) in content"
              :key="`${renderer}-renderer`"
              :components="components || []"
            />
          </div>
          <div class="flex justify-between flex-wrap py-16 tablet:py-32">
            <div
              v-for="post in knowledgeBase"
              :key="post.id"
              :class="{ 'w-full desktop:w-1/2 desktop:pr-3': post.type === 'large_half', 'w-full': post.type === 'large_full' || post.type === 'small_full' }"
            >
              <div
                v-if="post.type === 'large_half'"
                class="my-4"
              >
                <div class="text-purple-500 font-bold">
                  {{ post.subline }}
                </div>
                <h4>
                  {{ post.title }}
                </h4>
                <div class="flex flex-col tablet:flex-row justify-start items-start my-2">
                  <img
                    v-if="post.image"
                    class="w-full tablet:w-1/2 cursor-pointer"
                    :src="post.image"
                    @click="postDetails(post.id)"
                  >
                  <div class="w-full tablet:w-1/2 mb-2 tablet:mb-0 tablet:ml-2">
                    <div class="mt-2">
                      {{ post.teaser }}
                      <span
                        class="text-purple-500 cursor-pointer"
                        @click="postDetails(post.id)"
                        v-text="$t('general.readMore')"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div
                v-if="post.type === 'large_full'"
                class="flex flex-col tablet:flex-row justify-start items-start my-4"
              >
                <img
                  v-if="post.image"
                  class="w-full tablet:w-1/2 order-2 tablet:order-1 cursor-pointer"
                  :src="post.image"
                  @click="postDetails(post.id)"
                >
                <div class="w-full tablet:w-1/2 mb-2 tablet:mb-0 tablet:ml-2 order-1 tablet:order-2">
                  <div class="text-purple-500 font-bold">
                    {{ post.subline }}
                  </div>
                  <h4>
                    {{ post.title }}
                  </h4>
                  <div class="mt-2 hidden tablet:block">
                    {{ post.teaser }}
                    <span
                      class="text-purple-500 cursor-pointer"
                      @click="postDetails(post.id)"
                      v-text="$t('general.readMore')"
                    />
                  </div>
                </div>
                <div class="mt-2 order-3 tablet:hidden">
                  {{ post.teaser }}
                  <span
                    class="text-purple-500 cursor-pointer"
                    @click="postDetails(post.id)"
                    v-text="$t('general.readMore')"
                  />
                </div>
              </div>
              <div
                v-if="post.type === 'small_full'"
                class="flex flex-col tablet:flex-row justify-start items-start my-4"
              >
                <img
                  v-if="post.image"
                  class="w-full tablet:w-40 order-2 tablet:order-1"
                  :src="post.image"
                  @click="postDetails(post.id)"
                >
                <div class="w-full tablet:w-auto mb-2 tablet:mb-0 tablet:ml-2 order-1 tablet:order-2">
                  <div class="text-purple-500 font-bold">
                    {{ post.subline }}
                  </div>
                  <h4>
                    {{ post.title }}
                  </h4>
                  <div class="mt-2 hidden tablet:block">
                    {{ post.teaser }}
                    <span
                      class="text-purple-500 cursor-pointer"
                      @click="postDetails(post.id)"
                      v-text="$t('general.readMore')"
                    />
                  </div>
                </div>
                <div class="mt-2 order-3 tablet:hidden">
                  {{ post.teaser }}
                  <span
                    class="text-purple-500 cursor-pointer"
                    @click="postDetails(post.id)"
                    v-text="$t('general.readMore')"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="overview__survey-teaser py-24 text-center">
            <div class="container">
              <h2
                class="mb-6 text-3xl tablet:text-6xl"
                v-text="$t('knowledgeBase.surveyTeaser.headline')"
              />
              <p
                class="mb-8 text-2xl"
                v-text="$t('knowledgeBase.surveyTeaser.message')"
              />
              <router-link
                :to="{ name: 'surveys' }"
                tag="apo-button"
                class="bg-yellow-500 text-white hover:bg-yellow-600 shadow-hard-dark"
                v-text="$t('general.participate')"
              />
            </div>
          </div>
          <div v-if="content && contentPosition === 'after'">
            <component
              :is="`apo-cms-${renderer}-renderer`"
              v-for="(components, renderer) in content"
              :key="`${renderer}-renderer`"
              :components="components || []"
            />
          </div>
        </div>
      </div>
      <div v-else>
        <div v-if="knowledgeBaseDetail">
          <apo-stage
            v-if="stage"
            :stage-data="stage"
          />
          <div
            v-if="knowledgeBaseDetail.date"
            class="container"
          >
            <div
              class="text-right text-purple-500 mt-2"
              v-text="getFormatDate(knowledgeBaseDetail.date)"
            />
          </div>
          <div class="py-12">
            <div class="container">
              <div class="text-purple-500 font-bold text-center mb-4">
                {{ knowledgeBaseDetail.subline }}
              </div>
              <h3 class="text-center">
                {{ knowledgeBaseDetail.title }}
              </h3>
              <apo-cms-content-renderer
                v-if="knowledgeBaseDetail.content"
                :components="knowledgeBaseDetail.content"
                class="mt-20"
              />
              <div
                v-if="relatedPosts.length"
                class="py-8 tablet:py-12"
              >
                <h3
                  class="text-center"
                  v-text="$t('knowledgeBase.relatedPostsHeadline')"
                />
                <div
                  class="flex justify-between flex-wrap"
                >
                  <div
                    v-for="post in relatedPosts"
                    :key="post.id"
                    class="desktop:w-1/2 desktop:pr-3"
                  >
                    <div
                      v-if="post"
                      class="my-4"
                    >
                      <div class="text-purple-500 font-bold">
                        {{ post.subline }}
                      </div>
                      <h4>
                        {{ post.title }}
                      </h4>
                      <div class="flex flex-col tablet:flex-row justify-start items-start my-2">
                        <img
                          v-if="post.image"
                          class="w-full tablet:w-1/2"
                          :src="post.image"
                          @click="postDetails(post.id)"
                        >
                        <div class="w-full tablet:w-1/2 mb-2 tablet:mb-0 tablet:ml-2">
                          <div class="mt-2">
                            {{ post.teaser }}
                            <span
                              class="text-purple-500 cursor-pointer"
                              @click="postDetails(post.id)"
                              v-text="$t('general.readMore')"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <apo-not-found-page v-else />
      </div>
    </apo-wait>
  </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';
import get from 'lodash/get';
import * as moment from 'moment';
import { KNOWLEDGE_BASE_FETCH_ALL } from '@/store/types/action-types';
import themeSettings from '@/mixins/theme-settings';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import NotFoundPage from '@/components/cms/NotFoundPage.vue';
import Stage from '@/components/template/Stage.vue';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

export default {
  components: {
    'apo-loading-overlay': LoadingOverlay,
    'apo-not-found-page': NotFoundPage,
    'apo-stage': Stage,
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  mixins: [
    themeSettings('knowledge-base'),
  ],

  data() {
    return {
      isOverview: true,
    };
  },

  computed: {
    ...mapGetters(['isAuthenticated', 'language', 'knowledgeBase']),

    pageData() {
      return this.$store.state.pages.pageContent.filter(page => page.slug === this.$route.path.replace(/^\/|\/$/g, '')).length > 0
        ? this.$store.state.pages.pageContent.filter(page => page.slug === this.$route.path.replace(/^\/|\/$/g, ''))[0]
        : null;
    },

    content() {
      if (this.pageData) {
        const {
        /* eslint-disable */
          password, minimum_height, slides, public_resource, content_position, ...filtered
        } = this.pageData.acf;
        /* eslint-enable */
        return filtered;
      }

      return null;
    },

    contentPosition() {
      return this.pageData ? this.pageData.acf.content_position : null;
    },

    knowledgeBaseDetail() {
      if (this.$route.params.id && this.knowledgeBase.length) {
        return this.knowledgeBase
          .find(post => Number(post.id) === Number(this.$route.params.id));
      }
      return null;
    },

    stage() {
      return { minimum_height: this.knowledgeBaseDetail.stage.minimum_height, slides: this.knowledgeBaseDetail.stage.slides };
    },

    relatedPosts() {
      return this.knowledgeBase
        .filter(post => Number(post.id) === Number(get(this.knowledgeBaseDetail, 'relatedPosts.post_1.ID')) || Number(post.id) === Number(get(this.knowledgeBaseDetail, 'relatedPosts.post_2.ID')));
    },
  },

  watch: {
    $route: {
      immediate: true,
      handler(route) {
        if (route.params.id) {
          this.isOverview = false;
        } else {
          this.isOverview = true;
        }
      },
    },
  },

  methods: {
    ...mapActions([
      KNOWLEDGE_BASE_FETCH_ALL,
    ]),

    postDetails(id) {
      this.$router.push({ name: 'knowledgeBase', params: { id } });
    },

    gotoDownloads() {
      this.$router.push({ name: 'downloads' });
    },

    getFormatDate(date) {
      moment.locale(this.language);
      return moment(date).format('DD. MMMM YYYY');
    },
  },

  created() {
    this[KNOWLEDGE_BASE_FETCH_ALL]()
      .catch(error => {
        console.log('error retrieving the posts', error);
      });
  },
};

</script>

<style lang="scss" scoped>

.downloads-teaser-container {
  position: absolute;
  right: 0;
  top: 0;
  transform: translateY(-50%);
  padding: 24px 48px;
  background-color: theme('colors.purple.500');
  color: white;
  font-size: 24px;
  font-weight: bold;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;

  @media (min-width: theme('screens.desktop')) {
    left: calc(50% + 240px);
  }
}

</style>
