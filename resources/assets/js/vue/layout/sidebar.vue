<template>
  <div>
    <v-app-bar color="white" app dense class="mobile-app-bar" elevation="1">
      <v-toolbar-title class="white--black">Elulacms</v-toolbar-title>
      <v-app-bar-nav-icon
        color="black"
        @click.stop="drawer = !drawer"
      ></v-app-bar-nav-icon>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" app>
      <v-list>
        <v-list-item-group color="accent">
          <v-list-item two-line>
            <v-list-item-avatar>
              <img
                src="https://images.unsplash.com/photo-1647872963304-d81d51243285?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=435&q=80"
              />
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title class="text-h6 font-weight-bold"
                >Elulacms</v-list-item-title
              >
              <v-list-item-subtitle>Admin</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <!-- <v-divider></v-divider>
          <v-list-item link>
            <v-list-item-title class="text-h7">Add entry</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-pencil-outline</v-icon>
            </v-list-item-icon>
          </v-list-item> -->
          <v-divider></v-divider>
          <v-list-item link @click="$refs.myDialog.open()">
            <v-list-item-title class="text-h7"
              >Create new collection</v-list-item-title
            >
            <v-list-item-icon>
              <v-icon>mdi-plus</v-icon>
            </v-list-item-icon>
          </v-list-item>

          <v-divider></v-divider>
          <br />
          <v-list-group group="/cms/dashboard">
            <!-- title -->
            <template v-slot:activator>
              <v-list-item-icon>
                <v-icon>mdi-animation-outline</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Collections</v-list-item-title>
            </template>

            <v-list-item
              v-for="(item, index) in collections"
              :key="index"
              link
              class="ml-5"
              :to="{
                path: '/cms/dashboard/collection/' + item.name,
                params: { name: item.name },
              }"
            >
              <v-list-item-icon>
                <v-icon color="accent" size="small">mdi-circle</v-icon>
              </v-list-item-icon>
              <v-list-item-title class="text-h7">{{
                item.name
              }}</v-list-item-title>
            </v-list-item>
          </v-list-group>

          <v-list-item link :to="{ name: 'media' }">
            <v-list-item-icon>
              <v-icon>mdi-folder-multiple-image</v-icon>
            </v-list-item-icon>
            <v-list-item-title class="text-h7">Media</v-list-item-title>
          </v-list-item>

          <v-list-item link :to="{ name: 'settings' }">
            <v-list-item-icon>
              <v-icon>mdi-cog</v-icon>
            </v-list-item-icon>
            <v-list-item-title class="text-h7">Settings</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
      <!-- Create collection Modal -->
      <createCollectionModal ref="myDialog"></createCollectionModal>
    </v-navigation-drawer>
  </div>
</template>

<script>
import createCollectionModal from "../pages/collection/modals/create-collection-modal";

export default {
  components: {
    createCollectionModal: createCollectionModal,
  },
  props: ["collections"],
  data: () => ({
    drawer: true,
    openCreateCollection: false,
  }),
};
</script>
