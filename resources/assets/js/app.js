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
import collection from "./components/pages/collection";
import settings from "./components/pages/settings";
import media from "./components/pages/media";

const routes = [
  {
    path: "/cms/dashboard/collections/:name",
    name: "collection",
    component: collection,
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

const main = new Vue({
  el: "#app",
  vuetify,
  components: {
    app: app,
    sidebar: sidebar,
  },
  router,
});
