window._ = require("lodash");

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Vue from "vue";

window.Vue = require("vue").default;

import vuetify from "./vuetify";

Vue.component("app", require("../js/components/app.vue").default);
const app = new Vue({
  el: "#app",
  vuetify,
});
