import Vue from "vue";
import Vuex from "vuex";
import auth from "@/store/modules/auth";
import pages from "@/store/modules/pages";
import pharmacies from "@/store/modules/pharmacies";
import settings from "@/store/modules/settings";
import trainings from "@/store/modules/trainings";
import taxonomies from "@/store/modules/taxonomies";
import surveys from "@/store/modules/surveys";
import detailersJob from "@/store/modules/detailers-job";
import downloads from "@/store/modules/downloads";
import knowledgeBase from "@/store/modules/knowledge-base";
import raffle from "@/store/modules/raffle";
import forms from "@/store/modules/forms";
import filter from "@/store/modules/filter";
import category from "@/store/modules/category";
import pun from "@/store/modules/pun";

// eslint-disable-next-line import/no-cycle
import vouchers from "@/store/modules/vouchers";
import salesRep from "@/store/modules/sales-rep";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    auth,
    pages,
    pharmacies,
    settings,
    trainings,
    taxonomies,
    surveys,
    detailersJob,
    downloads,
    knowledgeBase,
    raffle,
    forms,
    vouchers,
    salesRep,
    filter,
    category,
    pun
  },

  state: {},
  mutations: {},
  actions: {}
});
