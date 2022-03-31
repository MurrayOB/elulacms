<template>
  <div>
    <v-btn
      link
      :to="{
        path: '/cms/dashboard/collection/' + name,
      }"
      text
      color="primary"
    >
      <v-icon left>mdi-chevron-left</v-icon>back</v-btn
    >
    <br />
    <v-row>
      <v-col>
        <h2 class="ml-4">Edit Entry</h2>
      </v-col>
      <v-col>
        <v-btn
          link
          :to="{
            path: '/cms/dashboard/collection/' + name,
          }"
          text
          color="primary float-right"
        >
          unpublish</v-btn
        >
        <v-btn
          link
          :to="{
            path: '/cms/dashboard/collection/' + name,
          }"
          text
          color="success float-right"
        >
          publish</v-btn
        >
        <v-btn
          link
          :to="{
            path: '/cms/dashboard/collection/' + name,
          }"
          text
          color="error float-right"
        >
          delete entry</v-btn
        >
      </v-col>
    </v-row>
    <div v-for="(field, index) in entryFields" v-bind:key="index">
      <v-col cols="12" sm="12" md="4">
        <v-text-field
          outlined
          v-model="entry[field.name]"
          :label="field.name"
          :placeholder="field.name"
        ></v-text-field>
      </v-col>
    </div>
  </div>
</template>

<script>
export default {
  props: ["name", "id"],
  data: () => ({}),
  methods: {},
  computed: {
    entry() {
      return this.$store.getters
        .singleCollection(this.name)
        ?.data.find((p) => p.id == this.id);
    },
    entryFields() {
      return this.$store.getters.singleCollection(this.name)?.fields;
    },
  },
};
</script>
