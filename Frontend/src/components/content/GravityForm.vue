<template>
  <div class="container gravity-form">
    <apo-form-renderer
      v-if="form"
      v-bind="form"
      class="container"
    />
  </div>
</template>

<script>
import { mapState } from 'vuex';
import FormRenderer from '@/components/form-renderer/FormRenderer.vue';
import { FORMS_FETCH_FORM } from '@/store/types/action-types';

export default {
  name: 'GravityForm',

  components: {
    'apo-form-renderer': FormRenderer,
  },

  props: {
    gravity_form_id: {
      type: String,
      required: true,
    },
  },

  computed: {
    ...mapState({
      form(state) {
        return state.forms.forms.find(form => form.id === this.gravity_form_id);
      },
    }),
  },

  created() {
    this.$store.dispatch(FORMS_FETCH_FORM, this.gravity_form_id);
  },
};

</script>
