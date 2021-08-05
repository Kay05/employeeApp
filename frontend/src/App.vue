<template>
  <v-app>
    <v-card app color="grey lighten-4" flat tile>
      <v-app-bar dark fixed app>
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
        <v-toolbar-title @click="goto">Employee App</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items class="hidden-sm-and-down">
          <div v-if="$route.path !== '/new-employee'" class="my-2">
            <v-btn
              color="purple"
              dark
              rounded
              to="/new-employee"
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
                      <v-list-item-subtitle>Owner</v-list-item-subtitle>
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
        </v-toolbar-items>
        <v-menu offset-y class="hidden-md-and-up">
          <template v-slot:activator="{ on, attrs }">
            <v-app-bar-nav-icon
              v-bind="attrs"
              v-on="on"
              class="hidden-md-and-up"
              slot="activator"
            >
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
  }),
  methods: {
    goto() {
      if (this.$route.path === "/") {
        return;
      }

      this.$router.push({ path: "/" });
    },
  },
};
</script>
