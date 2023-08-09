<template>
  <div class="downloads-container">
    <apo-wait
      v-if="!isAuthorized"
      for="downloadsAuthorization"
    >
      <template #waiting>
        <apo-loading-overlay
          class="my-15"
          :message="$t('loaders.downloads')"
        />
      </template>
      <div
        class="downloads-intro"
      >
        <apo-icon
          class="w-16 h-16 mb-8"
          src="download"
        />
        <h1
          class="headline-2"
          v-text="$t('downloads.title')"
        />
        <div class="mt-8 text-center">
          <apo-text-input
            v-model="userPassword"
            input-class="password-text-input"
            :placeholder="$t('pages.login.form.password.placeholder')"
            :title="$t('pages.login.form.password.title')"
            type="password"
            @keyup.enter="checkPassword()"
          >
            <template #before>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 26 32"
                fill="hsla(0, 0%, 100%, 0.75)"
                class="absolute w-4 h-4 ml-8"
              >
                <!-- eslint-disable-next-line max-len -->
                <path d="M25 13h-2v-3c0-5.51-4.49-10-10-10S3 4.49 3 10v3H1c-.55 0-1 .45-1 1v17c0 .55.45 1 1 1h24c.55 0 1-.45 1-1V14c0-.55-.45-1-1-1zM5 10c0-4.41 3.59-8 8-8s8 3.59 8 8v3H5v-3zm9 13.72V25c0 .55-.45 1-1 1s-1-.45-1-1v-1.28c-.6-.35-1-.98-1-1.72 0-1.1.9-2 2-2s2 .9 2 2c0 .74-.4 1.38-1 1.72z" />
              </svg>
            </template>
          </apo-text-input>
          <div
            class="w-full mt-2 text-sm text-center text-white"
          >
            {{ errorMessage }}
          </div>
          <apo-button
            class="mt-4 button--secondary shadow-hard-dark"
            @click="checkPassword()"
            v-text="'Einloggen'"
          />
        </div>
      </div>
    </apo-wait>
    <apo-wait
      v-if="!showDisclaimer && isAuthorized"
      for="downloads"
    >
      <template #waiting>
        <apo-loading-overlay
          class="my-15"
          :message="$t('loaders.downloads')"
        />
      </template>
      <!-- Start OVERVIEW -->
      <div v-if="isOverview && downloadCategories && downloadProducts && downloadCategories.some(cat => downloadProducts.some(prod => prod.category && prod.category.includes(cat.id)))">
        <div
          v-if="isOverview"
          class="downloads-intro"
        >
          <apo-icon
            class="w-16 h-16 mb-8"
            src="download"
          />
          <h1
            class="headline-2"
            v-text="$t('downloads.title')"
          />
        </div>
        <div
          v-if="!showDisclaimer"
          class="py-12"
        >
          <h2
            class="mb-8 text-center headline-3"
            v-html="$t('downloads.welcome')"
          />
          <div
            v-for="(category, index) in downloadCategories"
            :key="category.id"
          >
            <div
              v-if="downloadProducts.filter(prod => prod.category && prod.category.includes(category.id)).length > 0"
              class="p-3 my-3 text-xl text-center bg-gray-300 cursor-pointer"
              @click="showCategory = showCategory === index ? null : index
              "
            >
              <div class="container relative">
                <div>{{ category.name }}</div>
                <apo-icon
                  class="w-8 h-8 dropdown-icon"
                  :class="{ 'open': index === showCategory}"
                  src="chevron"
                />
              </div>
            </div>
            <apo-expand-collapse-transition>
              <div
                v-if="index === showCategory"
                class="container flex flex-wrap items-center justify-center"
              >
                <div
                  v-for="product in downloadProducts"
                  :key="product.id"
                >
                  <div
                    v-if="product.category && product.category.indexOf(category.id) !== -1"
                    class="m-3 cursor-pointer"
                    @click="productDetails(product.id)"
                  >
                    <div
                      class="mb-2 text-sm text-center"
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
            </apo-expand-collapse-transition>
          </div>
        </div>
      </div>
      <!-- End OVERVIEW -->
      <!-- Start DETAILVIEW -->
      <div v-if="!isOverview && downloadProduct && availableFilters && paginatedFilterDownloads">
        <div class="container">
          <router-link
            class="flex items-center my-4 text-sm"
            :to="{ name: 'downloads' }"
          >
            <apo-icon
              class="w-2 h-2 mr-1 origin-center rotate-90"
              src="chevron"
            /> <span v-text="$t('downloads.backToOverview')" />
          </router-link>
        </div>
        <div class="w-screen py-12">
          <h1
            class="mb-8 text-4xl font-bold text-center headline-4"
            v-html="downloadProduct.name"
          />
          <div class="container">
            <img
              v-if="downloadProduct.image"
              class="mx-auto mt-0 mb-20 product-image"
              :src="downloadProduct.image.url"
              alt="logo"
            >
            <div class="flex flex-wrap justify-between filterWrapper desktop:flex-nowrap">
              <div
                class="flex flex-wrap items-start justify-start mb-6 -ml-2 desktop:-ml-4"
              >
                <div
                  v-if="availableFilters.length > 0"
                  class="mb-2 ml-2 desktop:ml-4"
                >
                  <input
                    id="checkAll"
                    type="checkbox"
                    v-bind="$attrs"
                    :checked="filteredDownloads.length == productDownloads.length"
                    class="hidden"
                    @input="checkAllFilters"
                  >
                  <label
                    for="checkAll"
                    class="block p-3 border border-gray-700 rounded opacity-50 cursor-pointer"
                    v-html="$t('downloads.checkAll')"
                  />
                </div>
                <div
                  v-for="mediatype in availableFilters"
                  :key="mediatype.id"
                  class="mb-2 ml-2 desktop:ml-4"
                >
                  <input
                    :id="mediatype.id"
                    type="checkbox"
                    :value="mediatype.id"
                    v-bind="$attrs"
                    :checked="isChecked(mediatype.id)"
                    class="hidden"
                    v-on="listeners"
                  >
                  <label
                    :for="mediatype.id"
                    class="block p-3 border border-gray-700 rounded opacity-50 cursor-pointer"
                    v-html="mediatype.name"
                  />
                </div>
              </div>
              <div class="mb-6">
                <apo-text-input
                  id="downloadSearch"
                  :ref="searchValue"
                  :value="searchValue"
                  class="w-full"
                  :placeholder="$t('downloads.search')"
                  @input="searchDownloads"
                >
                  <span
                    slot="after"
                    class="px-3"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      height="24px"
                      viewBox="0 0 24 24"
                      width="24px"
                      fill="#000000"
                    ><path
                      d="M0 0h24v24H0z"
                      fill="none"
                    /><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" /></svg>
                  </span>
                </apo-text-input>
              </div>
            </div>
            <div class="flex items-center justify-between">
              <div>
                <div
                  class="inline-flex flex-col items-center hidden p-2 bg-gray-100 cursor-pointer"
                  @click="() => {
                    showFilter = !showFilter;
                    showDutyText = false;
                  }"
                >
                  <apo-icon
                    class="w-4 h-4"
                    src="filter"
                  />
                  <div class="mt-1 text-xs">
                    Filter
                  </div>
                </div>
              </div>
              <span
                v-if="downloadProduct.dutyText"
                class="cursor-pointer duty-text"
                @click="() => {
                  showDutyText = !showDutyText;
                  showFilter = false;
                }"
                v-html="$t('downloads.dutyText')"
              />
            </div>
            <div class="desktop:hidden">
              <apo-expand-collapse-transition>
                <div
                  v-if="showFilter"
                  class="flex flex-wrap items-start justify-start p-2 bg-gray-100"
                >
                  <div
                    v-for="mediatype in availableFilters"
                    :key="mediatype.id"
                    class="w-1/2 p-1 break-all tablet:w-1/3"
                  >
                    <input
                      :id="mediatype.id"
                      type="checkbox"
                      :value="mediatype.id"
                      v-bind="$attrs"
                      checked="true"
                      v-on="checkAll"
                    >
                    <label
                      :for="mediatype.id"
                      class="cursor-pointer"
                      v-html="mediatype.name"
                    />
                  </div>
                </div>
              </apo-expand-collapse-transition>
            </div>
            <apo-collapsible-content
              class="my-8 text-left"
              :show="showDutyText"
            >
              <div
                class="container p-6 mx-auto break-all"
                v-html="downloadProduct.dutyText"
              />
            </apo-collapsible-content>
          </div>
          <div class="mt-12">
            <div
              v-if="productDownloads.length > 0"
              class="container flex"
            >
              <div class="ml-2">
                <input
                  class="w-5 h-5"
                  type="checkbox"
                  @input="checkAllDownloadSelection"
                >
              </div>
              <a
                href="#"
                class="ml-8 underline"
                @click="downloadBundle"
                v-html="$t('downloads.bundleDownload')"
              />
            </div>
            <div v-if="productDownloads.length > 0">
              <div
                v-for="download in paginatedFilterDownloads"
                :key="download.id"
              >
                <div
                  v-if="download.file.url !== ''"
                  v-wow.fadeInUp
                  class="py-6 my-4 bg-gray-100"
                >
                  <div class="container flex flex-wrap items-center justify-between">
                    <div class="download-inner-container">
                      <div class="ml-2">
                        <input
                          class="w-5 h-5 downloadSelection"
                          type="checkbox"
                          :value="download.id"
                          :checked="downloadArray.includes(download.id)"
                          @input="checkDownloadSelection"
                        >
                      </div>
                      <div class="mediatype-icon-container">
                        <img
                          v-if="getMediatype(download.mediatype[0]).icon.url"
                          :src="getMediatype(download.mediatype[0]).icon.url"
                          alt="mediatype"
                          class="w-auto h-full max-w-full max-h-full"
                        >
                        <div
                          v-else
                          class="h-full"
                        >
                          <div
                            v-if="download.file.url"
                            class="h-full"
                          >
                            <div
                              v-if="download.file.url.split('.').pop() === 'jpg' || download.file.url.split('.').pop() === 'png' || download.file.url.split('.').pop() === 'svg'"
                              class="flex items-center justify-center w-full h-full border border-gray-700 border-solid"
                            >
                              <img
                                :src="download.file.url"
                                alt="mediatype"
                                class="mediatype-image"
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="text-lg">
                        <h2
                          class="font-bold headline-5"
                          v-html="download.title"
                        />
                        <div>{{ getMediatype(download.mediatype[0]).name }}</div>
                      </div>
                    </div>
                    <div class="download-inner-container">
                      <div class="text-sm text-right">
                        <div>
                          {{ download.fileInfo ? download.fileInfo : download.file.subtype.toUpperCase() }},
                          {{ getFormatFileSize(download.file.filesize) }}
                        </div>
                        <div>{{ getFormatDate(download.file.date) }}</div>
                      </div>
                      <apo-button
                        class="button--primary file-button shadow-hard-dark download-button"
                        @click="downloadFile(download.file)"
                        v-text="'Download'"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              v-else
              class="container max-w-4xl mx-auto text-6xl leading-none tracking-wide text-center text-gray-800 font-display"
              v-text="$t('downloads.messages.noDownloadsAvailable')"
            />
          </div>
        </div>
        <div class="container">
          <div
            v-if="numberOfPages > 0"
            class="pagination"
          >
            <apo-button
              type="button"
              :disabled="currentPage === 1"
              @click="navigateTroughList('previous')"
              v-text="'<'"
            />
            <apo-button
              v-for="(button, index) in numberOfPages"
              :key="'page-' + (index + 1)"
              :class="{'active': currentPage === index + 1}"
              type="button"
              :disabled="currentPage === index + 1"
              @click="navigateTroughList(index + 1)"
              v-text="index + 1"
            />
            <apo-button
              type="button"
              :disabled="currentPage === numberOfPages"
              @click="navigateTroughList('next')"
              v-text="'>'"
            />
          </div>
          <router-link
            class="flex items-center my-4 text-sm"
            :to="{ name: 'downloads' }"
          >
            <apo-icon
              class="w-2 h-2 mr-1 origin-center rotate-90"
              src="chevron"
            /> <span v-text="$t('downloads.backToOverview')" />
          </router-link>
        </div>
      </div>
      <!-- End DETAILVIEW -->
      <apo-scroller />
    </apo-wait>
    <div
      v-if="showDisclaimer && isAuthorized"
      class="overlay"
    >
      <div class="disclaimer">
        <h2
          class="mb-8 text-center"
          v-html="$t('downloads.disclaimer.headline')"
        />
        <div
          v-html="$t('downloads.disclaimer.text')"
        />
        <div class="flex flex-col flex-wrap items-center justify-center mt-6 tablet:flex-row tablet:mt-12">
          <apo-button
            type="button"
            class="order-2 px-8 py-3 m-2 button--secondary shadow-hard-dark tablet:order-1"
            @click="handleDisclaimer(false)"
            v-text="$t('downloads.decline')"
          />
          <apo-button
            type="button"
            class="order-1 px-8 py-3 m-2 button--primary shadow-hard-dark tablet:order-2"
            @click="handleDisclaimer(true)"
            v-text="$t('downloads.accept')"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';
