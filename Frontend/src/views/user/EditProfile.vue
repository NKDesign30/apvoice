<template>
  <!--eslint-disable max-len -->
  <apo-wait for="auth.user">
    <template #waiting>
      <apo-loading-overlay
        class="my-15"
        :message="$t('loaders.profile')"
      />
    </template>

    <div class="mb-16 edit-profile">
      <div class="container">
        <div class="flex flex-col items-center mt-16">
          <apo-profile-picture
            image-class="w-32 h-32"
            is-editable
            :user="user"
            @input="onInput"
          />

          <div class="flex flex-col justify-center w-full px-8 mt-12 tablet:px-0 tablet:flex-row">
            <div class="tablet:mr-4 tablet:w-5/12">
              <apo-input-label v-text="$t('pages.editProfile.general.form.formOfAddress.label')" />

              <apo-radio-button-group
                v-model="form.formOfAddress"
                class="flex justify-between mt-2 tablet:flex-col desktop:flex-row tablet:justify-start"
              >
                <apo-radio-button
                  id="form-of-address-mrs"
                  :label="$t('pages.editProfile.general.form.formOfAddress.mrs')"
                  value="mrs"
                />

                <apo-radio-button
                  id="form-of-address-mr"
                  class="desktop:ml-16 tablet:mt-4 desktop:mt-0"
                  :label="$t('pages.editProfile.general.form.formOfAddress.mr')"
                  value="mr"
                />
              </apo-radio-button-group>
            </div>

            <div class="mt-8 tablet:mt-0 tablet:ml-4 tablet:w-5/12">
              <apo-input-label v-text="$t('pages.editProfile.general.form.title')" />

              <apo-select
                v-model="form.title"
                class="mt-2"
              >
                <option value="dr.med.dent.">
                  Dr. med. Dent.
                </option>
                <option value="dr.dr.">
                  Dr. Dr.
                </option>
              </apo-select>
            </div>
          </div>

          <div class="w-full px-8 mt-12 tablet:px-0 tablet:flex tablet:justify-center">
            <div class="w-full tablet:mr-4 tablet:w-5/12">
              <apo-input-label v-text="$t('pages.editProfile.general.form.firstname')" />

              <apo-input
                v-model="form.firstName"
                class="mt-2"
                @keydown.enter="submit"
              />

              <apo-input-error
                :errors="errors"
                field="first_name"
              />
            </div>
            <div class="w-full mt-8 tablet:mt-0 tablet:ml-4 tablet:w-5/12">
              <apo-input-label v-text="$t('pages.editProfile.general.form.surname')" />

              <apo-input
                v-model="form.lastName"
                class="mt-2"
                @keydown.enter="submit"
              />

              <apo-input-error
                :errors="errors"
                field="last_name"
              />
            </div>
          </div>

          <div
            class="w-full px-8 mt-12 tablet:px-12 desktop:px-0 tablet:flex tablet:justify-center tablet:flex-wrap desktop:flex-no-wrap"
          >
            <div class="w-full desktop:mr-4 desktop:w-5/12">
              <apo-input-label v-text="$t('pages.editProfile.general.form.job')" />

              <apo-select
                v-model="form.job"
                class="mt-2"
              >
                <option
                  v-for="(job, index) in languageSpecificJobs"
                  :key="index"
                  :value="job"
                  v-text="$t(`data.profile.job.${job}`)"
                />
              </apo-select>

              <apo-input-error
                :errors="errors"
                field="job"
              />
            </div>

            <div
              class="mt-8 desktop:mt-0 desktop:ml-4 tablet:pr-2 desktop:pr-0 tablet:w-6/12 desktop:w-3/12"
            >
              <apo-input-label v-text="$t('pages.editProfile.general.form.workingSince')" />

              <apo-input
                v-model="form.workingSince"
                class="mt-2"
                type="number"
                @keydown.enter="submit"
              />

              <apo-input-error
                :errors="errors"
                field="working_since"
              />
            </div>
            <div
              class="mt-8 desktop:mt-0 desktop:ml-2 tablet:pl-2 desktop:pl-0 tablet:w-6/12 desktop:w-2/12"
            >
              <apo-input-label v-text="$t('pages.editProfile.general.form.age')" />

              <apo-select
                v-model="form.age"
                class="mt-2"
              >
                <option
                  v-for="(age, index) in ages"
                  :key="index"
                  :value="age"
                  v-text="age"
                />
              </apo-select>

              <apo-input-error
                :errors="errors"
                field="age"
              />
            </div>
          </div>

          <div class="w-10/12 mx-auto mt-16">
            <a
              id="tasks-and-priorities"
              class="anchor"
            />
            <h1
              class="my-2 text-3xl text-center tablet:text-5xl desktop:text-6xl"
              v-text="$t('pages.editProfile.tasksAndPriorities.headline')"
            />
            <div
              class="text-center"
              v-text="$t('pages.editProfile.tasksAndPriorities.hint')"
            />
          </div>

          <div class="w-10/12 mx-auto mt-12 tablet:mx-0 tablet:flex tablet:justify-between">
            <div class="w-full mt-12 tablet:mt-0 tablet:w-1/2 desktop:w-1/2">
              <div
                class="mb-10 font-bold"
                v-text="$t('pages.editProfile.tasks.headline')"
              />
              <div
                v-for="taskValue in tasks"
                :key="`task-${taskValue}`"
                class="mt-4"
              >
                <apo-checkbox
                  :id="`task-${taskValue}`"
                  v-model="form.tasks"
                  :name="taskValue"
                  :label="$t(`data.profile.task.${taskValue}`)"
                  :value="taskValue"
                />
              </div>
            </div>
            <div class="w-full tablet:w-1/2 desktop:w-1/3">
              <div
                class="mb-10 font-bold"
                v-text="$t('pages.editProfile.priorities.headline')"
              />
              <div
                v-for="priorityValue in priorities"
                :key="`priority-${priorityValue}`"
                class="mt-4"
              >
                <apo-checkbox
                  :id="`priority-${priorityValue}`"
                  v-model="form.priorities"
                  :name="priorityValue"
                  :label="$t(`data.profile.priority.${priorityValue}`)"
                  :value="priorityValue"
                />

                <apo-input
                  v-if="
                    `priority-${priorityValue}` === 'priority-others' &&
                      form.priorities.indexOf('others') !== -1
                  "
                  id="priority-others-custom"
                  v-model="form.otherPriorities"
                  class="w-full mt-4 tablet:mr-8 tablet:w-auto"
                  type="text"
                  @keydown.enter="submit"
                />
              </div>

              <apo-input-error
                :errors="errors"
                field="other_priorities"
              />

              <apo-input-error
                :errors="errors"
                field="priorities"
              />
            </div>
          </div>

          <div class="w-10/12 mx-auto mt-16">
            <a
              id="your-pharmacy"
              class="anchor"
            />
            <h1
              class="my-2 text-3xl text-center tablet:text-5xl desktop:text-6xl"
              v-text="$tc('pages.editProfile.pharmacies.yourPharmacy', form.pharmacies.length)"
            />


            <div>
              <div class="px-4 mb-8">
                <apo-input-label
                  v-if="language !='de'"
                  for="pharmacy-pun"
                  class="mb-4"
                  v-text="$t('modules.pharmacySummary.form.punCode')"
                />
                <apo-input
                  v-if="language !='de'"
                  id="pharmacy-pun"
                  v-model="myPun"
                  :placeholder="$t('modules.pharmacySummary.form.punCode')"
                  @input="update"
                />
                <div
                  v-if="errorPun.length"
                  style="color:red"
                >
                  {{ errorPun }}
                </div>
                <div
                  v-if="sucessPun.length"
                  style="color:green"
                >
                  {{ sucessPun }}
                </div>

                <apo-input-label
                  v-if="language !='de'"
                  for="pharmacy-name"
                  class="mb-4"
                  v-text="$t('modules.pharmacySummary.form.pharmacyName')"
                />
                <apo-input
                  v-if="language !='de'"
                  id="pharmacy-name"
                  v-model="PharmacyName"
                  :placeholder="$t('modules.pharmacySummary.form.pharmacyName')"
                  class="mt-2 readonly"
                />
                <div
                  v-if="language !='de'"
                  class="flex m-12 button-positioning justify-center"
                >
                  <apo-button
                    class="ml-4 submit-button button button--primary button--small"
                    :class="{ 'is-busy cursor-wait': isPUNBusy }"
                    :disabled="isPUNBusy"
                    @click.native="submitPUNCode"
                  >
                    <apo-spinner
                      v-if="isPUNBusy"
                      class="mr-4"
                      size="small"
                    />
                    <span v-text="$t('general.savePUNCode')" />
                  </apo-button>
                </div>
                <apo-pharmacies-fuzzy-search

                  @selected="onSelectPharmacy"
                >
                  <div class="flex flex-col mt-2 tablet:flex-row">
                    <span
                      class="text-gray-900 tablet:mr-2"
                    >{{ $t("general.lookingForPharmacy") }}
                    </span>
                    <router-link
                      :to="{ name: 'contact' }"
                      class="text-gray-800 underline"
                    >
                      {{ $t("general.getInTouch") }}
                    </router-link>
                  </div>
                  <div
                    class="w-full mt-4"
                    v-html="$t('general.fuzzySearch.hint')"
                  />
                </apo-pharmacies-fuzzy-search>
              </div>
              <apo-add-pharmacy-form

                :form="pharmacyForm"
                read-only
              />
            </div>

            <apo-pharmacy-summary v-model="form.pharmacies" />
          </div>
        </div>

        <div class="w-10/12 mx-auto mt-16">
          <a
            id="your-account"
            class="anchor"
          />
          <h1
            class="my-2 text-3xl text-center tablet:text-5xl desktop:text-6xl"
            v-text="$t('pages.editProfile.account.headline')"
          />
        </div>

        <div class="w-10/12 mx-auto mt-12">
          <div class="tablet:mr-4 tablet:w-1/2">
            <apo-input-label v-text="$t('general.emailAddress')" />

            <apo-input
              v-model="form.account.email"
              class="mt-2 readonly"
              readonly
              @keydown.enter="submit"
            />

            <apo-input-error
              :errors="errors"
              field="account_email"
            />
          </div>
        </div>

        <div class="w-10/12 mx-auto mt-8 tablet:mt-12 tablet:flex tablet:justify-center">
          <div class="tablet:mr-4 tablet:w-1/2">
            <apo-input-label v-text="$t('pages.editProfile.account.newEmailAddress')" />

            <apo-input
              v-model="form.account.newEmail"
              class="mt-2"
              @keydown.enter="submit"
            />
          </div>
          <div class="mt-8 tablet:mt-0 tablet:ml-4 tablet:w-1/2">
            <apo-input-label v-text="$t('pages.editProfile.account.confirmNewEmailAddress')" />

            <apo-input
              v-model="form.account.newEmailConfirm"
              class="mt-2"
              @keydown.enter="submit"
            />
          </div>
        </div>

        <div class="w-10/12 mx-auto mt-3">
          <p
            v-if="
              form.account.newEmail !== '' &&
                form.account.newEmailConfirm !== '' &&
                form.account.newEmail === form.account.newEmailConfirm
            "
            v-html="$t('pages.editProfile.account.newEmailAddressNotification')"
          />
        </div>

        <div class="w-10/12 mx-auto mt-2">
          <apo-input-error
            :errors="errors"
            field="account_new_email"
          />
        </div>

        <div class="w-10/12 mx-auto mt-8 tablet:mt-12 tablet:flex tablet:justify-center">
          <div class="tablet:mr-4 tablet:w-1/2">
            <apo-input-label v-text="$t('general.password')" />

            <apo-input
              v-model="form.account.password"
              type="password"
              class="mt-2"
              @keydown.enter="submit"
            />
          </div>
          <div class="mt-8 tablet:mt-0 tablet:ml-4 tablet:w-1/2">
            <apo-input-label v-text="$t('pages.editProfile.account.confirmPassword')" />

            <apo-input
              v-model="form.account.passwordconfirm"
              type="password"
              class="mt-2"
              @keydown.enter="submit"
            />
          </div>
        </div>

        <div class="mt-2">
          <apo-input-error
            :errors="errors"
            field="account_password"
          />
        </div>

        <div class="flex mt-12 button-positioning">
          <apo-button
            class="mr-6 text-gray-900 button button--naked button--small shadow-hard"
            @click.native="$router.push({ name: 'profile' })"
            v-text="$t('general.cancel')"
          />

          <apo-button
            class="ml-4 submit-button button button--primary button--small"
            :class="{ 'is-busy cursor-wait': isBusy }"
            :disabled="isBusy"
            @click.native="submit"
          >
            <apo-spinner
              v-if="isBusy"
              class="mr-4"
              size="small"
            />

            <span v-text="$t('general.save')" />
          </apo-button>
        </div>
      </div>
    </div>
    </div>
  </apo-wait>
