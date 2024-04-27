      <script setup>
      // make sure to import `ref` from Vue
      import { ref, onMounted, onUnmounted } from 'vue'
      const emit = defineEmits(['files-dropped'])
      
      // Create `active` state and manage it with functions
      let active = ref(false)
      
      function setActive() {
        active.value = true
      }
      function setInactive() {
        active.value = false
      }
      
      function onDrop(e) {
        setInactive() // add this line too
        emit('files-dropped', [...e.dataTransfer.files])
      }
      
      // ... nothing changed below this
      </script>
<template>
  <!-- add `data-active` and the event listeners -->
  <div :data-active="active" @dragenter.prevent="setActive" @dragover.prevent="setActive" @dragleave.prevent="setInactive" @drop.prevent="onDrop">I assure you, the image picker will be here
      <!-- share state with the scoped slot -->
      <slot :dropZoneActive="active"></slot>
  </div>
</template>
