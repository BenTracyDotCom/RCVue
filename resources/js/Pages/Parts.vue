<script setup>
import PartTile from '../Components/PartTile.vue';

// Do all importing here
</script>

<template>
  <div>
    <h1>Parts page!!</h1>
    <ul>
      <li v-for="part in parts" :key="part.id">
        <part-tile label="A Part Apart" :title="part.title" :type="part.type" :description="part.description"
          :price="part.price" :image="part.image"></part-tile>
      </li>
    </ul>
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