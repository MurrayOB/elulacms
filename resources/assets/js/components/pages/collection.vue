<template>
  <div>
    <div class="mt-4 pl-4">
      <h4>Collection:</h4>
      <h1>{{ name }}</h1>
      <p>{{ $store.state.count }}</p>
      <p>{{ $store.state.name }}</p>
      <button @click="$store.commit('increment', 10)">click</button>
      <!-- <p v-if="collections.length == 0">You dont have any collections</p>
      <p v-for="item in collections" :key="item.name">{{ item.name }}</p> -->
    </div>
  </div>
</template>

<script>
export default {
  props: ["name"],
};
</script>
