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
    //FETCH COLLECTIONS
    async fetchCollections({ commit }) {
      const url = "/cms/getCollections";
      axios
        .get(url)
        .then((res) => {
          commit("setCollections", res.data.collections);
          commit("collectionsLoaded", true);
          console.log(JSON.parse(JSON.stringify(res.data.collections)));
        })
        .catch((error) => {
          console.log(error);
          commit("collectionsLoaded", false);
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
        })
        .catch(function (error) {
          console.log(error);
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
