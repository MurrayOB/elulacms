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
    <br />
    <!-- actions and header -->
    <v-row>
      <v-col>
        <h2 class="ml-4 font-weight-light">Edit Entry</h2>
        <br />
      </v-col>
      <v-col v-if="entry">
        <v-btn
          @click="published = !published"
          v-if="published"
          text
          color="primary float-right"
        >
          unpublish</v-btn
        >
        <v-btn
          @click="published = !published"
          text
          v-if="!published"
          color="success float-right"
        >
          publish</v-btn
        >
        <v-btn text color="error float-right" @click="deleteDialog = true">
          delete entry</v-btn
        >
      </v-col>
    </v-row>
    <!-- FORM -->
    <v-form v-model="formValid" id="editEntryForm" ref="form">
      <div v-for="(field, index) in entryFields" v-bind:key="index">
        <v-col cols="12" sm="12" md="4" v-if="field.type === 1">
          <v-text-field
            outlined
            v-model="entry[field.name]"
            :label="field.name"
            :placeholder="field.name"
          ></v-text-field>
        </v-col>

        <v-col cols="12" sm="12" md="6" v-if="field.type === 2">
          <v-textarea
            outlined
            v-model="entry[field.name]"
            :label="field.name"
            :placeholder="field.name"
          ></v-textarea>
        </v-col>
      </div>
    </v-form>
    <!-- END OF FORM -->
    <v-btn
      v-if="entryFields && entry"
      class="ml-4"
      @click="updateEntry"
      outlined
      color="primary"
      >update entry</v-btn
    >
    <!-- DELETE DIALOG -->
    <v-dialog v-model="deleteDialog" persistent max-width="290">
      <v-card>
        <v-card-title class="text-h5"> Are you sure?</v-card-title>
        <v-card-text
          >Are you sure you want to delete this entry? This cannot be undone
          once deleted.</v-card-text
        >
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="deleteDialog = false">
            Cancel
          </v-btn>
          <v-btn
            color="red darken-1"
            text
            @click="
              deleteEntry();
              deleteDialog = false;
            "
          >
            Yes I'm sure
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ["name", "id"],
  data: () => ({
    published: null,
    formValid: true,
    deleteDialog: false,
  }),
  methods: {
    deleteEntry() {
      this.$store.dispatch("deleteEntry", {
        id: this.id,
        collectionName: this.name,
      });
      this.$router.push("/cms/dashboard/collection/" + this.name);
    },
    updateEntry() {
      const validForm = this.$refs.form.validate();
      if (!validForm) {
        console.log("Invalid Form");
        return;
      }

      this.entry.published = this.published;
      this.$store.dispatch("updateEntry", {
        id: this.id,
        entry: this.entry,
        collectionName: this.name,
      });

      this.$router.push("/cms/dashboard/collection/" + this.name);
    },
  },
  computed: {
    entry() {
      return this.$store.getters.singleCollection(this.name)?.data
        ? JSON.parse(
            JSON.stringify(
              this.$store.getters
                .singleCollection(this.name)
                ?.data.find((p) => p.id == this.id)
            )
          )
        : [];
    },
    entryFields() {
      return this.$store.getters.singleCollection(this.name)?.fields;
    },
  },
  watch: {
    entry(newValue) {
      this.published = newValue.published;
    },
  },
  mounted() {
    this.entry ? (this.published = this.entry.published) : null;
  },
};
</script>
