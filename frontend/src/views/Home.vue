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
              There are {{ employees.length }} employees
            </h2>
          </v-col>

          <v-container fluid>
            <v-data-iterator
              :items="employees"
              :items-per-page.sync="itemsPerPage"
              :page.sync="page"
              :search="search"
              :sort-by="sortBy.toLowerCase().replace(' ', '_')"
              :sort-desc="sortDesc"
              hide-default-footer
            >
              <template v-slot:header>
                <v-toolbar dark color="purple darken-3" class="mb-1">
                  <v-text-field
                    v-model="search"
                    clearable
                    flat
                    solo-inverted
                    hide-details
                    prepend-inner-icon="mdi-magnify"
                    label="Search"
                  ></v-text-field>
                  <template v-if="$vuetify.breakpoint.mdAndUp">
                    <v-spacer></v-spacer>
                    <v-select
                      v-model="sortBy"
                      flat
                      solo-inverted
                      hide-details
                      :items="keys"
                      label="Sort by"
                    ></v-select>
                    <v-spacer></v-spacer>
                    <v-btn-toggle v-model="sortDesc" mandatory>
                      <v-btn large depressed color="purple" :value="false">
                        <v-icon>mdi-arrow-up</v-icon>
                      </v-btn>
                      <v-btn large depressed color="purple" :value="true">
                        <v-icon>mdi-arrow-down</v-icon>
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
                            v-for="(key, index) in filteredKeys"
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
      sortBy: "employeeId",
      keys: ["EmployeeID", "First Name", "Last Name", "Contact Number"],
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
  },
  computed: {
    numberOfPages() {
      return Math.ceil(this.employees.length / this.itemsPerPage);
    },
    filteredKeys() {
      return this.keys.filter((key) => key !== "EmployeeID");
    },
  },
  mounted() {
    this.getEmployees();

    document.title = "List | EmployeeApp";
  },
  methods: {
    async deleteEmployee(item) {
      axios.delete(`/api/v1/employees/${item.id}`)
      .then(response => {
        console.log(response)
        this.employees = this.employees.filter(employee => employee.id !== item.id)
      }).catch(error => {
        console.log(error)
      })
      
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
  },
};
</script>
