<template>
  <div>
    <label for="part">{{ label }}</label>
    <h1>{{ title }}</h1>
    <p>{{ description }}</p>
    <div>{{ price }}</div>
    <img :src="image" />
  </div>
</template>
<script>
//Define the kind of props this component wants
  export default {
    props: {
      label: {required: true, type: String},
      done: {default: false, type: Boolean},
      title: {required: true, type: String},
      type: {required: true, type: String},
      description: {required: true, type: Text},
      price: {required: true, type: Number},
      image: {required: true, type: String}
    },
    data() {
      return {
        isDone: this.done,
      }
    }
  }
</script>