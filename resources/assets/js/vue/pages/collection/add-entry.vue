<template>
  <div>
    <v-col>
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
    </v-col>
    <h2 class="ml-4">
      <span class="font-weight-light">Add entry to</span> {{ name }}
    </h2>
    <br />
    <div v-if="collection" class="ml-2">
      <v-form id="entry-form" ref="form" lazy-validation v-model="formValid">
        <div v-for="(value, index) in collection.fields" v-bind:key="index">
          <!-- plain input -->
          <v-row>
            <v-col cols="12" sm="12" md="4" v-if="value.type == 1">
              <v-text-field
                outlined
                v-model="entry[index]"
                :label="value.name"
                :placeholder="value.name"
              ></v-text-field>
            </v-col>
          </v-row>
          <!-- richtext -->
          <v-row>
            <v-col cols="12" sm="12" md="6" v-if="value.type == 2">
              <v-textarea
                v-model="entry[index]"
                outlined
                :label="value.name"
              ></v-textarea>
            </v-col>
          </v-row>
        </div>
        <v-checkbox
          v-model="publish"
          label="publish"
          color="primary"
        ></v-checkbox>
        <v-btn @click="saveEntry" outlined color="primary"
          >save<v-icon right>mdi-check</v-icon></v-btn
        >
      </v-form>
    </div>
  </div>
</template>

<script>
export default {
  props: ["name"],
  data: () => ({
    entry: [],
    formValid: true,
    publish: false,
  }),
  methods: {
    saveEntry() {
      const validForm = this.$refs.form.validate();
      if (!validForm) {
        return;
      }
      let formData = [];
      this.collection.fields.forEach((el, index) => {
        formData.push({ columnName: el.name, value: this.entry[index] });
      });

      const payload = {
        collectionName: this.name,
        formData: formData,
      };
      this.$store.dispatch("addEntry", {
        payload: payload,
      });
      this.$router.push("/cms/dashboard/collection/" + this.name);
    },
  },
  computed: {
    collection() {
      return this.$store.getters.singleCollection(this.name);
    },
  },
};
</script>
