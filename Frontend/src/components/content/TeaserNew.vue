<template>
  <div
    v-if="isVisible"
    :class="'teaser flex flex-col items-center py-48 bg-white' + theme"
  >
    <div class="container">
      <h2
        v-if="teaser_new.main_headline"
        class="text-center text-6xl leading-none mb-2"
        v-html="$options.filters.formatContent(teaser_new.main_headline)"
      />
    </div>
    <hr
      v-if="teaser_new.main_headline"
      class="h-1 my-2 w-full mb-12"
      :style="customColor ? 'background-color:' + customColor : null"
    >
    <div class="container">
      <div class="relative">
        <router-link
          v-if="teaser_new.button.link"
          class="w-full teaser-new-button"
          tag="a"
          :to="teaser_new.button.link"
        >
          <div
            v-if="background !== null"
            class="background flex items-center justify-center"
          >
            <img
              class="desktop:max-w-full"
              :src="background.url"
              :title="background.title"
            >
          </div>
          <div
            class="teaser-content absolute flex items-center inset-0 w-full h-full text-white"
            :class="'justify-'+position"
          >
            <div class="w-full desktop:w-1/2 flex flex-col items-center justify-center">
              <div
                v-if="teaser_new.subline"
                class="container text-center text-3xl text-bold"
                v-html="$options.filters.formatContent(teaser_new.subline)"
              />
              <h2
                v-if="teaser_new.headline"
                class="text-center text-6xl leading-none mb-2 text-bold"
                v-html="$options.filters.formatContent(teaser_new.headline)"
              />

              <div
                v-if="teaser_new.text"
                class="container mt-2 text-center text-2xl"
                v-html="$options.filters.formatContent(teaser_new.text)"
              />
            </div>
          </div>
        </router-link>
        <div
          v-else
          class="w-full"
        >
          <div
            v-if="background !== null"
            class="background flex items-center justify-center"
          >
            <img
              class="desktop:max-w-full"
              :src="background.url"
              :title="background.title"
            >
          </div>
          <div
            class="teaser-content absolute flex items-center inset-0 w-full h-full text-white"
            :class="'justify-'+position"
          >
            <div class="w-full desktop:w-1/2 flex flex-col items-center justify-center">
              <div
                v-if="teaser_new.subline"
                class="container text-center text-3xl text-bold"
                v-html="$options.filters.formatContent(teaser_new.subline)"
              />
              <h2
                v-if="teaser_new.headline"
                class="text-center text-6xl leading-none mb-2 text-bold"
                v-html="$options.filters.formatContent(teaser_new.headline)"
              />

              <div
                v-if="teaser_new.text"
                class="container mt-2 text-center text-2xl"
                v-html="$options.filters.formatContent(teaser_new.text)"
              />
            </div>
          </div>
        </div>
      </div>

      <div v-if="teaser_new.recent_elements !== 'none' && (downloadProductsPosts.length > 0 || knowledgeBasePosts.length > 0)">
        <h3
          v-if="teaser_new.recent_headline"
          class="text-center text-4xl leading-none mb-2 mt-8"
          v-html="$options.filters.formatContent(teaser_new.recent_headline)"
        />

        <div
          v-if="teaser_new.recent_elements === 'knowledgebase' && knowledgeBasePosts.length > 0"
          class="flex"
        >
          <div
            v-for="post in knowledgeBasePosts"
            :key="post.id"
            :class="'w-full desktop:pr-3 ' + (teaser_new.recent_number === 1 ? 'desktop:w-full' : 'desktop:w-1/' + teaser_new.recent_number)"
          >
            <div
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
                  class="w-full tablet:w-1/2 cursor-pointer teaser-new-post-knowledgebase"
                  :src="post.image"
                  @click="postDetails(post.id)"
                >
                <div class="w-full tablet:w-1/2 mb-2 tablet:mb-0 tablet:ml-2">
                  <div class="mt-2">
                    {{ post.teaser }}
                    <span
                      class="text-purple-500 cursor-pointer teaser-new-post-knowledgebase"
                      @click="postDetails(post.id)"
                      v-text="$t('general.readMore')"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          v-if="teaser_new.recent_elements === 'downloads' && downloadProductsPosts.length > 0"
          class="flex"
        >
          <div
            v-for="product in downloadProductsPosts"
            :key="product.id"
            :class="'w-full desktop:pr-3 ' + (teaser_new.recent_number === 1 ? 'desktop:w-full' : 'desktop:w-1/' + teaser_new.recent_number)"
          >
            <div
              class="m-3 cursor-pointer teaser-new-post-download"
              @click="productDetails(product.id)"
            >
              <div
                class="text-sm mb-2"
                v-html="product.name"
              />
              <div class="product-thumbnail-container">
                <img
                  v-if="product.image"
                  class="product-thumbnail"
                  :src="product.image.url"
                  alt="logo"
                >
                <div
                  v-else
                  class="no-image"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';
