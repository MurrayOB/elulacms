<template>
  <div v-if="collection">
    <div class="mt-4 pl-4">
      <h4>Collection:</h4>
      <h1>
        {{ collection.name }}
        <span
          ><button>
            <v-btn
              color="gray"
              icon
              plain
              @click="$refs.editCollectionDialog.open(collection.id)"
            >
              <v-icon size="16"> mdi-pencil </v-icon>
            </v-btn>
          </button></span
        >

        <v-btn
          link
          :to="{
            path: '/cms/dashboard/' + collection.name + '/add-entry',
            params: { name: collection.name },
          }"
          class="mr-4"
          text
          color="primary"
        >
          Add Entry <v-icon right>mdi-plus</v-icon></v-btn
        >
      </h1>

      <br /><br />
      <p v-if="!collection.data.length">You have no data.</p>
      <p v-if="collection.data.length">
        Fetched
        <span style="color: blue">{{ collection.data.length }}</span> rows.
      </p>
      <!-- TABLE -->
      <table style="width: 100%" v-if="collection">
        <!-- COLUMNS -->
        <tr>
          <th v-for="(value, name) in collection.data[0]" :key="name">
            {{ name }}
          </th>
        </tr>
        <!-- DATA / ROWS -->
        <tr v-for="value in collection.data.slice().reverse()" :key="value.id">
          <!-- DYNAMIC VALUES -->
          <td v-for="(val, i) in value" :key="'data-row-' + i">
            {{ val }}
          </td>
          <!-- PUBLISH BTN or unpublish entry button -->
          <td>
            <v-btn text color="red" v-if="value.published">unpublish</v-btn>
            <v-btn text color="green" v-if="!value.published"> publish </v-btn>
          </td>
          <!--  EDIT PENCIL entry button -->
          <td>
            <button>
              <v-btn
                link
                :to="{
                  path:
                    '/cms/dashboard/' + collection.name + '/edit/' + value.id,
                  params: { name: collection.name, id: value.id },
                }"
                color="primary"
                icon
                plain
              >
                <v-icon> mdi-pencil </v-icon>
              </v-btn>
            </button>
          </td>
          <!-- DELETE entry button -->
          <td>
            <button>
              <v-btn @click="showDeleteDialog(value.id)" color="red" icon plain>
                <v-icon> mdi-delete </v-icon>
              </v-btn>
            </button>
          </td>
        </tr>
      </table>
    </div>
    <!-- edit collection Modal -->
    <editCollectionModal ref="editCollectionDialog"></editCollectionModal>
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
  </div>
</template>

<script>
import editCollectionModal from "./modals/edit-collection-modal";

export default {
  components: {
    editCollectionModal,
  },
  props: ["name"],
  data: () => ({
    deleteDialog: false,
    deleteEntryId: null,
  }),
  methods: {
    showDeleteDialog(id) {
      this.deleteDialog = true;
      this.deleteEntryId = id;
    },
    deleteEntry() {
      this.$store.dispatch("deleteEntry", {
        id: this.deleteEntryId,
        collectionName: this.name,
      });
    },
  },
  computed: {
    collection() {
      return this.$store.getters.singleCollection(this.name);
    },
  },
};
</script>
<style>
td {
  border: 1px solid rgb(87, 87, 87);
}

th,
td {
  padding: 5px;
}
</style>
