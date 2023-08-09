import Vue from 'vue';
import Router from 'vue-router';
import VueCarousel from 'vue-carousel';
import CmsContainer from '@/views/CmsContainer.vue';
import Login from '@/views/NewLoginPage.vue';
import UserActivation from '@/views/UserActivation.vue';
import ConfirmEmail from '@/views/ConfirmEmail.vue';
import Registration from '@/views/Registration.vue';
import ThankYou from '@/views/ThankYou.vue';
import ForgotPassword from '@/views/ForgotPassword.vue';
import ResetPassword from '@/views/ResetPassword.vue';
import Request from '@/views/Request.vue';
import Contact from '@/views/Contact.vue';
import ContactThankYou from '@/views/ContactThankYou.vue';
import Profile from '@/views/user/Profile.vue';
import EditProfile from '@/views/user/EditProfile.vue';
import Surveys from '@/views/Surveys.vue';
import Trainings from '@/views/Trainings.vue';
import TrainingsScientific from '@/views/TrainingsScientific.vue';
import TrainingSummary from '@/views/TrainingSummary.vue';
import TrainingSuccessPage from '@/views/TrainingSuccessPage.vue';
import Welcome from '@/views/Welcome.vue';
import DetailersJob from '@/views/detailers-job/DetailersJob.vue';
import Downloads from '@/views/Downloads.vue';
import KnowledgeBase from '@/views/KnowledgeBase.vue';
import Raffle from '@/views/Raffle.vue';
import InformationalTraining from '@/views/detailers-job/InformationalTraining.vue';
import Redeem from '@/views/Redeem.vue';
import Invite from '@/views/Invite.vue';
import localStore from '@/local-store';

import bus from '@/bus'

Vue.use(VueCarousel);
Vue.use(Router);

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: {
        theme: 'default',
      },
    },
    {
      path: '/welcome',
      name: 'welcome',
      component: Welcome,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: '/activation/:key',
      name: 'activation',
      component: UserActivation,
      meta: {
        theme: 'default',
      },
    },
    {
      path: '/confirmemail/:key',
      name: 'confirmemail',
      component: ConfirmEmail,
      meta: {
        theme: 'default',
      },
    },
    {
      path: '/registration',
      name: 'registration',
      component: Registration,
      meta: {
        theme: 'default',
      },
    },
    {
      path: '/thank-you',
      name: 'thankyou',
      component: ThankYou,
      meta: {
        theme: 'default',
      },
    },
    {
      path: '/forgot-password',
      name: 'forgotten',
      component: ForgotPassword,
      meta: {
        theme: 'default',
      },
    },
    {
      path: '/reset/:key',
      name: 'reset',
      component: ResetPassword,
      meta: {
        theme: 'default',
      },
    },
    {
      path: '/contact',
      name: 'contact',
      component: Contact,
      meta: {
        theme: 'default',
      },
    },
    {
      path: '/request',
      name: 'request',
      component: Request,
      meta: {
        theme: 'default',
      },
    },
    {
      path: '/contact/thank-you',
      name: 'contact.thank-you',
      component: ContactThankYou,
      meta: {
        theme: 'default',
      },
    },
    {
      path: '/profile',
      name: 'profile',
      component: Profile,
      meta: {
        requiresAuth: true,
        theme: 'default',
      },
    },
    {
      path: '/profile/edit',
      name: 'profile.edit',
      component: EditProfile,
      meta: {
        requiresAuth: true,
        theme: 'default',
      },
    },
    {
      path: '/surveys/:id?',
      name: 'surveys',
      component: Surveys,
      meta: {
        requiresAuth: true,
        requirePagePermissonCheck: true,
      },
    },
    {
      path: '/scientific/:series_slug?/:training_slug?/:lesson_id?',
      name: 'scientific',
      component: TrainingsScientific,
      meta: {
        requiresAuth: true,
        requirePagePermissonCheck: true,
      },
    },
    {
      path: '/scientific/:series_slug/:training_slug?/:lesson_id?',
      name: 'scientific-group',
      component: TrainingsScientific,
      meta: {
        requiresAuth: true,
        requirePagePermissonCheck: true,
      },
    },
    {
      path: '/trainings/:series_slug?/:training_slug?/:lesson_id?',
      name: 'trainings',
      component: Trainings,
      meta: {
        requiresAuth: true,
        requirePagePermissonCheck: true,
      },
    },
    {
      path: '/trainings/filter/:type/:category',
      name: 'training',
      component: Trainings,
      meta: {
        requiresAuth: true,
        requirePagePermissonCheck: true,
      },
    },
    {
      path: '/:slug-summary/:id?',
      name: 'training-summary',
      component: TrainingSummary,
      meta: {
        requiresAuth: true,
      },
      props: true
    },
    {
      path: '/:slug-success/:series_id?/:id?/:lesson_id?',
      name: 'training-success-page',
      component: TrainingSuccessPage,
      meta: {
        requiresAuth: true,
      },
      props: true
    },
    {
      path: '/detailers-job',
      name: 'detailersJob.index',
      component: DetailersJob,
      meta: {
        requiresAuth: true,
        theme: 'default',
      },
    },
    {
      path: '/detailers-job/training/:informationalTrainingId/:pharmacyId/:lastQuestionId?',
      name: 'detailersJob.informationalTraining',
      component: InformationalTraining,
      meta: {
        requiresAuth: true,
        theme: 'default',
      },
    },
    {
      path: '/downloads/:id?',
      name: 'downloads',
      component: Downloads,
      meta: {
        theme: 'downloads',
      },
    },
    {
      path: '/knowledge-base/:id?',
      name: 'knowledgeBase',
      component: KnowledgeBase,
      meta: {
        requiresAuth: true,
        theme: 'knowledge-base',
      },
    },
    {
      path: '/raffles/:slug?',
      name: 'raffles',
      component: Raffle,
      meta: {
        requiresAuth: true,
        theme: 'raffle',
      },
    },
    {
      path: '/redeem',
      name: 'redeem',
      component: Redeem,
      meta: {
        requiresAuth: true,
        theme: 'surveys',
        inheritPagePermissionCheckFrom: ['surveys'],
      },
    },
    {
      path: '/invite',
      name: 'invite',
      component: Invite,
      meta: {
        requiresAuth: true,
        theme: 'default',
      },
    },
    {
      path: '*',
      name: 'cms-container',
      component: CmsContainer,
    },
  ],
});

router.beforeEach((to, from, next) => {
  if(from.name && to.name && from.name.includes('scientific')
    && from.path.includes('/scientific')
    && !to.name.includes('scientific')
    && !to.name.includes('training-success-page')
    && !to.name.includes('training-summary')
  ) {
    // leaving a scientific page
    localStore.commit('saveEnterScientificModalState', true)
    bus.$emit('routeLeaveScientific', to)
    return
  }
  next()
})




export default router
