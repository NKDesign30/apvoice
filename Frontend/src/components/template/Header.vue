<template>
  <header
    role="banner"
    class="header"
  >
    <div
      v-if="showNewsletterNote === true"
    >
      <div class="fixed inset-0 z-10 flex items-center justify-center newsletterWrapper">
        <apo-wait
          class="flex justify-center px-2"
          for="settings"
        >
          <div class="w-full rounded-lg shadow-lg newsletterPopover desktop:w-1/2">
            <div class="flex justify-end">
              <div
                class="p-4 cursor-pointer"
                @click="hideNewsletterNote"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  height="24px"
                  viewBox="0 0 24 24"
                  width="24px"
                  fill="currentcolor"
                ><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" /></svg>
              </div>
            </div>
            <div
              class="px-12"
              v-html="settings.newsletterPopover"
            />
            <form @submit.prevent="submit()">
              <label class="flex items-baseline px-12 mt-2 mb-2 checkbox">
                <input
                  type="checkbox"
                  required
                  class="mr-3"
                >
                <span v-html="settings.newsletterPrivacy" />
              </label>
              <div class="flex flex-col items-center justify-center p-6">
                <apo-button
                  class="mb-4 text-red-300 shadow-hard-dark"
                  :class="`button--secondary`"
                  type="submit"
                  v-text="$t('newsletter.subscribe')"
                />
                <div
                  class="hidden my-4 text-sm underline cursor-pointer opacity-80"
                  @click="hideNewsletterNote"
                  v-text="$t('newsletter.decline')"
                />
              </div>
            </form>
          </div>
        </apo-wait>
      </div>
    </div>


    <div
      v-if="!isAuthenticated"
      class="inline-flex desktop:flex w-full items-center"
    >
      <div class="inline-block text-center w-1/3 text-white mr-7 py-5 mt-6">
        <router-link
          class="block"
          to="/downloads"
          title="Downloads"
        >
          <span
            class=" desktop:inline"
            v-text="$t('template.navigation.downloads')"
          />
        </router-link>
      </div>
      
      <div class="flex w-1/3 justify-center">
        <img
          class="h-auto max-w-full"
          style="margin-top: 20px;"
          src="@/assets/img/template/logo.png"
          :alt="$t('template.navigation.logo.alt')"
        >
      </div>
      <div class="inline-block w-1/3" />
    </div>


    
    <div class="container flex max-w-7xl desktop:px-5" v-if="isAuthenticated">
      <div class="w-0 desktop:w-3/12 z-10 desktop:p-10 desktop:pr-0 pt-0" >
        <apo-desktop-navigation />
      </div>
      <div
        v-if="isAuthenticated"
        class="flex items-center justify-center w-2/3 desktop:w-1/2 desktop:mr-0 desktop:ml-0"
      >
        <router-link
          class="block"
          to="/"
          title="Home page"
        >
          <img
            class="h-auto max-w-full mt-4 desktop:mr-20 ml-17 tablet:ml-48"
            src="@/assets/img/template/logo.png"
            :alt="$t('template.navigation.logo.alt')"
            style="max-height:100px"
          >
        </router-link>
      </div>



      <div
        v-if="!isAuthenticated"
        class="flex items-center justify-center w-1/2"
      >
        <router-link
          class="block"
          to="/"
          title="Home page"
        >
          <img
            class="h-auto max-w-full"
            src="@/assets/img/template/logo.png"
            :alt="$t('template.navigation.logo.alt')"
            style="min-height: 30px;"
          >
        </router-link>
      </div>



      <div class="w-1/3 dekstop:w-1/2 desktop:justify-center mr-0 desktop:p-10 flex justify-end ml-12 py-4 mr-5 items-justify mt-4 desktop:mt-0" id="customleftbar">
        <router-link
          v-if="isAuthenticated"
          class="flex-col items-center justify-center hidden text-white desktop:inline-flex desktop:ml-8"
          :to="{ name: 'profile' }"
        >
          <span
            class="hidden desktop:inline"
            v-text="$t('template.navigation.profile')"
          />
        </router-link>

        <button
          v-if="isAuthenticated"
          class="flex-col items-center justify-center hidden text-white desktop:inline-flex desktop:ml-8"
          @click="logout"
        >
          <span
            class="inline"
            v-text="$t('template.navigation.logout')"
          />
        </button>
        <apo-mobile-navigation />
      </div>
    </div>
  </header>
</template>