import { KNOWLEDGE_BASE_FETCH_ALL, TAXONOMIES_FETCH_DOWNLOAD_PRODUCTS } from '@/store/types/action-types';

export default {
  props: {
    teaser_new: {
      type: Object,
      required: true,
    },
  },
  computed: {
    ...mapGetters(['user', 'knowledgeBase', 'downloadProducts']),

    isVisible() {
      /*
      if (typeof this.teaser.userrole === 'object' && this.teaser.userrole.length > 0 && !this.teaser.userrole.includes('NO_RESTRICTION')) {
        const res = this.teaser.userrole.find(item => this.user.roles.includes(item));
        return typeof res !== 'undefined';
      } */
      return true;
    },

    background() {
      const img = this.teaser_new.big_image.image !== false ? { title: this.teaser_new.big_image.headline, url: this.teaser_new.big_image.image.url } : null;
      return img;
      // return this.teaser.color_scheme.theme !== 'none' ? ` theme-${this.teaser.color_scheme.theme}` : null;
    },

    theme() {
      return this.teaser_new.color_scheme.teaser_new !== 'none' ? ` theme-${this.teaser_new.color_scheme.theme}` : null;
    },

    customColor() {
      if (this.teaser_new.color_scheme.custom_color) {
        return this.teaser_new.color_scheme.custom_color;
      }
      return null;
    },

    downloadProductsPosts() {
      return this.downloadProducts.slice(0, this.teaser_new.recent_number);
    },

    knowledgeBasePosts() {
      return this.knowledgeBase.slice(0, this.teaser_new.recent_number);
    },

    position() {
      let pos = null;
      switch (this.teaser_new.position) {
        case 'left':
          pos = 'start';
          break;
        case 'center':
          pos = 'center';
          break;
        case 'right':
          pos = 'end';
          break;
        default:
          pos = 'left';
          break;
      }
      return pos;
      // return this.teaser.color_scheme.theme !== 'none' ? ` theme-${this.teaser.color_scheme.theme}` : null;
    },
  },

  methods: {
    ...mapActions([
      KNOWLEDGE_BASE_FETCH_ALL,
      TAXONOMIES_FETCH_DOWNLOAD_PRODUCTS,
    ]),

    productDetails(id) {
      this.$router.push({ name: 'downloads', params: { id } });
    },

    postDetails(id) {
      this.$router.push({ name: 'knowledgeBase', params: { id } });
    },
  },

  created() {
    if (this.teaser_new.recent_elements === 'knowledgebase') {
      this[KNOWLEDGE_BASE_FETCH_ALL]()
        .catch(error => {
          console.log('error retrieving the posts', error);
        });
    }
    if (this.teaser_new.recent_elements === 'downloads') {
      this[TAXONOMIES_FETCH_DOWNLOAD_PRODUCTS]()
        .catch(error => {
          console.log('error retrieving the products', error);
        });
    }
  },
};

</script>

<style lang="scss" scoped>
.background{
  overflow: hidden;

  img{
    max-width: none;
  }
}

.theme-default {
    hr {
      background-color: theme('colors.blue.600');
    }
  }

  .theme-training {
    hr {
      background-color: theme('colors.training.500');
    }
  }

  .theme-survey {
    hr {
      background-color: theme('colors.orange.600');
    }
  }

  .theme-knowledge-base,
  .theme-downloads {
    hr {
      background-color: theme('colors.purple.500');
    }
  }

  .theme-raffle {
    hr {
      background-color: theme('colors.green.500');
    }
  }

  #app {
    .theme-training {
      hr {
        background-color: theme('colors.training.500');
      }
    }

    .theme-survey {
      hr {
        background-color: theme('colors.orange.600');
      }
    }

    .theme-knowledge-base,
    .theme-downloads {
      hr {
        background-color: theme('colors.purple.500');
      }
    }

    .theme-raffle {
      hr {
        background-color: theme('colors.green.500');
      }
    }
  }

.product-thumbnail-container {
  width: 100%;
  height: 100px;
  border: 1px solid theme('colors.gray.600');
  padding: 8px;
  display: flex;
  align-items: center;
  justify-content: center;

  img {
    width: auto;
    height: 90%;
  }

  .no-image {
    width: 100%;
    height: 100%;
    background-color: theme('colors.gray.500');
  }
}
</style>
