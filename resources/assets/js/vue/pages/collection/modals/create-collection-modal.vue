<template>
  <v-row justify="center">
    <v-dialog v-model="showDialog" persistent max-width="800px">
      <v-form
        id="create-collection-form"
        ref="form"
        v-model="valid"
        lazy-validation
      >
        <v-card>
          <v-card-title>
            <span class="text-h6">Create Collection: </span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row class="collection-name">
                <v-col cols="12" md="6">
                  <v-text-field
                    :rules="collectionNameRules"
                    v-model="collection.name"
                    label="Collection Name*"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>
              <!-- Single Field -->
              <v-row v-for="(value, index) in collection.fields" :key="index">
                <!-- Field Name -->
                <v-col cols="12" md="5">
                  <v-text-field
                    v-model="value.title"
                    label="Field Name*"
                    :rules="fieldNameRules"
                    required
                  ></v-text-field>
                </v-col>
                <!-- Select Field Type -->
                <v-col cols="12" md="6">
                  <v-row>
                    <v-col cols="12" md="">
                      <v-select
                        label="Select Field Type*"
                        required
                        :items="items"
                        item-text="name"
                        item-value="id"
                        :rules="fieldTypeRules"
                        v-model="value.id"
                      >
                        <!-- select value -->
                        <template v-slot:selection="data">
                          <div
                            v-bind="data.attrs"
                            :input-value="data.selected"
                            close
                            @click="data.select"
                          >
                            <v-avatar left>
                              <i :class="data.item.avatar" />
                            </v-avatar>
                            {{ data.item.name }}
                          </div>
                        </template>
                        <!-- select list: -->
                        <template v-slot:item="data">
                          <template>
                            <v-list-item-avatar>
                              <i :class="data.item.avatar" />
                            </v-list-item-avatar>
                            <v-list-item-content>
                              <v-list-item-title
                                v-html="data.item.name"
                              ></v-list-item-title>
                              <v-list-item-subtitle
                                v-html="data.item.desc"
                              ></v-list-item-subtitle>
                            </v-list-item-content>
                          </template>
                        </template>
                      </v-select>
                    </v-col>
                    <!-- Field Settings -->
                    <v-col cols="12" md="4">
                      <v-select
                        :items="fieldSettings"
                        multiple
                        label="Settings"
                        item-text="name"
                        item-value="name"
                      >
                        <template v-slot:selection="data">
                          <div
                            v-bind="data.attrs"
                            :input-value="data.selected"
                            close
                            @click="data.select"
                          >
                            {{ data.item.name }}
                          </div>
                        </template></v-select
                      >
                    </v-col>
                    <v-col cols="12" md="1"
                      ><v-btn
                        v-if="index !== 0"
                        color="red"
                        @click="removeField(index)"
                        class="mt-3"
                        icon
                        ><v-icon>mdi-delete</v-icon></v-btn
                      ></v-col
                    >
                  </v-row>
                </v-col>
              </v-row>
              <v-row>
                <v-btn @click="addField()" text color="primary"
                  >Add another field <v-icon>mdi-plus</v-icon></v-btn
                >
              </v-row>
            </v-container>
          </v-card-text>
          <!-- Form Error -->
          <v-alert
            v-if="valid == false && submitted"
            color="red"
            dark
            dense
            prominent
            align="center"
            type="error"
          >
            <v-row align="center"> This form has errors. </v-row>
          </v-alert>
          <!-- Form Success -->
          <v-alert v-if="success" dense prominent align="center" type="success">
            <v-row align="center"> Successfully created collection. </v-row>
          </v-alert>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text @click="close()"> Cancel </v-btn>
            <v-btn color="primary" text @click.stop="saveCollection()">
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  data() {
    const fieldTypeImages = {
      1: "ri-text",
      2: "ri-file-text-line",
      3: "ri-image-line",
      4: "ri-text",
      5: "ri-text",
    };

    return {
      valid: false,
      dialogRef: "myDialog",
      showDialog: false,
      submitted: false,
      success: false,
      items: [
        {
          name: "Text",
          desc: "Description one",
          avatar: fieldTypeImages[1],
          id: 1,
        },
        {
          name: "Rich Text",
          desc: "Description two",
          avatar: fieldTypeImages[2],
          id: 2,
        },
        {
          name: "Image",
          desc: "Description three",
          avatar: fieldTypeImages[3],
          id: 3,
        },
      ],
      fieldSettings: [{ name: "Nullable" }, { name: "Password" }],
      collection: {
        name: "",
        fields: [{ title: "", id: null }],
      },
      // Form Rules
      collectionNameRules: [(v) => !!v || "Collection name is required"],
      fieldNameRules: [(v) => !!v || "Field name is required"],
      fieldTypeRules: [(v) => !!v || "Field type is required"],
    };
  },
  methods: {
    open() {
      this.showDialog = true;
    },
    close() {
      this.showDialog = false;
      this.collection = {
        name: "",
        fields: [{ title: "", id: null }],
      };
      this.$refs.form.resetValidation();
      this.$refs.form.reset();
    },
    addField() {
      this.collection.fields.push({ name: "", type: null });
    },
    removeField(index) {
      this.collection.fields.splice(index, 1);
    },
    saveCollection() {
      const validForm = this.$refs.form.validate();
      this.valid = validForm;
      this.submitted = true;

      if (!validForm) {
        return;
      }

      this.submitted = false;

      this.$store.dispatch("createCollection", {
        collectionName: this.collection.name,
        fieldsArray: this.collection.fields,
      });

      //Must get an API response
      this.close();
    },
  },
};
</script>
<style>
.collection-name {
  background-color: rgb(245, 245, 245);
  padding: 0.5rem;
  border-radius: 3px;
}
</style>
