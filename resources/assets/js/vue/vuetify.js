import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
Vue.use(Vuetify);

export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: "#1E88E5",
        secondary: "#BBDEFB",
        accent: "#2979FF",
        error: "#F44336",
      },
    },
  },
});
