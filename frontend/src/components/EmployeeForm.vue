<template>
  <div class="text-center">
    <v-container>
      <v-row class="text-center">
        <v-col cols="12">
          <v-subheader class="text-h4 purple--text pl-0"
            ><strong>Basic Info</strong></v-subheader
          >
          <form>
            <v-row>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="first_name"
                  :error-messages="firstNameErrors"
                  :counter="20"
                  label="First Name"
                  required
                  @input="$v.first_name.$touch()"
                  @blur="$v.first_name.$touch()"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="last_name"
                  :error-messages="lastNameErrors"
                  :counter="20"
                  label="Last Name"
                  required
                  @input="$v.last_name.$touch()"
                  @blur="$v.last_name.$touch()"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-text-field
              v-model="contact_number"
              :error-messages="contactNumberErrors"
              :counter="10"
              label="Contact Number"
              required
              @input="$v.contact_number.$touch()"
              @blur="$v.contact_number.$touch()"
            ></v-text-field>
            <v-text-field
              v-model="email"
              :error-messages="emailErrors"
              label="E-mail Address"
              required
              @input="$v.email.$touch()"
              @blur="$v.email.$touch()"
            ></v-text-field>

            <v-menu
              data-testid="increment-menu"
              ref="menu"
              v-model="menu"
              :close-on-content-click="false"
              transition="scale-transition"
              offset-y
              min-width="auto"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="dob"
                  :error-messages="dobErrors"
                  label="Date of birth"
                  append-icon="mdi-calendar"
                  readonly
                  required
                  @input="$v.dob.$touch()"
                  @blur="$v.dob.$touch()"
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="dob"
                :active-picker.sync="activePicker"
                :max="
                  new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                    .toISOString()
                    .substr(0, 10)
                "
                min="1950-01-01"
                @change="save"
              ></v-date-picker>
            </v-menu>

            <v-subheader class="text-h4 purple--text pl-0"
              ><strong>Address Info</strong></v-subheader
            >
            <v-text-field
              v-model="address"
              :error-messages="addressErrors"
              label="Street Address"
              required
              @input="$v.address.$touch()"
              @blur="$v.address.$touch()"
            ></v-text-field>

            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="city"
                  :error-messages="cityErrors"
                  label="City"
                  required
                  @input="$v.city.$touch()"
                  @blur="$v.city.$touch()"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="postal_code"
                  :error-messages="postalCodeErrors"
                  type="number"
                  :counter="4"
                  label="Postal Code"
                  required
                  @input="$v.postal_code.$touch()"
                  @blur="$v.postal_code.$touch()"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="country"
                  :error-messages="countryErrors"
                  label="Country"
                  required
                  @input="$v.country.$touch()"
                  @blur="$v.country.$touch()"
                ></v-text-field>
              </v-col>
            </v-row>

            <v-subheader class="text-h4 purple--text pl-0"
              ><strong>Skills</strong></v-subheader
            >

            <v-row class="mt-5" v-for="(skill, index) in skills" :key="index">
              <v-col cols="12"><v-divider></v-divider></v-col>
              <template>
                <v-col cols="12" md="4">
                  <v-text-field
                    v-model="skills[index].name"
                    :error-messages="skillErrors(index)"
                    label="Skill"
                    required
                    @input="$v.skills.$each.$iter[index].name.$touch()"
                    @blur="$v.skills.$each.$iter[index].name.$touch()"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    v-model="skills[index].experience"
                    :error-messages="experienceErrors(index)"
                    label="Years Experience"
                    required
                    @input="$v.skills.$each.$iter[index].experience.$touch()"
                    @blur="$v.skills.$each.$iter[index].experience.$touch()"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-select
                    v-if="edit || skills[index].rating !== ''"
                    :value="skills[index].rating"
                    @input="setSelected($event, index)"
                    :items="items"
                    :error-messages="ratingErrors(index)"
                    label="Senority Rating"
                    required
                    @change="$v.skills.$each.$iter[index].rating.$touch()"
                    @blur="$v.skills.$each.$iter[index].rating.$touch()"
                  ></v-select>
                  <v-select
                    v-else
                    v-model="skills[index].rating"
                    :items="items"
                    :error-messages="ratingErrors(index)"
                    label="Senority Rating"
                    required
                    @change="$v.skills.$each.$iter[index].rating.$touch()"
                    @blur="$v.skills.$each.$iter[index].rating.$touch()"
                  ></v-select>
                </v-col>
                <v-col cols="12" md="1">
                  <v-btn
                    class="ma-2"
                    outlined
                    large
                    fab
                    color="indigo"
                    @click="remove(index)"
                  >
                    <v-icon>mdi-delete</v-icon>
                  </v-btn>
                </v-col>
              </template>
              <v-col cols="12"><v-divider></v-divider></v-col>
            </v-row>

            <v-row>
              <v-col cols="12">
                <v-btn data-testid="increment-newskill" dark large block @click="addSkill">
                  <v-icon>mdi-plus</v-icon>
                  Add New Skill
                </v-btn>
                <div
                  v-if="skillsObjectErrors.length"
                  class="v-messages theme--dark error--text"
                  role="alert"
                >
                  <div class="v-messages__wrapper">
                    <div
                      class="v-messages__message"
                      v-for="(error, index) in skillsObjectErrors"
                      :key="index"
                    >
                      {{ error }}
                    </div>
                  </div>
                </div>
                <v-alert
                  v-if="alert.active"
                  dense
                  text
                  border="left"
                  class="mt-5"
                  :type="alert.type"
                  close-text="Close Alert"
                  dismissible
                >
                  {{ alert.message }}
                </v-alert>
              </v-col>
            </v-row>

            <v-row style="margin-top: 75px;">
              <v-col cols="12" :md="edit ? 10 : 12" class="text-right">
                <v-btn
                  data-testid="increment-btn-major"
                  color="purple"
                  dark
                  rounded
                  :loading="btnLoading"
                  :disabled="btnLoading"
                  @click="submit"
                  style="padding: 23px;"
                >
                  <v-icon large left>
                    mdi-plus-circle-outline
                  </v-icon>
                  <span class="ml-5"
                    >Save {{ edit ? "Changes to" : "and Add" }} Employee</span
                  >
                  <template v-slot:loader>
                    <span class="custom-loader">
                      <v-icon dark>mdi-cached</v-icon>
                    </span>
                  </template>
                </v-btn>
              </v-col>

              <v-col cols="12" md="2" class="text-right" v-if="edit">
                <v-btn
                  color="error"
                  dark
                  rounded
                  @click="clear"
                  style="padding: 23px;"
                >
                  <v-icon large left>
                    mdi-pencil
                  </v-icon>
                  <span class="ml-5">Reset</span>
                </v-btn>
              </v-col>
            </v-row>
          </form>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import {
  required,
  maxLength,
  minLength,
  email,
} from "vuelidate/lib/validators";
import axios from "axios";

