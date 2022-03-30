export default {
  state: {
    collections: [],
    collectionsLoaded: true,
    allCollections: [],
  },
  getters: {
    getCollections: (state) => state.collections,
    getCollectionsLoaded: (state) => state.collectionsLoaded,
    getAllCollections: (state) => state.allCollections,
    singleCollection: (state, getters) => (name) => {
      return getters.getCollections.find((el) => el.name == name);
    },
  },
  actions: {
    //FETCH COLLECTIONS
    async fetchCollections({ commit }) {
      const url = "/cms/getCollections";
      axios
        .get(url)
        .then((res) => {
          commit(
            "setCollections",
            JSON.parse(JSON.stringify(res.data.collections))
          );
          commit(
            "setAllCollections",
            JSON.parse(JSON.stringify(res.data.collections))
          );
          commit("collectionsLoaded", true);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    //CREATE COLLECTION
    async createCollection(commit, { collectionName, fieldsArray }) {
      const data = {
        collectionName: collectionName,
        fieldTypes: fieldsArray,
      };
      const url = "/cms/addCollection";
      axios
        .post(url, data)
        .then(function (res) {
          console.log(res);
          dispatch("fetchCollections");
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  mutations: {
    setCollections(state, collections) {
      console.log(collections);
      state.collections = collections;
    },
    collectionsLoaded(state, success) {
      state.collectionsLoaded = success;
    },
    setAllCollections(state, allCollections) {
      state.allCollections = allCollections;
    },
  },
};
