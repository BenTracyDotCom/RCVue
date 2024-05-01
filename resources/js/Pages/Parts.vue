<script setup>
import PartTile from '../Components/PartTile.vue';

// Do all importing here
</script>

<template>
  <div>
    <h1 class="text-center text-3xl font-bold my-8">Parts page!!</h1>
    <div className="flex flex-wrap space-x-3 mx-5">
      <div v-for="part in parts" :key="part.id">
        <part-tile :title="part.title" :type="part.type" :description="part.description" :price="part.price"
          :image="part.image"></part-tile>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {

  },
  data() {
    return {
      parts: [],
    };
  },
  mounted() {
    this.fetchAvailableParts();
  },
  methods: {
    fetchAvailableParts() {
      axios.get('api/parts')
        .then(res => {
          console.log('ziggy found this one, ennit')
          this.parts = res.data;
        })
        .catch(console.error)
    }
  }
}
</script>