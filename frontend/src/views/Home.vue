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
              :items="items"
              :items-per-page.sync="itemsPerPage"
              :page.sync="page"
              :search="search"
              :sort-by="sortBy.toLowerCase()"
              :sort-desc="sortDesc"
              hide-default-footer
            >
              <template v-slot:header>
                <v-toolbar
                  dark
                  color="purple darken-3"
                  class="mb-1"
                >
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
                    <v-btn-toggle
                      v-model="sortDesc"
                      mandatory
                    >
                      <v-btn
                        large
                        depressed
                        color="purple"
                        :value="false"
                      >
                        <v-icon>mdi-arrow-up</v-icon>
                      </v-btn>
                      <v-btn
                        large
                        depressed
                        color="purple"
                        :value="true"
                      >
                        <v-icon>mdi-arrow-down</v-icon>
                      </v-btn>
                    </v-btn-toggle>
                  </template>
                </v-toolbar>
              </template>

              <template v-slot:default="props">
                <v-list subheader two-line>
                    <template v-for="(item, index ) in props.items">
                      <v-divider inset :key="index"></v-divider>
                      <v-list-item :key="item.name">
                        <v-list-item-avatar>
                          <v-icon
                            color="purple"
                            dark
                            large
                          >{{ getIcon(index) }}</v-icon>
                        </v-list-item-avatar>

                        <v-list-item-content>
                          <v-list-item-title></v-list-item-title>
                          <v-row class="text-center">
                            <v-col 
                            cols="3">
                              <p class="font-weight-bold mt-4">
                                {{ item.name }}
                              </p>
                            </v-col>
                            <v-col 
                            cols="3"  
                            v-for="(key, index) in filteredKeys"
                            :key="index">
                              <p class="font-weight-bold mt-4" :class="{ 'blue--text': sortBy === key }">
                                {{ key }}: {{ item[key.toLowerCase()] }}
                              </p>
                            </v-col>
                          </v-row>
                        </v-list-item-content>

                        <v-list-item-action>
                          <v-btn icon>
                            <v-icon color="grey lighten-1">mdi-information</v-icon>
                          </v-btn>
                        </v-list-item-action>
                      </v-list-item>
                      <v-divider inset :key="'y'+index"></v-divider>
                    </template>
                  </v-list>
                <!-- <v-row>
                  <v-col
                    v-for="item in props.items"
                    :key="item.name"
                    cols="12"
                    sm="6"
                    md="4"
                    lg="3"
                  >
                  
                    <v-card>
                      <v-card-title class="subheading font-weight-bold">
                        {{ item.name }}
                      </v-card-title>

                      <v-divider></v-divider>

                      <v-list dense>
                        <v-list-item
                          v-for="(key, index) in filteredKeys"
                          :key="index"
                        >
                          <v-list-item-content :class="{ 'blue--text': sortBy === key }">
                            {{ key }}:
                          </v-list-item-content>
                          <v-list-item-content
                            class="align-end"
                            :class="{ 'blue--text': sortBy === key }"
                          >
                            {{ item[key.toLowerCase()] }}
                          </v-list-item-content>
                        </v-list-item>
                      </v-list>
                    </v-card>
                  </v-col>
                </v-row> -->
              </template>

              <template v-slot:footer>
                <v-row
                  class="mt-2"
                  align="center"
                  justify="center"
                >
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

          <!-- <v-list subheader two-line>
            <template v-for="(employee, index ) in employees">
              <v-divider inset :key="index"></v-divider>
              <v-list-item :key="employee.id">
                <v-list-item-avatar>
                  <v-icon
                    color="purple"
                    dark
                    large
                  >{{ getIcon(index) }}</v-icon>
                </v-list-item-avatar>

                <v-list-item-content>
                  <v-row class="text-center">
                    <v-col cols="3">
                      <p class="font-weight-bold mt-4">
                        First Name
                      </p>
                    </v-col>
                    <v-col cols="3">
                      <p class="font-weight-bold mt-4">
                        Last Name
                      </p>
                    </v-col>
                    <v-col cols="3">
                      <p class="font-weight-bold mt-4">
                        Contact Number
                      </p>
                    </v-col>
                  </v-row>
                </v-list-item-content>

                <v-list-item-action>
                  <v-btn icon>
                    <v-icon color="grey lighten-1">mdi-information</v-icon>
                  </v-btn>
                </v-list-item-action>
              </v-list-item>
              <v-divider inset :key="'y'+index"></v-divider>
            </template>
          </v-list> -->
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
      employees: [
        {
          id: '1x',
        },
        {
          id: '2x',
        },
        {
          id: '3x',
        },
        {
          id: '4x',
        },
        {
          id: '5x',
        },
        {
          id: '6x',
        },
        {
          id: '7x',
        },
        {
          id: '8x',
        },
        {
          id: '9x',
        },
        {
          id: '10x',
        },
        {
          id: '11x',
        },
      ],

      itemsPerPageArray: [4, 8, 12],
        search: '',
        filter: {},
        sortDesc: false,
        page: 1,
        itemsPerPage: 4,
        sortBy: 'name',
        keys: [
          'Name',
          'Calories',
          'Fat',
          // 'Carbs',
          // 'Protein',
          // 'Sodium',
          // 'Calcium',
        ],
        items: [
          {
            name: 'Frozen Yogurt',
            calories: 159,
            fat: 6.0,
            carbs: 24,
            protein: 4.0,
            sodium: 87,
            calcium: '14%',
          },
          {
            name: 'Ice cream sandwich',
            calories: 237,
            fat: 9.0,
            carbs: 37,
            protein: 4.3,
            sodium: 129,
            calcium: '8%',
          },
          {
            name: 'Eclair',
            calories: 262,
            fat: 16.0,
            carbs: 23,
            protein: 6.0,
            sodium: 337,
            calcium: '6%',
          },
          {
            name: 'Cupcake',
            calories: 305,
            fat: 3.7,
            carbs: 67,
            protein: 4.3,
            sodium: 413,
            calcium: '3%',
          },
          {
            name: 'Gingerbread',
            calories: 356,
            fat: 16.0,
            carbs: 49,
            protein: 3.9,
            sodium: 327,
            calcium: '7%',
          },
          {
            name: 'Jelly bean',
            calories: 375,
            fat: 0.0,
            carbs: 94,
            protein: 0.0,
            sodium: 50,
            calcium: '0%',
          },
          {
            name: 'Lollipop',
            calories: 392,
            fat: 0.2,
            carbs: 98,
            protein: 0,
            sodium: 38,
            calcium: '0%',
          },
          {
            name: 'Honeycomb',
            calories: 408,
            fat: 3.2,
            carbs: 87,
            protein: 6.5,
            sodium: 562,
            calcium: '0%',
          },
          {
            name: 'Donut',
            calories: 452,
            fat: 25.0,
            carbs: 51,
            protein: 4.9,
            sodium: 326,
            calcium: '2%',
          },
          {
            name: 'KitKat',
            calories: 518,
            fat: 26.0,
            carbs: 65,
            protein: 7,
            sodium: 54,
            calcium: '12%',
          },
        ],
      }
  },
  components: {
    LoadingOverlay,
  },
  computed: {
      numberOfPages () {
        return Math.ceil(this.items.length / this.itemsPerPage)
      },
      filteredKeys () {
        return this.keys.filter(key => key !== 'Name')
      },
    },
  mounted() {
    this.getEmployees();

    document.title = "List | EmployeeApp";
  },
  methods: {
    getIcon(index) {
      let val = parseInt(index) + 1;
      return `mdi-numeric-${val}-circle-outline`;
    },
    nextPage () {
      if (this.page + 1 <= this.numberOfPages) this.page += 1
    },
    formerPage () {
      if (this.page - 1 >= 1) this.page -= 1
    },
    updateItemsPerPage (number) {
      this.itemsPerPage = number
    },
    async getEmployees() {
      this.$store.commit("setIsLoading", true);
      await setTimeout(console.log("test"), 3000);

      // await axios
      //   .get("/api/v1/latest-products")
      //   .then((response) => {
      //     this.employees = response.data;
      //   })
      //   .catch((error) => {
      //     console.log(error);
      //   });

      this.$store.commit("setIsLoading", false);
    },
  },
};
</script>