<script>

import { mapGetters, mapState } from 'vuex';
import DesktopNavigation from '@/components/template/DesktopNavigation.vue';
import MobileNavigation from '@/components/template/MobileNavigation.vue';
import { AUTH_LOGOUT } from '@/store/types/action-types';

export default {
  components: {
    'apo-desktop-navigation': DesktopNavigation,
    'apo-mobile-navigation': MobileNavigation,
  },

  data: () => ({
    showNewsletterNote: false,
  }),

  computed: {
    ...mapState({
      settings: state => state.settings.settings,
    }),
    ...mapGetters(['isAuthenticated', 'userId', 'user']),
  },

  watch: {
    user: {
      immediate: true,
      handler() {
        this.toggleNewsletterPopover();
      },
    },

    settings: {
      immediate: true,
      handler() {
        this.toggleNewsletterPopover();
      },
    },
    currentRouteName() {
         if(this.$route.name=="/"){
          return(true)
         }else{
          return(false);
         }
    }
  },

  methods: {
    submit() {
      sessionStorage.setItem('newsletterState', true);
      window.axios.get('/wp-json/apovoice/v1/users/acceptNewsletter');
      this.showNewsletterNote = false;
    },

    toggleNewsletterPopover() {
      if (this.settings.newsletterPopover !== '' && this.isAuthenticated && this.userId > 0) {
        let state = sessionStorage.getItem('newsletterState');
        if (state === null && this.user.newsletterState !== true) {
          state = false;
        } else {
          state = true;
        }

        new Promise(r => setTimeout(r, 5000)).then(() => {
          this.showNewsletterNote = !state;
        });
      }
    },

    hideNewsletterNote() {
      sessionStorage.setItem('newsletterState', false);
      this.showNewsletterNote = false;
    },

    logout() {
      this.$store.dispatch(AUTH_LOGOUT);
    },
   carouselgap(){
     return(document.querySelectorAll('.VueCarousel-slide'));
   },
   removegap(){
     setInterval(()=>{
      let items=this.carouselgap();
      items.forEach((item)=>{
        item.getElementsByClassName.flexBasis="0 !important;";
      })
     },1000)
   }
  },
   mounted() {
   // this.removegap();
  },
};

</script>

<style lang="scss">
.newsletterWrapper{
  background-color: rgba(0,0,0,0.2);

  .newsletterPopover{
    background: rgb(228,14,14);
    background: linear-gradient(138deg, rgba(248, 7, 77, 0.96) 0%, rgba(251, 157, 150, 0.96) 100%);
    color: #fff;
  }
}
.desktop\:pr-10 {
    padding-right: 2.5rem;
    padding-top: 0.5rem;
}


 @media (min-width: 1024px){
    header{
 padding-bottom: 100px !important;
    }
  }
 
.header {
  @apply py-5;
  @apply border-b-2;
  @apply border-white;
  @screen tablet {
    @apply py-11;
  } 
  padding-top:0 !important;
  max-height: 122px;
  background: linear-gradient(120deg, theme('colors.blue.700'), theme('colors.blue.500'));

  .theme-survey & {
    background-image: linear-gradient(to right, #fb7222, #fd8320, #fe9321, #fea324, #feb22b);
  }

  .theme-training & {
background-image: linear-gradient(to right, #2ca6f9, #4ab5f7, #69c2f4, #87cff2, #a6dbf0);
  }
  
  .theme-welcome & {
 background-image: linear-gradient(to right, #0243b9, #0058ca, #006cda, #0080e8, #1894f6);

  }
   .theme-profile & {
 background-image: linear-gradient(to right, #0243b9, #0058ca, #006cda, #0080e8, #1894f6);
  }
  
   .theme-redeem & {
  background-image: linear-gradient(to right, #fc7021, #fd821f, #fe921f, #fea223, #fdb22b);
  }


  .theme-scientific & {
    // Note, @rudston: here I followed the new design instead of the previous conventions
    background: linear-gradient(233deg, #9BD442 0%, #00B041 100%) 0% 0% no-repeat padding-box;
  }

  .theme-knowledge-base &,
  .theme-downloads & {
    background: linear-gradient(120deg, theme('colors.purple.500'), theme('colors.purple.300'));
  }

  .theme-raffle & {
    background: linear-gradient(120deg, theme('colors.green.600'), theme('colors.green.400'));
  }
}
.ptt{
  padding-top: 20px;
}
 

</style>

