<template>
  <apo-restrict-content-wrapper>
    <apo-animate-transition name="fadeInDown">
      <apo-redeem-notification />
    </apo-animate-transition>
    <div class="redeem">
      <div
        id="welcome-section-4"
      >

        <div
          class="relative flex flex-wrap justify-center pt-5 pb-10 pl-4 pr-4 mx-auto space-x-12 text-white max-w-7xl tablet:py-20 tablet:flex-row tablet:px-20"
        >
                          <img src="/assets/img/coins.svg" class="responsive-image absolute hidden tablet:block" style="z-index:1">

          <div class="flex flex-col w-full tablet:w-1/2">
            <h1 class="flex flex-wrap pr-8 text-5xl tablet:text-4xl leading-3">
              <span class="w-full font-bold leading-4">{{ $t('redeem.welcome') }}, {{ user.firstName }}!</span>
              <span class="w-full leading-4">
                {{ $t('redeem.redeem_title') }}
              </span>
            </h1>
          </div>
          <div class="flex flex-wrap w-full mt-5 tablet:w-1/2 tablet:mt-0">
            <p class="w-full mb-3 text-xl">
              {{ $t('redeem.your') }} {{ $t('general.apoCoins') }}:
            </p>
            <div class="flex flex-row w-2/3">
              <div
                class="w-full px-2 py-1 rounded-lg"
                style="background: transparent linear-gradient(245deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;"
              >
                <div class="relative">
                  <img
                    src="/assets/img/Apo-Info.svg"
                    class="ml-auto"
                    alt=""
                    @click="showTooltipAchievements"
                  >
                  <div
                    id="tooltip-default"
                    role="tooltip"
                    class="absolute right-0 inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm top-10 tooltip dark:bg-gray-700"
                    :class="showAchTooltip ? 'opacity-1 ' : 'opacity-0 '"
                    :style="showAchTooltip ? 'z-index: 999' : 'z-index: -1'"
                  >
                    {{ $t('general.apoCoinsTooltip') }}
                    <div
                      class="tooltip-arrow"
                      data-popper-arrow
                    />
                  </div>
                </div>
                <img
                  src="/assets/img/coins.svg"
                  class="absolute left-5"
                  alt=""
                >

                <h3 class="flex justify-center w-full py-8 text-5xl tablet:text-6xl" style="font-size: 5rem;">
                  {{ user.expertPoints }}
                </h3>
                <div class="flex flex-row justify-between text-xs tablet:text-base">
                  <p class="mr-2">
                    {{ $t('general.apoCoins') }}
                  </p>
                  <a
                    class="underline"
                    href="#"
                    @click="exchange"
                  >
                    {{ $t('redeem.redeem') }}
                  </a>
                </div>
              </div>
            </div>
            <div class="flex flex-wrap w-full mt-10">
              <div
                class="w-full px-2 py-1 pr-4 rounded-lg desktop:w-1/2 "
              >
                <p
                  class=""
                  style="font-size: 25px"
                  v-html="getPointHint"
                />
              </div>
              <button
                class="flex items-center justify-center w-full mt-10 mb-auto text-center tablet:mt-0 desktop:w-1/2 rounded-xl "
                style="background: #FF7000 0% 0% no-repeat padding-box;padding: 15px 60px; box-shadow: 0px 3px 6px #00000029;border-radius: 25px;z-index:2"
                @click="exchange"
              >
              <span class="inline">{{ $t('redeem.redeem_button') }}</span>
              </button>
            </div>
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
      <div
        id="text-section-1"
        class="flex flex-col justify-center py-20 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl"
      >
        <h3 class="mb-5 text-center">
          {{ $t('redeem.vouchers') }}
        </h3>
        <apo-wait for="vouchers">
          <template #waiting>
            <apo-loading-overlay
              class="my-15"
            />
          </template>
          <div
            v-if="vouchers.length > 0"
            class="block tablet:hidden"
          >
            <carousel
              :pagination-enabled="false"
              :per-page="1.5"
              class="px-5 tablet:hidden"
            >
              <slide
                v-for="voucher in vouchers"
                :key="voucher.id"
              >
                <div class="w-full px-1 py-2 mb-2 rounded-lg tablet:mr-4 tablet:w-1/4">
                  <div
                    class="flex flex-col justify-end px-1 py-2 mb-2 text-black rounded-lg tablet:px-5"
                    style="min-height:140px; background: transparent linear-gradient(245deg, #F9F3D1 0%, #FFB80F 100%) 0% 0% no-repeat padding-box;"
                  >
                    <p
                      class="text-center text-black"
                      style="font-size: 25px"
                    >
                      {{ voucher.voucher_code }} <br>
                    </p>
                    <p class="text-center">
                      {{ $t('pages.redeem.messages.expiresAt', { date: voucher.expires_at }) }}
                    </p>
                    <div class="flex flex-row items-center justify-between pt-5">
                      <div class="w-4 h-4 ml-auto text-white bg-white rounded-full" />
                    </div>
                  </div>
                  <template v-if="voucher.redeemed == '1'">
                    <apo-icon
                      v-if="voucher.redeemed == '1'"
                      class="w-24 fill-current tablet:w-16"
                      style="color: #bebebe"
                      src="check"
                    />
                    <a
                      target="_blank"
                      :href="`${bonagoVoucherUrl}${voucher.voucher_code}`"
                      class="cursor-pointer mt-2 text-sm underline text-gray-900"
                      v-text="$t('general.show')"
                    />
                  </template>
                  <button
                    v-else
                    class="flex items-center justify-center w-full mx-auto mt-0 mt-5 mb-auto text-center text-white rounded-xl "
                    style="background: #FF7000 0% 0% no-repeat padding-box;padding: 15px 100px; box-shadow: 0px 3px 6px #00000029;border-radius: 25px;"
                    @click="onRedeem(voucher)"
                    v-text="$t('pages.redeem.buttons.use')"
                  />
                </div>
              </slide>
            </carousel>
          </div>
          <div
            v-if="vouchers.length > 0"
            class="flex-wrap hidden px-5 tablet:flex tablet:px-0"
          >
            <div
              v-for="voucher in vouchers"
              :key="voucher.id"
              class="desktop:w-1/5 tablet:w-1/3 box-border h-full px-1 py-2 mx-1 mb-4 rounded-lg"
            >
              <div
                class="flex flex-col justify-end h-full px-2 py-2 text-white rounded-lg tablet:px-5"
                :style="voucher.redeemed == '1' ? 'min-height:140px; box-shadow: 0px 0px 10px #00000029; color: #cccccc' : 'min-height:140px; background: transparent linear-gradient(245deg, #F9F3D1 0%, #FFB80F 100%) 0% 0% no-repeat padding-box;'"
              >
                <p
                  class="text-center text-black"
                  style="font-size: 25px"
                >
                  {{ voucher.voucher_code }} <br>
                </p>
                <p class="text-center">
                  {{ $t('pages.redeem.messages.expiresAt', {date: voucher.expires_at}) }}
                </p>
                <div class="flex flex-row items-center justify-between pt-5">
                  <div class="w-4 h-4 ml-auto text-white bg-white rounded-full"/>

                  <template v-if="voucher.redeemed == '1'">
                    <a
                      target="_blank"
                      :href="`${bonagoVoucherUrl}${voucher.voucher_code}`"
                      class="cursor-pointer mt-2 text-sm underline text-yellow-500"
                    >
                      <apo-icon
                        v-if="voucher.redeemed == '1'"
                        class="w-8 fill-current tablet:w-4"
                        src="check"
                      />
                    </a>
                  </template>
                </div>
              </div>
              <button
                v-if="voucher.redeemed !== '1'"
                class="flex items-center justify-center w-full mx-auto mt-0 mt-4 mb-auto text-center text-white rounded-xl "
                style="background: #FF7000 0% 0% no-repeat padding-box;padding: 15px 100px; box-shadow: 0px 3px 6px #00000029;border-radius: 25px;"
                @click="onRedeem(voucher)"
                v-text="$t('pages.redeem.buttons.use')"
              />
            </div>
          </div>
          <div
            v-else
            class="text-center text-xl mt-8 px-4 tablet:px-32"
          >
            {{ $t('pages.redeem.noVouchers') }}
          </div>
        </apo-wait>
      </div>
      <div
        id="text-section"
        class="flex flex-col justify-center py-20 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl"
      >
        <h3 class="mb-5 text-center">
          {{ $t('redeem.most_recent') }}
        </h3>
        <apo-wait for="latestsSurveys">
          <template #waiting>
            <apo-loading-overlay
              class="my-15"
              :message="$t('loaders.surveys')"
            />
          </template>
          <div
            v-if="latestsSurveys.length > 0"
            class="block tablet:hidden"
          >
            <carousel
              :per-page="1.5"
              :pagination-enabled="false"
              class="px-5"
            >
              <slide
                v-for="survey in latestsSurveys"
                :key="survey.id"
              >
                <div class="w-full px-1 py-2 mb-2 rounded-lg tablet:mr-4 tablet:w-1/4">
                  <a
                    :href="'/surveys/' + survey.id"
                    target="_blank"
                    class="flex flex-col justify-end px-2 py-2 mb-2 text-white rounded-lg tablet:px-5"
                    style="min-height:140px; background: transparent linear-gradient(245deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;"
                  >
                    <p class="text-center">
                      {{ survey.title }}
                    </p>
                    <div class="flex flex-row items-center justify-between pt-5">
                      <p class="text-xs">
                        5 Min.
                      </p>
                      <div class="w-4 h-4 bg-white rounded-full" />
                    </div>
                  </a>
                </div>
              </slide>
            </carousel>
          </div>
          <div
            v-if="latestsSurveys.length > 0"
            class="flex-col hidden px-5 tablet:flex-row tablet:px-0 tablet:flex"
          >
            <div
              v-for="survey in latestsSurveys"
              :key="survey.id"
              class="w-full px-1 py-2 mb-2 rounded-lg tablet:mr-4 tablet:w-1/4"
            >
              <a
                :href="'/surveys/' + survey.id"
                target="_blank"
                class="flex flex-col justify-end px-2 py-2 mb-2 text-white rounded-lg tablet:px-5"
                style="min-height:140px; background: transparent linear-gradient(245deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;"
              >
                <p class="text-center">
                  {{ survey.title }}
                </p>
                <div class="flex flex-row items-center justify-between pt-5">
                  <p class="text-xs">
                    5 Min.
                  </p>
                  <div class="w-4 h-4 bg-white rounded-full" />
                </div>
              </a>
            </div>
          </div>
          <div
            v-else
            class="flex justify-center w-full"
            v-text="$t('surveys.messages.noSurveysAvailable')"
          />
          <a
            href="/surveys"
            class="flex items-center justify-center mx-5 mt-10 mb-auto text-center text-white w-fit tablet:mx-auto tablet:w-1/4 rounded-xl "
            style="background: #FF7000 0% 0% no-repeat padding-box;padding: 15px 100px; box-shadow: 0px 3px 6px #00000029;border-radius: 25px;"
            v-text="$t('surveys.all')"
          />
        </apo-wait>
      </div>
      <div v-if="content && contentPosition === 'after'">
        <component
          :is="`apo-cms-${renderer}-renderer`"
          v-for="(components, renderer) in content"
          :key="`${renderer}-renderer`"
          :components="components || []"
        />
      </div>

      <!-- <div v-if="content && contentPosition === 'before'">
        <component
          :is="`apo-cms-${renderer}-renderer`"
          v-for="(components, renderer) in content"
          :key="`${renderer}-renderer`"
          :components="components || []"
        />
      </div> -->
      <!-- <div class="py-24 bg-yellow-100 redeem__vouchers">
        <h2 class="mb-24 text-center">
          {{ $t('pages.redeem.headlines.vouchers') }}
        </h2>
        <apo-wait for="vouchers">
          <template #waiting>
            <apo-loading-overlay
              class="my-15"
              :message="$t('loaders.vouchers')"
            />
          </template>

          <template v-if="vouchers.length > 0">
            <apo-redeem-voucher-list
              :items="assignedVouchers"
            />
            <apo-redeem-voucher-list
              :items="redeemedVouchers"
            />
          </template>

          <div
            v-else
            class="container max-w-4xl mx-auto text-6xl leading-none tracking-wide text-center text-gray-800 font-display"
            v-text="$t('pages.redeem.messages.noVouchersAvailable')"
          />
        </apo-wait>
      </div> -->
      <!-- <apo-redeem-survey-teaser /> -->
      <!-- <div v-if="content && contentPosition === 'after'">
        <component
          :is="`apo-cms-${renderer}-renderer`"
          v-for="(components, renderer) in content"
          :key="`${renderer}-renderer`"
          :components="components || []"
        />
      </div> -->
    </div>
  </apo-restrict-content-wrapper>