export default {
  mixins: [validationMixin],
  name: "EmployeeForm",
  props: {
    edit: {
      type: Boolean,
      default: false,
    },
    employee: {
      type: Object,
      default: null,
    },
    actionLink: {
      type: String,
      default: "/api/v1/employees",
    },
  },
  /**
   * Validation definitions
   */
  validations: {
    first_name: { required, maxLength: maxLength(20) },
    last_name: { required, maxLength: maxLength(20) },
    contact_number: { required, maxLength: maxLength(10) },
    address: { required },
    email: { required, email },
    dob: { required },
    city: { required },
    postal_code: { required, maxLength: maxLength(4) },
    country: { required },
    skills: {
      required,
      minLength: minLength(1),
      $each: {
        name: {
          required,
        },
        experience: {
          required,
        },
        rating: {
          required,
        },
      },
    },
  },

  data: () => ({
    btnLoading: false,
    alert: {
      active: false,
      type: "success",
      message: "",
    },
    first_name: "",
    last_name: "",
    contact_number: "",
    email: "",
    address: "",
    dob: null,
    city: "",
    postal_code: "",
    country: "",
    skills: [
      {
        name: "",
        experience: "",
        rating: "",
      },
    ],
    select: null,
    menu: false,
    activePicker: null,
    items: ["Beginner", "Intermediate", "Expert"],
  }),

  computed: {
    /**
     * Validation field error messages
     *  */

    addressErrors() {
      const errors = [];
      if (!this.$v.address.$dirty) return errors;
      !this.$v.address.required && errors.push("Street ddress is required.");
      return errors;
    },
    countryErrors() {
      const errors = [];
      if (!this.$v.country.$dirty) return errors;
      !this.$v.country.required && errors.push("Country is required.");
      return errors;
    },
    postalCodeErrors() {
      const errors = [];
      if (!this.$v.postal_code.$dirty) return errors;
      !this.$v.postal_code.maxLength &&
        errors.push("Postal code must be 4 characters long");
      !this.$v.postal_code.required && errors.push("Postal code is required.");
      return errors;
    },
    cityErrors() {
      const errors = [];
      if (!this.$v.city.$dirty) return errors;
      !this.$v.city.required && errors.push("City is required.");
      return errors;
    },
    dobErrors() {
      const errors = [];
      if (!this.$v.dob.$dirty) return errors;
      !this.$v.dob.required && errors.push("Date of birth is required.");
      return errors;
    },
    contactNumberErrors() {
      const errors = [];
      if (!this.$v.contact_number.$dirty) return errors;
      !this.$v.contact_number.maxLength &&
        errors.push("Contact number must be 10 characters long");
      !this.$v.contact_number.required && errors.push("Contact is required.");
      return errors;
    },
    lastNameErrors() {
      const errors = [];
      if (!this.$v.last_name.$dirty) return errors;
      !this.$v.last_name.maxLength &&
        errors.push("Name must be at most 20 characters long");
      !this.$v.last_name.required && errors.push("Name is required.");
      return errors;
    },
    firstNameErrors() {
      const errors = [];
      if (!this.$v.first_name.$dirty) return errors;
      !this.$v.first_name.maxLength &&
        errors.push("Name must be at most 20 characters long");
      !this.$v.first_name.required && errors.push("Name is required.");
      return errors;
    },
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.email && errors.push("Must be valid e-mail");
      !this.$v.email.required && errors.push("E-mail is required");
      return errors;
    },
    skillsObjectErrors() {
      const errors = [];
      if (!this.$v.skills.$dirty) return errors;
      !this.$v.skills.minLength &&
        errors.push("Employee must have at least one skill");
      !this.$v.skills.required &&
        errors.push("Employee must have at least one skill");
      return errors;
    },
  },

  watch: {
    menu(val) {
      // date picker setup
      val && setTimeout(() => (this.activePicker = "YEAR"));
    },
    $props: {
      handler: function(val, oldVal) {
        console.log("watch", val);
        if (val.employee.first_name) {
          this.clear();
        }
      },
      deep: true,
    },
  },

  methods: {
    submit() {
      //submit create/edit employee
      this.$v.$touch();

      if (this.$v.$invalid || this.$v.$error) {
        return;
      }
      this.btnLoading = true;
      let employee = this.setEmployee();

      if (this.edit) {
        axios
          .put(this.actionLink, employee)
          .then((response) => {
            this.alert.active = true;
            this.alert.message = "Employee updated successfully.";
            console.log(response.data);
            this.employees = response.data.data;
            this.$router.push({ path: "/" });
            this.btnLoading = false;
          })
          .catch((error) => {
            console.log(error);
            this.alert.active = true;
            this.alert.type = "error";
            this.alert.message = "An error occured, please try again later";
            this.btnLoading = false;
          });
      } else {
        axios
          .post(this.actionLink, employee)
          .then((response) => {
            console.log(response.data);
            this.employees = response.data.data;
            this.clear();
            this.$v.$reset();
            this.alert.active = true;
            this.alert.message = "Employee created successfully.";
            this.btnLoading = false;
          })
          .catch((error) => {
            console.log(error);
            this.alert.active = true;
            this.alert.type = "error";
            this.alert.message = "An Error occured, please try again later";
            this.btnLoading = false;
          });
      }
    },
    addSkill() {
      // add skills row
      this.skills.push({
        name: "",
        experience: "",
        rating: "",
      });
    },
    setSelected(value, index) {
      console.log(value);
      console.log(index);
      this.skills[index].rating = value;
    },
    remove(index) {
      // delete skills row
      this.skills.splice(index, 1);
      if (this.edit && this.employee.skills[index]) {
        axios
          .delete(
            `/api/v1/employees/${this.employee.id}/skill/${this.employee.skills[index].id}`
          )
          .then((response) => {
            console.log(response);
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    save(date) {
      // save date to field
      this.$refs.menu.save(date);
    },

    clear() {
      this.first_name = this.employee.first_name;
      this.last_name = this.employee.last_name;
      this.contact_number = this.employee.contact_number;
      this.email = this.employee.email;
      this.address = this.employee.address;
      this.dob = this.employee.dob;
      this.city = this.employee.city;
      this.postal_code = this.employee.postal_code;
      this.country = this.employee.country;
      this.skills = [];
      this.employee.skills.forEach((skill) => {
        let val = {
          name: skill.name,
          experience: skill.pivot.experience,
          rating: skill.pivot.rating,
        };
        this.skills.push(val);
      });
    },

    setEmployee() {
      return {
        first_name: this.first_name,
        last_name: this.last_name,
        contact_number: this.contact_number,
        email: this.email,
        address: this.address,
        dob: this.dob,
        city: this.city,
        postal_code: this.postal_code,
        country: this.country,
        skills: this.skills,
      };
    },

    /**
     * To do
     * If time allows: Refactor this section
     *  Code repetition
     */
    skillErrors(index) {
      const errors = [];
      if (!this.$v.skills.$each.$iter[index].name.$dirty) return errors;
      !this.$v.skills.$each.$iter[index].name.required &&
        errors.push("Skill is required.");
      return errors;
    },
    ratingErrors(index) {
      const errors = [];
      if (!this.$v.skills.$each.$iter[index].rating.$dirty) return errors;
      !this.$v.skills.$each.$iter[index].rating.required &&
        errors.push("Rating is required");
      return errors;
    },

    experienceErrors(index) {
      const errors = [];
      if (!this.$v.skills.$each.$iter[index].experience.$dirty) return errors;
      !this.$v.skills.$each.$iter[index].experience.required &&
        errors.push("Years experience is required.");
      return errors;
    },
  },
  mounted() {
    this.clear();
  },
};
</script>
<style>
.custom-loader {
  animation: loader 1s infinite;
  display: flex;
}
@-moz-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-webkit-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-o-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
