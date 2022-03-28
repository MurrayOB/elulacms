export default {
  state: {
    collections: [],
    collectionsLoaded: true,
  },
  getters: {
    getCollections: (state) => state.collections,
    getCollectionsLoaded: (state) => state.collectionsLoaded,
  },
  actions: {
    async fetchCollections({ commit }) {
      const url = "/cms/getCollections";
      axios
        .get(url)
        .then((res) => {
          commit("setCollections", res.data.collections);
          commit("collectionsLoaded", true);
        })
        .catch((error) => {
          console.log(error);
          commit("collectionsLoaded", false);
        });
    },
  },
  mutations: {
    setCollections(state, collections) {
      state.collections = collections;
    },
    collectionsLoaded(state, success) {
      state.collectionsLoaded = success;
    },
  },
};
