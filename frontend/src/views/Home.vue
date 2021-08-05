<template>
  <div class="text-center">
    <v-container v-if="employees.length === 0">
      <v-row class="text-center">
        <v-col cols="12">
          <v-col class="mb-4">
            <h2 class="font-weight-bold mb-3">
              No employees
            </h2>
          </v-col>
          <v-img
            :src="require('../assets/Icon.png')"
            class="my-3"
            contain
            height="400"
          />
        </v-col>

        <v-col class="mb-4">
          <h2 class="font-weight-bold mb-3">
            There is nothing here
          </h2>

          <p class="subheading font-weight-regular">
            Create a new employee by clicking the
            <br /><strong>New Employee</strong> button to get started
          </p>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-else>
      <v-row class="text-center">
        <v-col cols="12">
          <v-col class="mb-4">
            <h2 class="font-weight-bold mb-3">
              There are {{ filteredEmployees.length }} employees
            </h2>
          </v-col>

          <v-container fluid>
            <v-data-iterator
              :items="filteredEmployees"
              :items-per-page.sync="itemsPerPage"
              :page.sync="page"
              :search="search"
              :sort-by="sortBy.text"
              :sort-desc="sortDesc"
              hide-default-footer
            >
              <template v-slot:header>
                <v-toolbar dark color="purple darken-3" class="mb-1">
                  <v-select
                    xs12
                    flat
                    solo-inverted
                    hide-details
                    :items="filterFields"
                    v-model="filterField"
                    label="Filter by"
                  >
                    ></v-select
                  >

                  <template v-if="$vuetify.breakpoint.mdAndUp">
                    <v-spacer></v-spacer>
                    <v-select
                      xs12
                      flat
                      solo-inverted
                      hide-details
                      :items="filterOperators"
                      v-model="filterOperator"
                      label="Operator"
                    >
                      ></v-select
                    >
                    <v-spacer></v-spacer>
                    <v-text-field
                      xs12
                      clearable
                      flat
                      solo-inverted
                      hide-details
                      name="filterTerm"
                      :label="filterTermLabel"
                      :mask="filterTermMask"
                      :rules="filterTermRules"
                      return-masked-value
                      v-model="filterTerm"
                    ></v-text-field>
                    <v-spacer></v-spacer>
                    <v-text-field
                      v-show="filterOperator === 'between'"
                      clearable
                      xs12
                      flat
                      solo-inverted
                      hide-details
                      name="filterTerm2"
                      :label="filterTermLabel"
                      :mask="filterTermMask"
                      :rules="filterTermRules"
                      return-masked-value
                      v-model="filterTerm2"
                    ></v-text-field>
                    <v-spacer></v-spacer>
                    <v-btn-toggle mandatory>
                      <v-btn
                        large
                        depressed
                        color="purple"
                        @click="onClearAllFilters"
                      >
                        Clear All
                      </v-btn>
                    </v-btn-toggle>
                  </template>
                </v-toolbar>
              </template>

              <template v-slot:default="props">
                <v-list subheader two-line>
                  <template v-for="(item, index) in props.items">
                    <v-divider inset :key="index"></v-divider>
                    <v-list-item :key="item.name">
                      <v-list-item-avatar>
                        <v-icon color="purple" dark large>{{
                          getIcon(index)
                        }}</v-icon>
                      </v-list-item-avatar>

                      <v-list-item-content>
                        <v-list-item-title></v-list-item-title>
                        <v-row class="text-center">
                          <v-col cols="3">
                            <p class="font-weight-bold mt-4">
                              {{ item.employeeID }}
                            </p>
                          </v-col>
                          <v-col
                            cols="3"
                            v-for="(key, index) in keys"
                            :key="index"
                          >
                            <p
                              class="font-weight-bold mt-4"
                              :class="{ 'blue--text': sortBy === key }"
                            >
                              {{ item[key.toLowerCase().replace(" ", "_")] }}
                            </p>
                          </v-col>
                        </v-row>
                      </v-list-item-content>

                      <v-list-item-action>
                        <v-btn :to="'/employee/' + item.id" icon>
                          <v-icon color="grey lighten-1">mdi-pencil</v-icon>
                        </v-btn>
                      </v-list-item-action>
                      <v-list-item-action>
                        <v-btn @click="deleteEmployee(item)" icon>
                          <v-icon color="grey lighten-1">mdi-delete</v-icon>
                        </v-btn>
                      </v-list-item-action>
                    </v-list-item>
                    <v-divider inset :key="'y' + index"></v-divider>
                  </template>
                </v-list>
              </template>

              <template v-slot:footer>
                <v-row class="mt-2" align="center" justify="center">
                  <span class="grey--text">Items per page</span>
                  <v-menu offset-y>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        dark
                        text
                        color="purple"
                        class="ml-2"
                        v-bind="attrs"
                        v-on="on"
                      >
                        {{ itemsPerPage }}
                        <v-icon>mdi-chevron-down</v-icon>
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item
                        v-for="(number, index) in itemsPerPageArray"
                        :key="index"
                        @click="updateItemsPerPage(number)"
                      >
                        <v-list-item-title>{{ number }}</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>

                  <v-spacer></v-spacer>

                  <span
                    class="mr-4
                    grey--text"
                  >
                    Page {{ page }} of {{ numberOfPages }}
                  </span>
                  <v-btn
                    fab
                    dark
                    color="purple darken-3"
                    class="mr-1"
                    @click="formerPage"
                  >
                    <v-icon>mdi-chevron-left</v-icon>
                  </v-btn>
                  <v-btn
                    fab
                    dark
                    color="purple darken-3"
                    class="ml-1"
                    @click="nextPage"
                  >
                    <v-icon>mdi-chevron-right</v-icon>
                  </v-btn>
                </v-row>
              </template>
            </v-data-iterator>
          </v-container>
        </v-col>
      </v-row>
    </v-container>
    <LoadingOverlay :loading="$store.state.isLoading"></LoadingOverlay>
  </div>
