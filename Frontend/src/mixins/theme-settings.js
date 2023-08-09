import { SETTINGS_SET_THEME } from '@/store/types/action-types';

export default theme => ({
  mounted() {
    this.$store.dispatch(SETTINGS_SET_THEME, theme);
  },
});
