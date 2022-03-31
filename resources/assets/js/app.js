window._ = require("lodash");

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Vue from "vue";
window.Vue = require("vue").default;

import VueRouter from "vue-router";
Vue.use(VueRouter);

import vuetify from "./vuetify";

//VUE COMPONENTS
import app from "./components/app";
import sidebar from "./components/layout/sidebar";
//pages
import dashboard from "./components/pages/dashboard";
import collection from "./components/pages/collection";
import settings from "./components/pages/settings";
import media from "./components/pages/media";
//dashboard Components
import createCollectionModal from "./components/pages/dashboard/create-collection-modal";
import editCollectionModal from "./components/pages/dashboard/edit-collection-modal";
import addEntry from "./components/pages/add-entry";
import editEntry from "./components/pages/edit-entry";

const routes = [
  {
    path: "/cms/dashboard",
    name: "dashboard",
    component: dashboard,
  },
  {
    path: "/cms/dashboard/collection/:name",
    name: "collection",
    component: collection,
    props: true,
  },
  {
    path: "/cms/dashboard/:name/edit/:id",
    name: "edit-entry",
    component: editEntry,
    props: true,
  },
  {
    path: "/cms/dashboard/:name/add-entry",
    name: "add-entry",
    component: addEntry,
    props: true,
  },
  {
    path: "/cms/dashboard/media",
    name: "media",
    component: media,
  },
  {
    path: "/cms/dashboard/settings",
    name: "settings",
    component: settings,
  },
];

const router = new VueRouter({
  mode: "history",
  routes: routes,
});

import Vuex from "vuex";
import storeData from "./store/globalStore";
Vue.use(Vuex);
const store = new Vuex.Store(storeData);

const main = new Vue({
  el: "#app",
  vuetify,
  components: {
    app: app,
    sidebar: sidebar,
    createCollectionModal: createCollectionModal,
  },
  router,
  store,
});
