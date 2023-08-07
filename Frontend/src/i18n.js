import Vue from 'vue';
import VueI18n from 'vue-i18n';
import at from '@/i18n/at';
import de from '@/i18n/de';
import en from '@/i18n/en';
import es from '@/i18n/es';
// eslint-disable-next-line import/no-cycle
import store from '@/store';

Vue.use(VueI18n);

export default new VueI18n({
  locale: store.state.settings.language,
  messages: {
    at,
    de,
    en,
    es,
  },
});
