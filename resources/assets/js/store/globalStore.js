export default {
  state: {
    count: 0,
    collections: [],
  },
  getters: {
    getCollections: (state) => state.collections,
  },
  actions: {
    async fetchCollections({ commit }) {
      const url = "/cms/getCollections";
      axios
        .get(url)
        .then((res) => {
          commit("setCollections", res.data.collections);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mutations: {
    increment(state, n) {
      state.count += n;
    },
    setCollections(state, collections) {
      state.collections = collections;
    },
  },
};