</template>

<script>
import LoadingOverlay from "../components/LoadingOverlay";
import axios from "axios";
import moment from "moment";

export default {
  name: "Home",

  data() {
    return {
      selected: [2],
      pagination: {},
      search: "",
      employees: [],
      itemsPerPageArray: [10, 20, 30],
      search: "",
      filter: {},
      sortDesc: false,
      page: 1,
      itemsPerPage: 5,
      sortBy: { text: "EmployeeID", value: "employeeId", type: "text" },
      keys: ["First Name", "Last Name", "Contact Number"],
      filterFields: [
        { text: "EmployeeID", value: "employeeId", type: "text" },
        { text: "First Name", value: "first_name", type: "text" },
        { text: "Last Name", value: "last_name", type: "text" },
        { text: "Date of Birth", value: "dob", type: "date" },
        { text: "Email", value: "email", type: "text" },
        { text: "Skill Name", value: "skills", type: "text" },
      ],
      filterDefs: {
        text: {
          contains: {
            display: "Contains",
            function: this.filterByTextContains,
          },
          startsWith: {
            display: "Starts with",
            function: this.filterByTextStartsWith,
          },
        },
        number: {
          equal: {
            display: "Equal",
            function: this.filterByNumberEqual,
            decimalPoint: 1,
          },
          greater: {
            display: "Greater than",
            function: this.filterByNumberGreater,
            decimalPoint: 1,
          },
          less: {
            display: "Less than",
            function: this.filterByNumberLess,
            decimalPoint: 1,
          },
          between: {
            display: "Between",
            function: this.filterByNumberBetween,
            decimalPoint: 1,
          },
        },
        date: {
          equal: {
            display: "Equal",
            function: this.filterByDateEqual,
            format: "YYYY",
          },
          greater: {
            display: "Greater than",
            function: this.filterByDateGreater,
            format: "YYYY",
          },
          less: {
            display: "Less than",
            function: this.filterByDateLess,
            format: "YYYY",
          },
          between: {
            display: "Between",
            function: this.filterByDateBetween,
            format: "YYYY",
          },
        },
        lookup: {
          is: { display: "Is", function: this.filterByLookupIs },
          isNot: { display: "Is not", function: this.filterByLookupIsNot },
        },
      },
      filterField: "",
      filterType: "",
      filterOperators: [],
      filterOperator: "",
      filterTerm: "",
      filterTerm2: "",
      filterTermMask: "",
      filterTermLabel: "",
      filterTermRules: [],
      dateFilterFormat: "YYYY",
      filterLookupItems: [],
      filterLookupValue: "",
      filterLookupLabel: "",
    };
  },
  components: {
    LoadingOverlay,
  },
  watch: {
    params: {
      handler() {
        this.getEmployees();
      },
      deep: true,
    },
    /**
     * Set Filter Operators
     */
    filterField(newValue) {
      const filterType = this.filterFields.find(
        (item) => item.value === newValue
      ).type;
      if (filterType) {
        this.filterType = filterType;
        this.filterOperators = this.getFilterOperators(
          this.filterDefs[filterType]
        );
        this.filterOperator = this.filterOperators[0]["value"];
        this.clearFilterTerms();
      } else {
        this.filterType = "";
        this.filterOperators = [];
        this.filterOperator = "";
        this.clearFilterTerms();
      }
    },
    filterOperator() {
      this.clearFilterTerms();
      if (this.filterType === "text") {
        this.filterTermMask = "";
        this.filterTermLabel = "Filter";
      } else if (this.filterType === "number") {
        if (this.filterField === "gpa") {
          this.filterTermMask = "#.#";
          this.filterTermLabel = "#.#";
        } else if (this.filterField === "zip") {
          this.filterTermMask = "#####";
          this.filterTermLabel = "#####";
        } else {
          this.filterTermMask = "######";
          this.filterTermLabel = "######";
        }
      } else if (this.filterType === "date") {
        this.filterTermMask = "####";
        this.filterTermLabel = "YYYY";
        this.filterTermRules = [this.rulesIsValidDate];
      } else if (this.filterType === "lookup") {
        let lookupItems = [];
        // if (this.filterField === 'state') {
        //     lookupItems = this.states
        //     this.filterLookupLabel = 'State'
        // }
        this.filterLookupItems = lookupItems;
        this.filterLookupValue = "";
      }
    },
  },
  computed: {
    /**
     * set page numbers
     */
    numberOfPages() {
      return Math.ceil(this.employees.length / this.itemsPerPage);
    },
    filteredKeys() {
      return this.filterFields.filter((key) => key.text !== "EmployeeID");
      // return this.keys.filter((key) => key !== "EmployeeID");
    },
    filteredEmployees() {
      if (
        this.filterField &&
        this.filterOperator &&
        (this.filterTerm || this.filterLookupValue)
      ) {
        const filterFunction = this.filterDefs[this.filterType][
          this.filterOperator
        ]["function"];
        if (this.filterType === "number") {
          const decimalPoint =
            this.filterDefs[this.filterType][this.filterOperator][
              "decimalPoint"
            ] || 0;
          if (this.filterOperator === "between") {
            if (this.filterTerm && this.filterTerm2) {
              return filterFunction(
                this.employees,
                this.filterField,
                this.filterTerm,
                this.filterTerm2,
                decimalPoint
              );
            } else {
              return this.employees;
            }
          } else {
            return filterFunction(
              this.employees,
              this.filterField,
              this.filterTerm,
              decimalPoint
            );
          }
        } else if (this.filterType === "date") {
          const format =
            this.filterDefs[this.filterType][this.filterOperator]["format"] ||
            this.dateFilterFormat;
          if (
            this.filterOperator === "between" &&
            this.rulesIsValidDate(this.filterTerm) &&
            this.rulesIsValidDate(this.filterTerm2)
          ) {
            return filterFunction(
              this.employees,
              this.filterField,
              this.filterTerm,
              this.filterTerm2,
              format
            );
          } else if (
            this.filterOperator !== "between" &&
            this.rulesIsValidDate(this.filterTerm)
          ) {
            return filterFunction(
              this.employees,
              this.filterField,
              this.filterTerm,
              format
            );
          } else {
            return this.employees;
          }
        } else if (this.filterType === "lookup") {
          return filterFunction(
            this.employees,
            this.filterField,
            this.filterLookupValue
          );
        } else {
          return filterFunction(
            this.employees,
            this.filterField,
            this.filterTerm
          );
        }
      } else {
        return this.employees;
      }
    },
  },
  mounted() {
    this.getEmployees();

    document.title = "List | EmployeeApp";
  },
  created() {
    this.filterField = "first_name";
    // this.get()
  },
  methods: {
    async deleteEmployee(item) {
      axios
        .delete(`/api/v1/employees/${item.id}`)
        .then((response) => {
          console.log(response);
          this.employees = this.employees.filter(
            (employee) => employee.id !== item.id
          );
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getIcon(index) {
      let val = parseInt(index) + 1;
      return `mdi-numeric-${val}-circle-outline`;
    },
    nextPage() {
      if (this.page + 1 <= this.numberOfPages) this.page += 1;
    },
    formerPage() {
      if (this.page - 1 >= 1) this.page -= 1;
    },
    updateItemsPerPage(number) {
      this.itemsPerPage = number;
    },
    getEmployees() {
      this.$store.commit("setIsLoading", true);

      axios
        .get("/api/v1/employees")
        .then((response) => {
          console.log(response.data);
          this.employees = response.data.data;
          this.$store.commit("setIsLoading", false);
        })
        .catch((error) => {
          console.log(error);
          this.$store.commit("setIsLoading", false);
        });
    },
    ////////////////////////////////////////////////
    getFilterOperators(filterDef) {
      let oprs = [];
      if (filterDef) {
        for (let key in filterDef) {
          oprs.push({ text: filterDef[key]["display"], value: key });
        }
      }
      return oprs;
    },
    clearFilterTerms() {
      this.filterTerm = "";
      this.filterTerm2 = "";
      this.filterTermMask = "";
      this.filterTermLabel = "Filter";
      this.filterTermRules = [];
      this.filterLookupValue = "";
      this.filterLookupItems = [];
      this.filterLookupLabel = "";
    },
    rulesIsValidDate(value) {
      return moment(value, this.dateFilterFormat, true).isValid();
    },
    // ---------- Events ------------------------
    onClearAllFilters() {
      this.filterField = "first_name";
    },
    // ---------- field filter methods ----------
    filterByTextContains(list, fieldName, fieldValue) {
      const re = new RegExp(fieldValue, "i");
      let result = this.filterByRegExp(list, fieldName, fieldValue, re);
      return result;
    },
    filterByTextStartsWith(list, fieldName, fieldValue) {
      const re = new RegExp("^" + fieldValue, "i");
      return this.filterByRegExp(list, fieldName, fieldValue, re);
    },
    filterByRegExp(list, fieldName, fieldValue, regExp) {
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          if (fieldName === "skills" && item.skills.length > 0) {
            let values = item.skills.filter((skill) => regExp.test(skill.name));
            return values.length > 0;
          }
          return regExp.test(item[fieldName]);
        } else {
          return true;
        }
      });
    },
    filterByNumberEqual(list, fieldName, fieldValue, decimalPoint) {
      decimalPoint = decimalPoint || 0;
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          return (
            Number(item[fieldName]).toFixed(decimalPoint) ===
            Number(fieldValue).toFixed(decimalPoint)
          );
        } else {
          return true;
        }
      });
    },
    filterByNumberGreater(
      list,
      fieldName,
      fieldValue,
      floatPoint,
      decimalPoint
    ) {
      decimalPoint = decimalPoint || 0;
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          return (
            Number(item[fieldName]).toFixed(decimalPoint) >
            Number(fieldValue).toFixed(decimalPoint)
          );
        } else {
          return true;
        }
      });
    },
    filterByNumberLess(list, fieldName, fieldValue, decimalPoint) {
      decimalPoint = decimalPoint || 0;
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          return (
            Number(item[fieldName]).toFixed(decimalPoint) <
            Number(fieldValue).toFixed(decimalPoint)
          );
        } else {
          return true;
        }
      });
    },
    filterByNumberBetween(
      list,
      fieldName,
      fieldValue1,
      fieldValue2,
      decimalPoint
    ) {
      decimalPoint = decimalPoint || 0;
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          return (
            Number(item[fieldName]).toFixed(decimalPoint) >=
              Number(fieldValue1).toFixed(decimalPoint) &&
            Number(item[fieldName]).toFixed(decimalPoint) <=
              Number(fieldValue2).toFixed(decimalPoint)
          );
        } else {
          return true;
        }
      });
    },
    filterByDateEqual(list, fieldName, fieldValue, format) {
      format = format || this.dateFilterFormat;
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          return moment(item[fieldName]).isSame(
            moment(fieldValue, format),
            "year"
          );
        } else {
          return true;
        }
      });
    },
    filterByDateGreater(list, fieldName, fieldValue, format) {
      format = format || this.dateFilterFormat;
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          return moment(item[fieldName]).isAfter(
            moment(fieldValue, format),
            "year"
          );
        } else {
          return true;
        }
      });
    },
    filterByDateLess(list, fieldName, fieldValue, format) {
      format = format || this.dateFilterFormat;
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          return moment(item[fieldName]).isBefore(
            moment(fieldValue, format),
            "year"
          );
        } else {
          return true;
        }
      });
    },
    filterByDateBetween(list, fieldName, fieldValue1, fieldValue2, format) {
      format = format || this.dateFilterFormat;
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          return moment(item[fieldName]).isBetween(
            moment(fieldValue1, format),
            moment(fieldValue2, format),
            "year",
            "[]"
          );
        } else {
          return true;
        }
      });
    },
    filterByLookupIs(list, fieldName, fieldValue) {
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          return item[fieldName] === fieldValue;
        } else {
          return true;
        }
      });
    },
    filterByLookupIsNot(list, fieldName, fieldValue) {
      return list.filter((item) => {
        if (item[fieldName] !== undefined) {
          return item[fieldName] !== fieldValue;
        } else {
          return true;
        }
      });
    },
  },
};
</script>
<style scoped>
.v-text-field {
  width: 150px;
}
</style>
