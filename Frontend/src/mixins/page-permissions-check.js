import { mapGetters } from 'vuex';
import { PAGES_UPDATE_PAGE_PERMISSIONS } from '@/store/types/mutation-types';

export default () => ({

  data() {
    return {
      hasPagePermissions: false,
    };
  },

  computed: {
    ...mapGetters(['user', 'pagePermissions']),
  },

  methods: {
    checkPagePermissions() {
      if (
        this.$route.meta.requirePagePermissonCheck
        || this.$route.meta.inheritPagePermissionCheckFrom
      ) {
        if (this.pagePermissions.length === 0) {
          this.$store.subscribe(mutation => {
            if (mutation.type === PAGES_UPDATE_PAGE_PERMISSIONS) {
              this.assignPagePermissions();
            }
          });
        } else {
          this.assignPagePermissions();
        }
      } else {
        this.hasPagePermissions = true;
      }
    },

    assignPagePermissions() {
      this.hasPagePermissions = this.user.roles.includes('administrator') || this.validateCurrentPagePermissions();
    },

    validateCurrentPagePermissions() {
      const currentPagePermission = this.findCurrentPagePermission();

      if (currentPagePermission && Array.isArray(currentPagePermission.permissons)) {
        return this.user.roles.some(role => currentPagePermission.permissons.indexOf(role) !== -1);
      }
      return !currentPagePermission
      || currentPagePermission.permissons === 'NO_RESTRICTION'
      || currentPagePermission.permissons === null;
    },

    getTemplateSlugFromRoute() {
      return this.$route.meta.inheritPagePermissionCheckFrom
        ? this.$route.meta.inheritPagePermissionCheckFrom : [this.$route.name];
    },

    findCurrentPagePermission() {
      const templateSlugs = this.getTemplateSlugFromRoute();

      return this.pagePermissions
        .find(permission => templateSlugs.includes(permission.template));
    },

  },

  created() {
    this.checkPagePermissions();
  },
});
