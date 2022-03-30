<template>
  <v-app>
    <v-app-bar app dense class="mobile-app-bar">
      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <v-toolbar-title>Elulacms</v-toolbar-title>
    </v-app-bar>
    <sidebar app v-bind:collections="allCollections"></sidebar>
    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
    <!-- success snackbar -->
    <v-snackbar
      :timeout="-1"
      absolute
      bottom
      color="success"
      outlined
      right
      v-model="success"
    >
      Successfully Loaded data
      <template v-slot:action="{ attrs }">
        <v-btn color="green" text v-bind="attrs" @click="success = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>
    <!-- error -->
    <v-alert
      v-if="!collectionsLoaded"
      color="red"
      dark
      dense
      prominent
      align="center"
      style="z-index: 99; margin-right: 10%; margin-left: 10%"
      type="error"
    >
      <v-row align="center">
        <v-col class="grow">
          Some sort of error has occured. Please check your connection.
        </v-col>
        <v-col class="shrink">
          <v-btn
            @click="refreshPage()"
            outlined
            class="black--text"
            color="white"
            >Refresh page<v-icon>mdi-refresh</v-icon></v-btn
          >
        </v-col>
      </v-row>
    </v-alert>
  </v-app>
</template>

<script>
import sidebar from "./layout/sidebar.vue";

export default {
  components: {
    sidebar: sidebar,
  },
  data: () => ({
    success: false,
  }),
  computed: {
    collections() {
      return this.$store.getters.getCollections;
    },
    allCollections() {
      return this.$store.getters.getAllCollections;
    },
    collectionsLoaded() {
      return this.$store.getters.getCollectionsLoaded;
    },
  },
  mounted() {
    this.loadCollections();
  },
  methods: {
    refreshPage() {
      location.reload();
    },
    loadCollections() {
      this.$store.dispatch("fetchCollections");
    },
  },
};
</script>
