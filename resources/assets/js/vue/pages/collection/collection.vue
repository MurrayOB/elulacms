<template>
  <div v-if="collection">
    <div class="mt-4 pl-4">
      <h4>Collection:</h4>
      <h1>
        {{ capitalizeFirstLetter(collection.name) }}
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
      <!-- TABLE -->
      <collectionTable :name="name" :collection="collection"></collectionTable>
    </div>
    <!-- edit collection Modal -->
    <editCollectionModal ref="editCollectionDialog"></editCollectionModal>
  </div>
</template>

<script>
import editCollectionModal from "./modals/edit-collection-modal";
import collectionTable from "./components/table";

export default {
  components: {
    editCollectionModal,
    collectionTable,
  },
  props: ["name"],
  data: () => ({}),
  methods: {
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
  },
  computed: {
    collection() {
      return this.$store.getters.singleCollection(this.name);
    },
  },
};
</script>
