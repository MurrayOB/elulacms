window._ = require("lodash");

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// VUE APP
import Vue from "vue";
window.Vue = require("vue").default;

import VueRouter from "vue-router";
Vue.use(VueRouter);

import vuetify from "./vue/vuetify";

//VUE COMPONENTS
import app from "./vue/app";
//layout
import sidebar from "./vue/layout/sidebar";
//auth
import login from "./vue/pages/auth/login";
//pages
import dashboard from "./vue/pages/dashboard";
import collection from "./vue/pages/collection/collection";
import settings from "./vue/pages/settings";
import media from "./vue/pages/media/media";
//dashboard Components
import createCollectionModal from "./vue/pages/collection/modals/create-collection-modal";
import editCollectionModal from "./vue/pages/collection/modals/edit-collection-modal";
import addEntry from "./vue/pages/collection/add-entry";
import editEntry from "./vue/pages/collection/edit-entry";

const routes = [
  {
    path: "/cms/login",
    name: "login",
    component: login,
    meta: { guest: true },
  },
  {
    path: "/cms/dashboard",
    name: "dashboard",
    component: dashboard,
    meta: { requiresAuth: true },
  },
  {
    path: "/cms/dashboard/collection/:name",
    name: "collection",
    component: collection,
    props: true,
    meta: { requiresAuth: true },
  },
  {
    path: "/cms/dashboard/:name/edit/:id",
    name: "edit-entry",
    component: editEntry,
    props: true,
    meta: { requiresAuth: true },
  },
  {
    path: "/cms/dashboard/:name/add-entry",
    name: "add-entry",
    component: addEntry,
    props: true,
    meta: { requiresAuth: true },
  },
  {
    path: "/cms/dashboard/media",
    name: "media",
    component: media,
    meta: { requiresAuth: true },
  },
  {
    path: "/cms/dashboard/settings",
    name: "settings",
    component: settings,
    meta: { requiresAuth: true },
  },
];

const router = new VueRouter({
  mode: "history",
  routes: routes,
});

//authenticated
router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (store.getters.isAuthenticated) {
      next();
      return;
    }
    next("/cms/login");
    return;
  }
  if (to.matched.some((record) => record.meta.guest)) {
    if (store.getters.isAuthenticated) {
      next("/cms/dashboard");
      return;
    }
    next();
    return;
  }

  next();
});

import Vuex from "vuex";
import storeData from "./vue/store/globalStore";
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