</template>

<script>
import head from 'lodash/head';
import { mapState, mapGetters, mapActions } from 'vuex';
import store from '@/store';
import AddPharmacyForm from '@/components/form-renderer/AddPharmacyForm.vue';
import RadioButton from '@/components/form/RadioButton.vue';
import RadioButtonGroup from '@/components/form/RadioButtonGroup.vue';
import Checkbox from '@/components/form/Checkbox.vue';
import Select from '@/components/form/Select.vue';
import Input from '@/components/form/Input.vue';
import InputError from '@/components/form/InputError.vue';
import InputLabel from '@/components/form-renderer/InputLabel.vue';
import PharmacySummary from '@/components/pharmacies/PharmacySummary.vue';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import UserService from '@/services/api/UserService';
import RestErrors from '@/services/form/RestErrors';
import {
  AUTH_FETCH_CURRENT_USER,
  FORMS_FETCH_FORM,
  PHARMACIES_FETCH_PUN,
  PHARMACIES_UPDATE_PUN_ACTION,
} from '@/store/types/action-types';
import { canonicalTag } from '@/services/utils';
import PharmaciesFuzzySearch from '@/components/form-renderer/PharmaciesFuzzySearch.vue';

export default {
  components: {
    'apo-input-error': InputError,
    'apo-input-label': InputLabel,
    'apo-radio-button': RadioButton,
    'apo-radio-button-group': RadioButtonGroup,
    'apo-checkbox': Checkbox,
    'apo-pharmacy-summary': PharmacySummary,
    'apo-select': Select,
    'apo-input': Input,
    'apo-loading-overlay': LoadingOverlay,
    'apo-add-pharmacy-form': AddPharmacyForm,
    'apo-pharmacies-fuzzy-search': PharmaciesFuzzySearch,
  },

  head() {
    return {
      title: {
        inner: this.$t('pages.editProfile.meta.title'),
      },
      link: [canonicalTag(this.$route)],
    };
  },

  data() {
    return {
      errorPun: '',
      sucessPun: '',
      myPun: '',
      PharmacyName: this.PharmacyNamec,
      form: {
        formOfAddress: '',
        title: '',
        firstName: '',
        lastName: '',
        job: '',
        age: '',
        workingSince: '',
        priorities: [],
        otherPriorities: '',
        tasks: [],
        account: {
          email: '',
          newEmail: '',
          newEmailConfirm: '',
          password: '',
          passwordconfirm: '',
        },
        pharmacies: '',
        expertOnlyPharmacies: [],
      },
      priorities: [
        'none',
        'purchasing',
        'nutrition',
        'homeopathy',
        'pain',
        'seniors',
        'mother_and_child',
        'vitamins',
        'others',
      ],
      tasks: ['consulting', 'purchasing', 'productmanagement', 'others'],
      jobs: [
        'pharmacist',
        'pharmacist_assistant',
        'pharmacy_assistant_or_technician',
        'pharmaceutical_engineer',
        'pharmaceutical_commercial_employee',
        'student_pharmaceutical_technician',
        'other',
      ],
      ages: ['< 24', '25 - 34', '35 - 44', '45 - 54', '55 - 64', '65 +'],
      isBusy: false,
      isPUNBusy: false,
      errors: new RestErrors(),
      profilePicture: null,
      displayedPun: '',
      displayedPharmacyName: '',
    };
  },

  computed: {
    ...mapState({
      user: state => state.auth.user,
      settings: state => state.settings.settings,
    }),
    PunCode() {
      return this.$store.getters.getPun;
    },
    PharmacyNamec() {
      return this.$store.getters.getName;
    },
    ...mapGetters(['language']),

    ...mapGetters(['getForm']),

    ...mapState({
      form_newmail(state) {
        return state.forms.forms.find(form => form.id === this.formId);
      },
    }),
    pharmacyForm() {
      return [
        {
          type: 'textInput',
          id: 'pharmacy-name',
          ref: 'pharmacyName',
          model: '',
        },
        {
          type: 'selectInput',
          id: 'pharmacy-country',
          ref: 'pharmacyCountry',
          model: 'germany',
          options: [
            {
              value: 'germany',
              text: this.$t('modules.pharmacySummary.form.germany'),
            },
            {
              value: 'denmark',
              text: this.$t('modules.pharmacySummary.form.denmark'),
            },
            {
              value: 'poland',
              text: this.$t('modules.pharmacySummary.form.poland'),
            },
            {
              value: 'czechRepublic',
              text: this.$t('modules.pharmacySummary.form.czechRepublic'),
            },
            {
              value: 'austria',
              text: this.$t('modules.pharmacySummary.form.austria'),
            },
            {
              value: 'switzerland',
              text: this.$t('modules.pharmacySummary.form.switzerland'),
            },
            {
              value: 'france',
              text: this.$t('modules.pharmacySummary.form.france'),
            },
            {
              value: 'luxembourg',
              text: this.$t('modules.pharmacySummary.form.luxembourg'),
            },
            {
              value: 'belgium',
              text: this.$t('modules.pharmacySummary.form.belgium'),
            },
            {
              value: 'netherlands',
              text: this.$t('modules.pharmacySummary.form.netherlands'),
            },
          ],
        },
        {
          type: 'textInput',
          id: 'pharmacy-street',
          ref: 'pharmacyStreet',
          model: '',
        },
        {
          type: 'textInput',
          id: 'pharmacy-street-no',
          ref: 'pharmacyStreetNo',
          model: '',
        },
        {
          type: 'textInput',
          id: 'pharmacy-zip-code',
          ref: 'pharmacyZipCode',
          model: '',
        },
        {
          type: 'textInput',
          id: 'pharmacy-city',
          ref: 'pharmacyCity',
          model: '',
        },
      ];
    },

    formId() {
      const formConfig = this.getForm('apo_change_email_form');

      // console.log(formConfig);

      return formConfig && formConfig.id ? formConfig.id : null;
    },

    languageSpecificJobs() {
      if (this.settings.jobRoles) {
        return this.settings.jobRoles;
      }
      return this.jobs;
    },
  },

  watch: {
    user: {
      immediate: true,
      handler(user) {
        this.form.formOfAddress = user.formOfAddress || '';
        this.form.title = user.title || '';
        this.form.firstName = user.firstName || '';
        this.form.lastName = user.lastName || '';
        this.form.age = user.age || '';
        this.form.job = user.job || '';
        this.form.workingSince = user.workingSince || '';
        this.form.tasks = user.tasks || [];
        this.form.account.email = user.email || '';

        user.expertOnlyPharmacies[0].forEach(field => {
          this.pharmacyForm.forEach((element, index) => {
            console.log();
            if (field.title === element.ref) {
              this.pharmacyForm[index].model = field.value;
            }
          });
        });

        this.form.pharmacies = (user.associatedPharmacies || [])
          .map(pharmacy => pharmacy.pharmacy_unique_number)
          .join(',');

        this.form.priorities = (user.priorities || []).filter(
          priority => ['consulting', 'purchasing', 'productmanagement', 'others'].indexOf(priority) !== -1,
        );

        const otherPriority = (user.priorities || []).filter(
          priority => ['consulting', 'purchasing', 'productmanagement', 'others'].indexOf(priority) === -1,
        );

        this.form.otherPriorities = head(otherPriority) || '';
      },
    },
  },

  methods: {
    ...mapActions([PHARMACIES_FETCH_PUN, PHARMACIES_UPDATE_PUN_ACTION]),
    fetchNewMailForm() {
      this.$store.dispatch(FORMS_FETCH_FORM, this.formId);
    },
    async submitPUNCode() {
      const data = new FormData();
      data.append('associated_pharmacies', this.myPun);

      this.isPUNBusy = true;

      try {
        await UserService.updatePunCode(this.user, data.associated_pharmacies[0]);
        await this.$store.dispatch(AUTH_FETCH_CURRENT_USER); // Aktualisierung des aktuellen Benutzers
      } catch (error) {
        this.errors.clear();
        if (error.response && error.response.status === 400 && error.response.data.code === 'rest_invalid_param') {
          this.errors.assign(error.response.data.data.params);
        }
      } finally {
      // Vollständige Aktualisierung der Seite
        this.isPUNBusy = false;
        this.$router.go(); // Navigieren Sie zur aktuellen Seite
      }
    },

    async update() {
      try {
        const data = await this[PHARMACIES_UPDATE_PUN_ACTION](this.myPun);
        console.log('finished');
        console.log(data);
        if (data !== 'empty_data') {
          this.errorPun = '';
          this.sucessPun = this.$t('modules.pharmacySummary.punSucess');
          this.PharmacyName = data.name;
        } else {
          this.errorPun = this.$t('modules.pharmacySummary.punError');
          this.sucessPun = '';
        }
      } catch (error) {
        console.log(error);
      }
    },


    submit() {
      const data = new FormData();

      if (this.profilePicture !== null) {
        data.append('profile_picture', this.profilePicture);
      }

      data.append('account_email', this.form.account.email);
      data.append('account_new_email', this.form.account.newEmail);
      data.append('account_new_email_confirmation', this.form.account.newEmailConfirm);
      data.append('account_password', this.form.account.password);
      data.append('account_password_confirmation', this.form.account.passwordconfirm);
      data.append('age', this.form.age);
      data.append('last_name', this.form.lastName || '');
      data.append('first_name', this.form.firstName || '');
      data.append('form_of_address', this.form.formOfAddress);
      data.append('job', this.form.job);
      data.append('title', this.form.title);
      data.append('working_since', this.form.workingSince);

      this.form.expertOnlyPharmacies = [
        this.pharmacyForm.map(field => ({
          title: field.ref,
          value: field.model,
        })),
      ];
      data.append('expert_only_pharmacies', JSON.stringify(this.form.expertOnlyPharmacies));

      if (this.form.priorities.indexOf('others') !== -1) {
        data.append('other_priorities', this.form.otherPriorities);
      } else {
        data.append('other_priorities', '');
      }

      this.form.priorities.forEach(priority => {
        data.append('priorities[]', priority);
      });

      this.form.tasks.forEach(task => {
        data.append('tasks[]', task);
      });

      this.form.pharmacies.split(',').forEach(pharmacy => {
        data.append('associated_pharmacies[]', pharmacy);
      });

      this.isBusy = true;

      // Is Mail Change
      // this.fetchNewMailForm();
      // if (this.form.newEmail === this.form.newEmailConfirm){
      // }

      // Update User Profile
      UserService.updateUserProfile(this.user, data)
        .then(() => {
          this.$store.dispatch(AUTH_FETCH_CURRENT_USER);
          // Aufrufen der Logout-Funktion
          this.$store.dispatch('AUTH_LOGOUT')
            .then(() => {
              // Leiten Sie den Benutzer auf die Login-Seite um
              this.$router.push({ name: 'Login' });
            });
        })
        .catch(({ response }) => {
          this.errors.clear();

          if (response.status === 400 && response.data.code === 'rest_invalid_param') {
            this.errors.assign(response.data.data.params);
          }
        })
        .finally(() => {
          this.isBusy = false;
        });

      if (data.associated_pharmacies && data.associated_pharmacies.length > 0) {
        UserService.updatePunCode(this.user, data.associated_pharmacies[0])
          .then(() => {
            this.$store.dispatch(AUTH_FETCH_CURRENT_USER);
          })
          .catch(({ response }) => {
            this.errors.clear();
            if (response.status === 400 && response.data.code === 'rest_invalid_param') {
              this.errors.assign(response.data.data.params);
            }
          })
          .finally(() => {
            this.isBusy = false;
          });
      }
    },

    language() {
      return this.language;
    },

    onInput(event) {
      // eslint-disable-next-line
      this.profilePicture = event.target.files[0];
    },

    onSelectPharmacy(pharmacy) {
      this.pharmacyForm[0].model = pharmacy.name;
      this.pharmacyForm[2].model = pharmacy.street;
      this.pharmacyForm[3].model = pharmacy.number;
      this.pharmacyForm[4].model = pharmacy.zip;
      this.pharmacyForm[5].model = pharmacy.city;
    },
  },
  created() {},
  mounted() {
    if (this.$route.hash) {
      this.$nextTick(() => {
        window.location.href = this.$route.hash;
      });
    }

    // Daten für PUN und Apothekenname abrufen
    this[PHARMACIES_FETCH_PUN]()
      .then(data => {
        console.log('Daten von PHARMACIES_FETCH_PUN:', data);
        this.myPun = data && data.pharmacy_unique_number ? data.pharmacy_unique_number : null;
        this.PharmacyName = data && data.name ? data.name : null;
      })
      .catch(error => {
        console.error('Fehler beim Abrufen der PUN-Daten von PHARMACIES_FETCH_PUN:', error);
      });

    // Daten für die Anzeige abrufen
    UserService.fetchCurrentUserPunCode()
      .then(response => {
        console.log('Daten von fetchCurrentUserPunCode:', response);
        this.displayedPun = (response && response.data && response.data.pharmacy_unique_number) ? response.data.pharmacy_unique_number : this.myPun;
        this.displayedPharmacyName = (response && response.data && response.data.name) ? response.data.name : this.PharmacyName;
      })
      .catch(error => {
        console.error('Fehler beim Abrufen der Daten von fetchCurrentUserPunCode:', error);
      });
  },

};
</script>

<style lang="scss" scoped>
.readonly {
  background-color: #ccc;
}

.button-positioning {
  @media only screen and (max-width: 640px) {
    flex-direction: column;

    button {
      margin: 0 0 20px 0;
    }

    .button--primary {
      order: 1;
    }

    .button--naked {
      order: 2;
    }
  }
}

.submit-button {
  @apply shadow-hard-dark;
  @apply text-white;

  &.is-busy {
    @apply pl-6 #{!important};
  }
}

.anchor {
  position: relative;
  visibility: hidden;
  top: theme("spacing.24");
}
</style>
