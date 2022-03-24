<template>
  <v-app>
    <sidebar app v-bind:collections="collections"></sidebar>
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
    <v-snackbar v-model="errorSnackBar">
      There was an error
      <template v-slot:action="{ attrs }">
        <v-btn color="pink" text v-bind="attrs" @click="errorSnackBar = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </v-app>
</template>

<script>
import sidebar from "./layout/sidebar.vue";

export default {
  components: {
    sidebar: sidebar,
  },
  data: () => ({
    errorSnackBar: false,
    success: false,
  }),
  computed: {
    collections() {
      return this.$store.getters.getCollections;
    },
  },
  mounted() {
    this.$store.dispatch("fetchCollections");
  },
};
</script>
