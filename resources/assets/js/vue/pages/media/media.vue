<style>
.all-media {
  min-height: 10rem;
  width: 100%;
}
</style>
<template>
  <div>
    <h1 class="ml-4">Media</h1>
    <br />
    <h2 class="ml-4 font-weight-light">
      Upload Media
      <span
        ><v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-icon color="grey lighten-1" dark v-bind="attrs" v-on="on">
              mdi-information
            </v-icon>
          </template>
          <span>You can upload multiple files at the same. </span>
        </v-tooltip></span
      >
    </h2>
    <!-- FORM -->
    <v-form ref="form">
      <v-row>
        <v-col cols="12" sm="12" md="6">
          <!-- UPLOAD INPUT -->
          <v-file-input
            class="pb-1"
            :rules="fileUploadRules"
            required
            counter
            show-size
            v-model="file"
            label="Upload image"
          ></v-file-input>
          <!-- PROGRESS INDICATOR -->
          <v-row v-if="progress !== 0" class="ml-4">
            <v-col cols="12" sm="12" md="6">
              <v-progress-linear v-model="progress"> </v-progress-linear>
              <strong>{{ progress }} %</strong>
            </v-col>
          </v-row>
          <!-- SUBMIT BUTTON -->
          <v-btn @click="uploadFile()" class="ml-4">upload</v-btn>
        </v-col>
      </v-row>
      <br />
    </v-form>

    <!-- ALL MEDIA -->
    <br />
    <h2 class="ml-4 font-weight-light">View Media</h2>
    <div class="all-media"></div>
  </div>
</template>

<script>
export default {
  data: () => ({
    file: null,
    progress: 0,
    fileUploadRules: [(v) => !!v || "Image is required"],
  }),
  methods: {
    uploadFile() {
      const validForm = this.$refs.form.validate();
      if (!validForm) {
        return;
      }

      console.log(this.file);
      this.$store.dispatch("uploadFiles", { files: this.file });
    },
  },
};
</script>
