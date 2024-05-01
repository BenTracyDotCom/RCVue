<template>
  <div class="shadow-xl min-h-128 w-64 rounded-lg border-2 my-4">
    <h1 class="text-2xl font-bold text-center">{{ title }}</h1>
    <img :src="image" class="h-64 mx-auto"/>
    <p class="line-clamp-3 h-14 my-4 px-2 text-center text-sm font-bold">{{ description }}</p>
    <div class="text-center italic">Sale price: ${{ price }}</div>
  </div>
</template>
<script>
  export default {
    props: {
      //TODO: icon for 'In Cart'
      done: {default: false, type: Boolean},
      title: {required: true, type: String},
      type: {required: true, type: String},
      description: {required: true, type: String},
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