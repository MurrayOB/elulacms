export default {
  state: {
    collections: [],
    collectionsLoaded: true,
  },
  getters: {
    getCollections: (state) => state.collections,
    getCollectionsLoaded: (state) => state.collectionsLoaded,
    singleCollection: (state, getters) => (name) => {
      return getters.getCollections.find((el) => el.name == name);
    },
    singleCollectionById: (state, getters) => (id) => {
      return getters.getCollections.find((el) => el.id === id);
    },
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
          commit("collectionsLoaded", false);
          console.log(error);
        });
    },
    //CREATE COLLECTION
    async createCollection({ dispatch }, { collectionName, fieldsArray }) {
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
          router.push({
            name: "collection",
            params: { name: data.collectionName },
          });
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    //DELETE COLLECTION
    async deleteCollection({ dispatch }, { collectionId }) {
      const url = "/cms/deleteCollection";
      axios
        .post(url, {
          id: collectionId,
        })
        .then(function (res) {
          console.log(res);
          //Route to another place
          dispatch("fetchCollections");
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    //UPDATE COLLECTION
    async updateCollection({ dispatch }, { payload }) {
      const url = "/cms/updateCollection";
      axios
        .post(url, payload)
        .then(function (res) {
          console.log(res);
          dispatch("fetchCollections");
        })
        .catch(function (err) {
          console.log(err);
        });
    },
    //ADD ENTRY
    async addEntry({ dispatch }, { payload }) {
      axios
        .post("/cms/addEntry", payload)
        .then(function (res) {
          console.log(res);
          dispatch("fetchCollections");
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    //UPDATE ENTRY
    async updateEntry({ dispatch }, { id, entry, collectionName }) {
      const data = {
        id: id,
        entry: entry,
        collectionName: collectionName,
      };
      axios
        .post("/cms/updateEntry", data)
        .then(function (res) {
          console.log(res);
          dispatch("fetchCollections");
        })
        .catch(function (err) {
          console.log(err);
        });
    },
    //DELETE ENTRY
    async deleteEntry({ dispatch }, { id, collectionName }) {
      const data = {
        id: id,
        collectionName: collectionName,
      };
      axios
        .post("/cms/deleteEntry", data)
        .then(function (res) {
          console.log(res);
          dispatch("fetchCollections");
        })
        .catch(function (err) {
          console.log(err);
        });
    },
    //PUBLISH ENTRY
    async publishEntry({ dispatch }, { id, collectionName }) {
      const data = {
        id: id,
        collectionName: collectionName,
      };
      axios
        .post("/cms/publishEntry", data)
        .then(function (res) {
          console.log(res);
          dispatch("fetchCollections");
        })
        .catch(function (err) {
          console.log(err);
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