import * as moment from 'moment';
import get from 'lodash/get';
import {
  DOWNLOADS_FETCH_ALL,
  TAXONOMIES_FETCH_DOWNLOAD_CATEGORIES,
  TAXONOMIES_FETCH_DOWNLOAD_PRODUCTS,
  TAXONOMIES_FETCH_DOWNLOAD_MEDIATYPES,
} from '@/store/types/action-types';
import themeSettings from '@/mixins/theme-settings';
import TextInput from '@/components/form-renderer/TextInput.vue';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import PageService from '@/services/api/PageService';

export default {
  components: {
    'apo-text-input': TextInput,
    'apo-loading-overlay': LoadingOverlay,
  },

  mixins: [
    themeSettings('downloads'),
  ],

  data() {
    return {
      isAuthorized: false,
      password: '!dhjfd645!434df',
      userPassword: '',
      showDisclaimer: !document.cookie.split(';').filter(item => item.includes('apo-disclaimer=accepted')).length,
      showCategory: null,
      isOverview: true,
      showDutyText: false,
      showFilter: false,
      filterArray: [],
      downloadArray: [],
      pageList: [],
      currentPage: 1,
      numberPerPage: 6,
      numberOfPages: 1,
      searchValue: '',
      errorMessage: '',
    };
  },

  computed: {
    ...mapGetters(['isAuthenticated', 'language', 'downloads', 'downloadCategories', 'downloadProducts', 'downloadMediatypes']),

    downloadProduct() {
      if (this.$route.params.id && this.downloadProducts.length) {
        return this.downloadProducts
          .find(downloadProduct => Number(downloadProduct.id) === Number(this.$route.params.id));
      }
      return null;
    },

    productDownloads() {
      return this.downloads
        .filter(download => download.product[0] === Number(this.$route.params.id));
    },

    availableFilters() {
      return this.downloadMediatypes
        .filter(mediatype => this.productDownloads
          .flatMap(download => download.mediatype[0]).indexOf(mediatype.id) >= 0);
    },

    filteredDownloads() {
      return this.productDownloads
        .filter(download => (download.title.toLowerCase().includes(this.searchValue.toLowerCase()) && download.mediatype.some(element => this.filterArray.indexOf(element) >= 0)));
    },

    paginatedFilterDownloads() {
      return this.pageList;
    },
    isAllCategoriesEmpty() {
      return this.downloadCategories.every(category => this.downloadProducts.filter(product => product.category && product.category.includes(category.id)).length === 0);
    },
    listeners() {
      return {
        ...this.$listeners,
        input: event => {
          const value = parseInt(event.target.value, 10);
          this.handleFilter(event.target.checked, value);
        },
      };
    },
  },

  watch: {
    $route: {
      immediate: true,
      handler(route) {
        if (route.params.id) {
          this.checkAllFilters();
          this.loadPaginatedList();
          this.isOverview = false;
        } else {
          this.isOverview = true;
        }
      },
    },
  },

  methods: {
    ...mapActions([
      DOWNLOADS_FETCH_ALL,
      TAXONOMIES_FETCH_DOWNLOAD_CATEGORIES,
      TAXONOMIES_FETCH_DOWNLOAD_PRODUCTS,
      TAXONOMIES_FETCH_DOWNLOAD_MEDIATYPES,
    ]),

    productDetails(id) {
      this.$router.push({ name: 'downloads', params: { id } });
    },

    getMediatype(id) {
      return this.downloadMediatypes.filter(mediatype => mediatype.id === id)[0];
    },

    getFormatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes';

      const k = 1024;
      const dm = 0;
      const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

      const i = Math.floor(Math.log(bytes) / Math.log(k));

      return `${parseFloat((bytes / (k ** i)).toFixed(dm))} ${sizes[i]}`;
    },

    getFormatDate(date) {
      moment.locale(this.language);
      return moment(date).format('DD. MMMM YYYY');
    },

    handleFilter(checked, value) {
      if (checked) {
        this.filterArray.push(value);
      } else {
        this.filterArray = this.filterArray.filter(element => element !== value);
      }

      this.loadPaginatedList();
    },

    searchDownloads(value) {
      this.searchValue = value;
      this.loadPaginatedList();
    },

    checkAllFilters(e = null) {
      if (e) {
        if (e.target.checked) {
          this.availableFilters.forEach(element => this.handleFilter(true, element.id));
        } else {
          this.filterArray = [];
        }
      } else {
        this.availableFilters.forEach(element => this.handleFilter(true, element.id));
      }
      this.loadPaginatedList();
    },

    isChecked(id) {
      return this.filterArray.includes(id);
    },

    checkDownloadSelection(e) {
      if (e.target.checked) {
        if (!this.downloadArray.includes(e.target.value)) {
          this.downloadArray.push(e.target.value);
        }
      } else {
        this.downloadArray = this.downloadArray.filter(item => item !== e.target.value);
      }
    },

    checkAllDownloadSelection(e) {
      if (e.target.checked) {
        document.querySelectorAll('.downloadSelection').forEach(item => {
          if (!this.downloadArray.includes(item.value)) {
            this.downloadArray.push(item.value);
          }
        });
      } else {
        this.downloadArray = [];
      }
    },

    loadPaginatedList() {
      if (this.filterArray.length === 0) {
        this.numberOfPages = Math.ceil(this.productDownloads.length / this.numberPerPage);
      } else {
        this.numberOfPages = Math.ceil(this.filteredDownloads.length / this.numberPerPage);
      }
      const begin = ((this.currentPage - 1) * this.numberPerPage);
      const end = begin + this.numberPerPage;
      this.pageList = this.filteredDownloads.slice(begin, end);
      if (this.numberOfPages === 1) {
        this.currentPage = 1;
      }
    },

    navigateTroughList(direction) {
      switch (direction) {
        case 'next':
          this.currentPage += 1;
          break;
        case 'previous':
          this.currentPage -= 1;
          break;
        default:
          this.currentPage = direction;
          break;
      }
      this.loadPaginatedList();
    },

    downloadBundle() {
      const values = btoa(this.downloadArray.join(','));
      window.location.replace(`/wp-json/apovoice/v1/downloadBundle?values=${values}`);
    },

    downloadFile(download) {
      const link = document.createElement('a');
      link.download = download.filename;
      link.target = '_blank';
      link.href = download.url;
      link.click();
      window.axios.get(`/wp-json/apovoice/v1/registerDownload/${download.post_id}`)
        .catch(error => console.log(error));
    },

    handleDisclaimer(isAccepted) {
      if (isAccepted) {
        document.cookie = 'apo-disclaimer=accepted';
        this.showDisclaimer = false;
      } else {
        document.cookie = 'apo-disclaimer=declined';
        this.$router.push('/');
      }
    },

    checkPassword() {
      this.isAuthorized = this.userPassword === this.password;

      if (!this.isAuthorized) {
        this.errorMessage = this.$t('downloads.wrongpassword');
      }
    },

    downloadContainerHeight() {
      const downloadContainer = document.querySelector('.downloads-container');
      const downloadContainerParent = downloadContainer.parentElement;
      const containerElement = downloadContainerParent.parentElement;

      downloadContainerParent.setAttribute('style', 'display: flex; flex: 1; flex-direction: column;');
      containerElement.setAttribute('style', 'display: flex; flex: 1;');
    },
  },

  created() {
    this.isAuthorized = this.isAuthenticated;
    if (!this.isAuthorized) {
      this.$store.dispatch('wait/start', 'downloadsAuthorization', { root: true });
      PageService.getPageBySlug('downloads')
        .then(data => {
          this.password = get(data, 'acf.password.password', '!dhjfd645!434df');
          this.$store.dispatch('wait/end', 'downloadsAuthorization', { root: true });
        });
    }
    this[TAXONOMIES_FETCH_DOWNLOAD_CATEGORIES]()
      .catch(error => {
        console.log('error retrieving the categories', error);
      });
    this[TAXONOMIES_FETCH_DOWNLOAD_PRODUCTS]()
      .catch(error => {
        console.log('error retrieving the products', error);
      });
    this[TAXONOMIES_FETCH_DOWNLOAD_MEDIATYPES]()
      .catch(error => {
        console.log('error retrieving the mediatypes', error);
      });
    this[DOWNLOADS_FETCH_ALL]()
      .then(() => {
        this.checkAllFilters();
      })
      .catch(error => {
        console.log('error retrieving the downloads', error);
      });
  },

  mounted() {
    const onResizeListener = () => {
      this.showFilter = false;
    };

    window.addEventListener('resize', onResizeListener);

    this.$once('hook:destroyed', () => {
      window.removeEventListener('resize', onResizeListener);
    });
    this.downloadContainerHeight();
  },
};

