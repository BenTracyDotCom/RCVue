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
      parts: [
        {
          title: 'ev800d',
          type: 'digital',
          description: 'the best pair of goggs you\'ll ever own',
          price: 800.00,
          image: 'https://via.placeholder.com/640x480.png/0066aa?text=ducimus',
        },
        {
          title: 'QX7',
          type: 'Transmitter',
          description: 'Great beginner tx',
          price: 79.99,
          image: 'https://via.placeholder.com/640x480.png/0066aa?text=ducimus',
        },
      ],
    };
  },
}
</script>