</template>

<script>
import {mapGetters, mapActions, mapState} from 'vuex';
import {
  VOUCHERS_FETCH_ALL, VOUCHERS_EXCHANGE_POINTS, VOUCHERS_REDEEM_VOUCHER, LATESTS_SURVEYS,
} from '@/store/types/action-types';
import themeSettings from '@/mixins/theme-settings';
import { canonicalTag } from '@/services/utils';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import RedeemNotification from '@/components/redeem/RedeemNotification.vue';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

export default {

  components: {
    'apo-loading-overlay': LoadingOverlay,
    'apo-redeem-notification': RedeemNotification,
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  mixins: [
    themeSettings('redeem'),
  ],
  data() {
    return {
      showAchTooltip: false,
    };
  },
  head() {
    return {
      title: {
        inner: this.$t('pages.redeem.meta.title'),
      },
      link: [
        canonicalTag(this.$route),
      ],
    };
  },

  computed: {
    ...mapGetters(['latestsSurveys', 'surveyById', 'expertPoints', 'language']),
    ...mapGetters(['user', 'profilePicture']),
    ...mapGetters(['vouchers', 'assignedVouchers', 'redeemedVouchers', 'bonagoVoucherUrl']),
    
    ...mapState({
      settings: state => state.settings.settings,
    }),
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

    isiOSSafari() {
      return /iPhone|iPad|iPod/i.test(window.navigator.userAgent);
    },

    getPointHint() {
      if (!this.settings.showVoucher.is_available) {
        return this.$t(this.settings.showVoucher.message);
      }
      if (this.expertPoints < 50) {
        return this.$t('pages.redeem.hint.hasNotEnoughPoints', { points: parseInt(50 - this.expertPoints, 10) });
      }
      return this.$t('pages.redeem.hint.hasEnoughPoints');
    }
  },

  methods: {
    ...mapActions([VOUCHERS_FETCH_ALL]),
    ...mapActions([VOUCHERS_EXCHANGE_POINTS]),
    ...mapActions([LATESTS_SURVEYS]),

    showTooltipAchievements() {
      this.showAchTooltip = !this.showAchTooltip;
    },
    exchange() {
      this.isBusy = true;
      this[VOUCHERS_EXCHANGE_POINTS]()
        .finally(() => {
          this.isBusy = false;
        });
    },
    ...mapActions([VOUCHERS_REDEEM_VOUCHER]),

    onRedeem(item) {
      this.isBusy = true;

      let windowReference = null;

      if (this.isiOSSafari) {
        windowReference = window.open();
      }

      this[VOUCHERS_REDEEM_VOUCHER](item)
        .then(voucher => {
          if (this.isiOSSafari) {
            windowReference.location = voucher.bonago_url;
          } else {
            window.open(voucher.bonago_url, '_blank');
          }
        })
        .catch(error => {
          if (this.isiOSSafari) {
            windowReference.close();
          }
          console.log('error on redeeming this voucher', error);
        })
        .finally(() => {
          this.isBusy = false;
        });
    },
  },

  created() {
    this[VOUCHERS_FETCH_ALL]();
    this[LATESTS_SURVEYS]().catch(error => {
      console.log('error retrieving the surveys', error);
    });
  },
};

</script>

<style >
#welcome-section-4 {
 background-image: linear-gradient(to right, #fc7021, #fd821f, #fe921f, #fea223, #fdb22b);
    column-gap: 150px;
}
.leading-3{
  line-height: 3.675rem !important;
}

@media (min-width: 767px) {
  .responsive-image{
   top: 20%;
   right:0%;
   height: 50%;
   transform: scale(1.7);
  } 
 
}

</style>