</script>

<style lang="scss" scoped>

.downloads-container {
  display: flex;
  flex: 1;

  > div {
    display: flex;
    flex: 1;

    /deep/ span {
      display: flex;
      flex: 1;
    }
  }

  .duty-text {
    text-decoration: underline;
  }

  .product-image {
    width: 30%;
  }
}

.downloads-intro {
  padding: 192px 0;
  background: linear-gradient(120deg, theme('colors.purple.400'), theme('colors.purple.300'));
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-size: 48px;
  color: white;
  flex: 1;
  @apply w-screen;
}

.password {
  /deep/ &-text-input {
  @apply pl-16;
  @apply pr-8;
  @apply py-3;
  @apply text-white;

    &:hover,
    &:focus {
      background-color: hsla(0, 0%, 100%, 0.08);
      @apply text-white;
    }

    &-wrapper {
      @apply border-4;
      @apply border-white;
    }
  }
}

.wrongpassword {
  display: none;
}

// OVERVIEW
.dropdown-icon {
  position: absolute;
  top: 50%;
  right: 16px;
  transform: translate(0, -50%);
  transition: transform 0.3s;

  &.open {
    transform: translate(0, -50%) rotate(180deg);
  }
}

.filterWrapper{

  input:checked ~ label{
    @apply border-purple-400;
    @apply text-purple-400;
    @apply opacity-100;
  }
}

