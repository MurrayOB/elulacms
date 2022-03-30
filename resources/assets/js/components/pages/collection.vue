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

        <v-btn style="float: right" class="mr-4" text color="primary">
          Add Entry <v-icon>mdi-plus</v-icon></v-btn
        >
      </h1>

      <br /><br />
      <table style="width: 100%" v-if="collection">
        <!-- Columns -->
        <tr>
          <th v-for="(value, name) in collection.data[0]" :key="name">
            {{ name }}
          </th>
        </tr>
        <!-- Data / Rows -->
        <tr v-for="value in collection.data" :key="value.id">
          <td v-for="(val, i) in value" :key="'data-row-' + i">
            {{ val }}
          </td>
          <td>
            <v-btn text color="red" v-if="value.published">unpublish</v-btn>
            <v-btn text color="green" v-if="!value.published"> publish </v-btn>
          </td>
          <td>
            <button>
              <v-btn color="primary" icon plain>
                <v-icon> mdi-pencil </v-icon>
              </v-btn>
            </button>
          </td>
          <td>
            <button>
              <v-btn color="red" icon plain>
                <v-icon> mdi-delete </v-icon>
              </v-btn>
            </button>
          </td>
        </tr>
      </table>
    </div>
    <!-- edit collection Modal -->
    <editCollectionModal ref="editCollectionDialog"></editCollectionModal>
  </div>
</template>

<script>
import editCollectionModal from "../pages/dashboard/edit-collection-modal";

export default {
  components: {
    editCollectionModal,
  },
  props: ["name"],
  data: () => ({}),
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
