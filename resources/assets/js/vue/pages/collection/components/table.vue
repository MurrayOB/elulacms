<style>
.text-center {
  text-align: center !important;
}
td {
  /* border: 1px solid rgb(87, 87, 87); */
}

.table {
  width: 100%;
  border-radius: 10px;
  background-color: rgb(250, 250, 250);
}

.headers {
}

tr th {
  background-color: rgb(250, 250, 250);
}

th,
td {
  padding: 5px;
  background-color: white;
}
</style>
<template>
  <div>
    <!-- headers -->
    <div class="headers" v-if="collection.data.length">
      <v-card class="d-flex flex-row" flat tile>
        <v-card class="pr-4 justify-center align-center" flat tile>
          <v-select
            style="max-width: 4rem"
            v-model="maxShowAmount"
            :items="showAmounts"
            label="Showing"
          ></v-select>
        </v-card>
        <v-card flat tile class="pt-4">
          <p>
            Fetched
            <span style="color: blue">{{ collection.data.length }}</span>
            total entries.
          </p>
        </v-card>
      </v-card>
    </div>
    <!-- TABLE -->
    <table class="table" v-if="collection">
      <!-- COLUMNS -->
      <tr v-if="collection.data.length > 0" class="table-headers">
        <th class="d-flex align-center justify-center">
          <v-checkbox value></v-checkbox>
        </th>
        <template v-for="(value, name) in collection.data[0]">
          <th
            v-if="
              !(
                name == 'published' ||
                name == 'created_at' ||
                name == 'updated_at'
              )
            "
            :key="name"
          >
            {{ capitalizeFirstLetter(name) }}
          </th>
        </template>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Status</th>
        <th></th>
      </tr>
      <!-- DATA / ROWS -->
      <tr
        v-for="value in collection.data
          .slice()
          .reverse()
          .slice(
            0,
            maxShowAmount !== 'max' ? maxShowAmount : collection.data.length
          )"
        :key="value.id"
      >
        <!-- checkbox -->
        <td class="d-flex align-center justify-center">
          <v-checkbox value @click="checkSingleEntry(value)"></v-checkbox>
        </td>
        <!-- DYNAMIC VALUES -->
        <template v-for="(val, name, i) in value">
          <template
            v-if="
              !(
                name == 'published' ||
                name == 'created_at' ||
                name == 'updated_at'
              )
            "
          >
            <td
              :key="'data-row-' + i"
              v-bind:class="{
                'text-center': name == 'id',
              }"
            >
              {{ val }}
            </td>
          </template>
        </template>
        <!-- PUBLISH BTN or unpublish entry button -->
        <td class="text-center">{{ formatDate(value.created_at) }}</td>
        <td class="text-center">{{ formatDate(value.updated_at) }}</td>
        <td class="text-center">
          <v-btn
            text
            color="red"
            v-if="value.published"
            @click="showPublishDialog(value)"
            >unpublish</v-btn
          >
          <v-btn
            text
            color="green"
            v-if="!value.published"
            @click="showPublishDialog(value)"
          >
            publish
          </v-btn>
        </td>
        <td>
          <!--  EDIT PENCIL entry button -->
          <button>
            <v-btn
              link
              :to="{
                path: '/cms/dashboard/' + collection.name + '/edit/' + value.id,
                params: { name: collection.name, id: value.id },
              }"
              color="primary"
              icon
              plain
            >
              <v-icon> mdi-pencil </v-icon>
            </v-btn>
          </button>
          <!-- DELETE entry button -->
          <button>
            <v-btn @click="showDeleteDialog(value.id)" color="red" icon plain>
              <v-icon> mdi-delete </v-icon>
            </v-btn>
          </button>
        </td>
      </tr>
      <br />
    </table>
    <br />
    <br />
    <!-- DELETE DIALOG -->
    <v-dialog v-model="deleteDialog" persistent max-width="290">
      <v-card>
        <v-card-title class="text-h5 justify-center"
          >Are you sure?</v-card-title
        >
        <v-card-text class="justify-center"
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
    <!-- PUBLISH DIALOG -->
    <v-dialog v-model="publishDialog" persistent max-width="290">
      <v-card>
        <v-card-title class="text-h5 justify-center"
          >Are you sure?</v-card-title
        >
        <v-card-text class="justify-center"
          >Are you sure you want to publish this entry?</v-card-text
        >
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="publishDialog = false">
            Cancel
          </v-btn>
          <v-btn
            color="red darken-1"
            text
            @click="
              publishEntry();
              publishDialog = false;
            "
          >
            Yes I'm sure
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- pagination -->
    <!-- <div v-if="collection.data.length" class="text-center">
      <v-container>
        <v-row justify="center">
          <v-col cols="8">
            <v-container class="max-width">
              <v-pagination class="my-4" :length="15"></v-pagination>
            </v-container>
          </v-col>
        </v-row>
      </v-container>
    </div> -->
  </div>
</template>

<script>
export default {
  props: { collection: null, name: "" },
  data: () => ({
    deleteDialog: false,
    deleteEntryId: null,
    publishDialog: false,
    publishEntryId: null,
    maxShowAmount: 5,
    showAmounts: [5, 10, 50, 100, "max"],
    selectedEntries: [],
  }),
  methods: {
    checkSingleEntry(value) {
      const entryId = JSON.parse(JSON.stringify(value.id));
      const containsId = this.selectedEntries.some((el) => {
        return el === entryId;
      });
      if (containsId) {
        const entryIndex = this.selectedEntries.indexOf(entryId);
        this.selectedEntries.splice(entryIndex, 1);
        return;
      }

      if (!containsId) this.selectedEntries.push(entryId);
    },
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    showDeleteDialog(id) {
      this.deleteDialog = true;
      this.deleteEntryId = id;
    },
    deleteEntry() {
      //delete multiple using api
      if (this.selectedEntries.length) {
        //api call
        console.log(this.selectedEntries);
        //clear array
        this.selectedEntries = [];
        return;
      }

      //delete single
      this.$store.dispatch("deleteEntry", {
        id: this.deleteEntryId,
        collectionName: this.name,
      });
    },
    showPublishDialog(entry) {
      this.publishDialog = true;
      this.publishEntryId = entry.id;
    },
    publishEntry() {
      this.$store.dispatch("publishEntry", {
        id: this.publishEntryId,
        collectionName: this.name,
      });
    },
    formatDate(date) {
      const formattedDate = new Date();
      const time = date.substring(10).substring(0, 6);
      return formattedDate.toDateString() + "," + time;
    },
  },
};
</script>