.product-thumbnail-container {
  width: 180px;
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

// DETAILVIEW
.download-inner-container {
  display: flex;
  align-items: center;
  width: 50%;

  &:last-of-type {
    justify-content: flex-start;
  }

  &:last-of-type {
    justify-content: flex-end;
  }

  @media (max-width: theme('screens.tablet')) {
    width: 100%;
    margin: 8px 0;
  }
}

.mediatype-icon-container {
  min-width: 60px;
  margin: 0 40px;

  img {
    width: 60px;
    height: 60px;
  }

  @media (max-width: theme('screens.tablet')) {
    margin: 0 16px;
  }
}

.mediatype-image {
  max-width: 90%;
  max-height: 90%;
}

.file-button {
  padding: 12px 32px !important;
  margin-left: 96px;
  justify-self: flex-end;
}

.pagination {
  display: flex;
  justify-content: center;

  .button {
    font-weight: normal;
    padding: 4px;
    font-size: 14px;

    &.active {
      font-weight: bold;
    }
  }
}

.overlay {
  background-color: rgba( 0, 0, 0, 0.5);
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 99;

  .disclaimer {
    max-width: calc(100% - 40px);
    width: 900px;
    max-height: calc(100% - 40px);
    padding: 40px 32px;
    background-color: white;
    overflow: auto;

    @media (min-width: theme('screens.tablet')) {
      padding: 60px 96px;
    }
  }
}

</style>
