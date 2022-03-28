<template>
  <v-row justify="center">
    <v-dialog v-model="showDialog" persistent max-width="800px">
      <v-card>
        <v-card-title>
          <span class="text-h6">Create Collection: </span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row class="collection-name">
              <v-col cols="12" md="6">
                <v-text-field label="Collection Name*" required></v-text-field>
              </v-col>
            </v-row>
            <!-- Single Field -->
            <v-row>
              <!-- Field Name -->
              <v-col cols="12" md="5">
                <v-text-field label="Field Name*" required></v-text-field>
              </v-col>
              <!-- Select Field Type -->
              <v-col cols="12" md="6">
                <v-row>
                  <v-col cols="12" md="7">
                    <v-select
                      label="Select Field Type*"
                      required
                      :items="items"
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
                          <v-avatar left>
                            <i :class="data.item.avatar" />
                          </v-avatar>
                          {{ data.item.name }}
                        </div>
                      </template>
                      <template v-slot:item="data">
                        <template v-if="typeof data.item !== 'object'">
                          <v-list-item-content
                            v-text="data.item"
                          ></v-list-item-content>
                        </template>
                        <template v-else>
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
                      label="Settings*"
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
                    ><v-btn class="mt-3" icon
                      ><v-icon>mdi-delete</v-icon></v-btn
                    ></v-col
                  >
                </v-row>
              </v-col>
            </v-row>
            <v-row>
              <v-btn text color="primary"
                >Add another field <v-icon>mdi-plus</v-icon></v-btn
              >
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="showDialog = false">
            Close
          </v-btn>
          <v-btn color="blue darken-1" text @click="dialog = false">
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
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
      dialogRef: "myDialog",
      showDialog: false,
      items: [
        { name: "Text", desc: "Description one", avatar: fieldTypeImages[1] },
        {
          name: "Rich Text",
          desc: "Description two",
          avatar: fieldTypeImages[2],
        },
        {
          name: "Image",
          desc: "Description three",
          avatar: fieldTypeImages[3],
        },
      ],
      fieldSettings: [{ name: "Nullable" }, { name: "Password" }],
    };
  },
  methods: {
    open() {
      this.showDialog = true;
    },
    close() {
      this.showDialog = false;
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
