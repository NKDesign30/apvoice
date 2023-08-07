<template>
  <div v-on-clickaway="onClickAway" class="relative w-11/12 mx-auto tablet:w-full">
    <apo-input-label
      for="pharmacy-fuzzy-serach"
      class="mb-4"
      v-text="$t('general.pharmacySearch')"
    />
    <apo-text-input
      id="pharmacy-fuzzy-serach"
      v-model="term"
      :placeholder="$t('general.fuzzySearch.placeholder')"
      @input="search"
    >
      <template #after>
        <div class="absolute right-0 mr-8">
          <apo-spinner v-if="isBusy" size="small" />
        </div>
      </template>
    </apo-text-input>
    <ul
      v-if="pharmacies.length > 0 || noResults"
      class="absolute z-50 w-full mt-1 overflow-auto bg-white border-2 shadow-2xl fuzzy-search-results"
    >
      <li v-if="noResults" class="px-4 py-3 border-b-2 tablet:px-3" tabindex="0">
        {{ $t("general.noResults") }}
      </li>
      <li
        v-for="(pharmacy, index) in pharmacies"
        :key="`pharmacy-result-${index}`"
        class="px-4 py-3 border-b-2 cursor-pointer tablet:px-3 hover:bg-blue-100"
        tabindex="0"
        @click="select(pharmacy)"
        @keydown.enter="select(pharmacy)"
      >
        {{ pharmacy }}
      </li>
    </ul>
    <slot />
  </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import InputLabel from "@/components/form-renderer/InputLabel.vue";
import TextInput from "@/components/form-renderer/TextInput.vue";
import FuzzySearchService from "@/services/api/FuzzySearchService";
import { mapState, mapGetters } from "vuex";
import UserService from "@/services/api/UserService";
export default {
  name: "PharmaciesFuzzySearch",

  components: {
    "apo-input-label": InputLabel,
    "apo-text-input": TextInput
  },

  mixins: [clickaway],

  data() {
    return {
      isBusy: false,
      term: null,
      debounceTimer: null,
      pharmacies: [],
      noResults: false
    };
  },
  computed: {
    ...mapGetters(["language"])
  },
  methods: {
    language() {
      return this.language;
    },

    search() {
      this.noResults = false;

      clearTimeout(this.debounceTimer);
      this.debounceTimer = setTimeout(() => {
        if (this.search) {
          if (window.fuzzySearchCancelToken) {
            window.fuzzySearchCancelToken.cancel();
          }
          // set busy state in next tick to handle canceld requests
          setTimeout(() => {
            this.isBusy = true;
          }, 0);
          FuzzySearchService.fetch(decodeURIComponent(this.term))
            .then(({ results }) => {
              this.noResults = results.length === 0;
              this.pharmacies = results;
            })
            .catch(console.error)
            .finally(() => {
              this.isBusy = false;
            });
        }
      }, 150);
    },

    select(pharmacy) {
      this.reset();
      this.term = pharmacy;
      console.log(this.extractFromString(pharmacy));
      this.$emit("selected", this.extractFromString(pharmacy));
    },

    extractFromString(pharmacy) {
      let result = null;
      try {
        const [name, streetWithNumber, zip, city] = pharmacy.split(",").map(row => row.trim());
        const match = streetWithNumber.match(/\d/);
        const street = streetWithNumber.substr(0, match.index).trim();
        const number = streetWithNumber.substr(match.index).trim();

        result = {
          name,
          street,
          number,
          zip,
          city
        };
      } catch (error) {
        console.error(error);
      }

      return result;
    },

    onClickAway() {
      this.reset();
    },

    reset() {
      this.isBusy = false;
      this.term = null;
      this.pharmacies = [];
      this.noResults = false;
    }
  }
};
</script>

<style lang="scss" scoped>
.fuzzy-search-results {
  max-height: 18rem;
}
</style>
