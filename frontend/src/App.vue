<template>
  <v-app>
    <v-card app color="grey lighten-4" flat tile>
      <v-app-bar  dark fixed app>
        <v-app-bar-nav-icon>
          <div class="d-flex align-center">
            <v-img
              alt="Vuetify Logo"
              class="shrink mr-2"
              contain
              src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
              transition="scale-transition"
              width="40"
            />
          </div>
        </v-app-bar-nav-icon>
        <v-toolbar-title>Employee App</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items class="hidden-sm-and-down">
          <!-- <v-autocomplete
          v-model="model"
          :items="items"
          :loading="isLoading"
          :search-input.sync="search"
          chips
          clearable
          hide-details
          hide-selected
          item-text="name"
          item-value="symbol"
          label="Search for an employee..."
          solo
          style="margin-top:7px;"
        >
          <template v-slot:no-data>
            <v-list-item>
              <v-list-item-title>
                Search for an 
                <strong>Employee</strong>
              </v-list-item-title>
            </v-list-item>
          </template>
          <template v-slot:selection="{ attr, on, item, selected }">
            <v-chip
              v-bind="attr"
              :input-value="selected"
              color="blue-grey"
              class="white--text"
              v-on="on"
            >
              <v-icon left>
                mdi-account-multiple
              </v-icon>
              <span v-text="item.name"></span>
            </v-chip>
          </template>
          <template v-slot:item="{ item }">
            <v-list-item-avatar
              color="indigo"
              class="text-h5 font-weight-light white--text"
            >
              {{ item.name.charAt(0) }}
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title v-text="item.name"></v-list-item-title>
              <v-list-item-subtitle v-text="item.symbol"></v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-account-multiple</v-icon>
            </v-list-item-action>
          </template>
        </v-autocomplete>

        <v-btn icon @click="showSearchBar = !showSearchBar">
          <v-icon>mdi-magnify</v-icon>
        </v-btn> -->
        <div v-if="$route.path !== '/new-employee'" class="my-2">
            <v-btn
              color="purple"
              dark
              rounded
              style="padding: 23px;"
            >
            <v-icon large left>
              mdi-plus-circle-outline
            </v-icon>
               <span style="margin-left:5px;">New Employee</span>
            </v-btn>
          </div>
          <div class="text-center" style="margin-top:10px; margin-left: 20px;">
          <v-menu
            v-model="menu"
            :close-on-content-click="false"
            :nudge-width="200"
            offset-x
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn dark v-bind="attrs" v-on="on">
                Kuda Dhliwayo
              </v-btn>
            </template>

            <v-card>
              <v-list>
                <v-list-item>
                  <v-list-item-avatar>
                    <img
                      src="https://cdn.vuetifyjs.com/images/john.jpg"
                      alt="John"
                    />
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <v-list-item-title>Kuda Dhliwayo</v-list-item-title>
                    <v-list-item-subtitle
                      >Owner</v-list-item-subtitle
                    >
                  </v-list-item-content>

                  <v-list-item-action>
                    <v-btn
                      :class="fav ? 'red--text' : ''"
                      icon
                      @click="fav = !fav"
                    >
                      <v-icon>mdi-heart</v-icon>
                    </v-btn>
                  </v-list-item-action>
                </v-list-item>
              </v-list>

              <v-divider></v-divider>

              <v-list>
                <v-list-item>
                  <v-list-item-action>
                    <small><v-icon>mdi-home</v-icon></small>
                  </v-list-item-action>
                  <v-list-item-title>
                    <small>Profile</small>
                  </v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-action>
                    <small><v-icon>mdi-lock</v-icon></small>
                  </v-list-item-action>
                  <v-list-item-title>
                    <small>Logout</small>
                  </v-list-item-title>
                </v-list-item>
              </v-list>
            </v-card>
          </v-menu>
        </div>
          <!-- <v-btn flat>test b</v-btn> -->
        </v-toolbar-items>
        <v-menu offset-y class="hidden-md-and-up">
          <template v-slot:activator="{ on, attrs }">
            <v-app-bar-nav-icon v-bind="attrs" v-on="on" class="hidden-md-and-up" slot="activator">
            </v-app-bar-nav-icon>
          </template>
          <v-list>
          <v-list-item>
            <v-list-item-title>
              <v-btn outlined><v-icon>mdi-home</v-icon> About</v-btn>
              </v-list-item-title>
          </v-list-item>
          <v-list-item>
            <v-list-item-title>
              <v-btn outlined><v-icon>mdi-lock</v-icon> Logout</v-btn>
              </v-list-item-title>
          </v-list-item>
        </v-list>
        </v-menu>
      </v-app-bar>

      <!-- <v-toolbar dark>
        <v-app-bar-nav-icon>
          <div class="d-flex align-center">
            <v-img
              alt="Vuetify Logo"
              class="shrink mr-2"
              contain
              src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
              transition="scale-transition"
              width="40"
            />
          </div>
        </v-app-bar-nav-icon>

        <v-toolbar-title>Employee App</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-autocomplete
          v-model="model"
          :items="items"
          :loading="isLoading"
          :search-input.sync="search"
          chips
          clearable
          hide-details
          hide-selected
          item-text="name"
          item-value="symbol"
          label="Search for an employee..."
          solo
        >
          <template v-slot:no-data>
            <v-list-item>
              <v-list-item-title>
                Search for an 
                <strong>Employee</strong>
              </v-list-item-title>
            </v-list-item>
          </template>
          <template v-slot:selection="{ attr, on, item, selected }">
            <v-chip
              v-bind="attr"
              :input-value="selected"
              color="blue-grey"
              class="white--text"
              v-on="on"
            >
              <v-icon left>
                mdi-account-multiple
              </v-icon>
              <span v-text="item.name"></span>
            </v-chip>
          </template>
          <template v-slot:item="{ item }">
            <v-list-item-avatar
              color="indigo"
              class="text-h5 font-weight-light white--text"
            >
              {{ item.name.charAt(0) }}
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title v-text="item.name"></v-list-item-title>
              <v-list-item-subtitle v-text="item.symbol"></v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action>
              <v-icon>mdi-account-multiple</v-icon>
            </v-list-item-action>
          </template>
        </v-autocomplete>

        <v-btn icon @click="showSearchBar = !showSearchBar">
          <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-spacer></v-spacer>

        <div class="my-2">
            <v-btn
              color="purple"
              dark
              rounded
              style="padding: 25px;"
            >
            <v-icon large left>
              mdi-plus-circle-outline
            </v-icon>
               <span style="margin-left:5px;">New Employee</span>
            </v-btn>
          </div>

        <div class="text-center" style="margin-left:45px;">
          <v-menu
            v-model="menu"
            :close-on-content-click="false"
            :nudge-width="200"
            offset-x
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn dark v-bind="attrs" v-on="on">
                Kuda Dhliwayo
              </v-btn>
            </template>

            <v-card>
              <v-list>
                <v-list-item>
                  <v-list-item-avatar>
                    <img
                      src="https://cdn.vuetifyjs.com/images/john.jpg"
                      alt="John"
                    />
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <v-list-item-title>Kuda Dhliwayo</v-list-item-title>
                    <v-list-item-subtitle
                      >Owner</v-list-item-subtitle
                    >
                  </v-list-item-content>

                  <v-list-item-action>
                    <v-btn
                      :class="fav ? 'red--text' : ''"
                      icon
                      @click="fav = !fav"
                    >
                      <v-icon>mdi-heart</v-icon>
                    </v-btn>
                  </v-list-item-action>
                </v-list-item>
              </v-list>

              <v-divider></v-divider>

              <v-list>
                <v-list-item>
                  <v-list-item-action>
                    <small><v-icon>mdi-home</v-icon></small>
                  </v-list-item-action>
                  <v-list-item-title>
                    <small>Profile</small>
                  </v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-action>
                    <small><v-icon>mdi-lock</v-icon></small>
                  </v-list-item-action>
                  <v-list-item-title>
                    <small>Logout</small>
                  </v-list-item-title>
                </v-list-item>
              </v-list>
            </v-card>
          </v-menu>
        </div>
      </v-toolbar> -->
    </v-card>

    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "App",

  data: () => ({
    fav: true,
    menu: false,
    message: false,
    hints: true,
    isLoading: false,
    items: [],
    model: null,
    search: null,
    tab: null,
    showSearchBar: false,
  }),
  methods: {

  },
  watch: {
    model (val) {
      if (val != null) this.tab = 0
      else this.tab = null
    },
    search (val) {
      // Items have already been loaded
      if (this.items.length > 0) return

      this.isLoading = true

      this.items = [
        {
          id: "bitcoin",
          name: "Bitcoin 1",
          symbol: "BC"
        },
        {
          id: "test1",
          name: "Test 1",
          symbol: "T1"
        },
        {
          id: "prac",
          name: "Practice",
          symbol: "P"
        },
        {
          id: "ud",
          name: "Udying 1",
          symbol: "UY"
        },
        {
          id: "d1",
          name: "Done 1",
          symbol: "D1"
        }
      ]

      this.isLoading = false

      // Lazily load input items
      // fetch('https://api.coingecko.com/api/v3/coins/list')
      //   .then(res => res.clone().json())
      //   .then(res => {
      //     this.items = res
      //   })
      //   .catch(err => {
      //     console.log(err)
      //   })
      //   .finally(() => (this.isLoading = false))
    },
  },
};
</script>
