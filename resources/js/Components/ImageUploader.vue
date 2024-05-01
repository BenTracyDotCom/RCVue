<script setup>
// make sure to import `ref` from Vue
import { ref, onMounted, onUnmounted } from 'vue'
const emit = defineEmits(['files-dropped'])

// Create `active` state and manage it with functions
let active = ref(false)
let inactiveTimeout = null

function setActive() {
  active.value = true
  clearTimeout(inactiveTimeout)
}
function setInactive() {
  active.value = false
  setTimeout(() => {
    active.value = false
  }, 50)
}

function onDrop(e) {
  setInactive()
  emit('files-dropped', [...e.dataTransfer.files])
}

</script>
<template>
  <!-- add `data-active` and the event listeners -->
  <div :data-active="active" @dragenter.prevent="setActive" @dragover.prevent="setActive"
    @dragleave.prevent="setInactive" @drop.prevent="onDrop">
    <!-- share state with the scoped slot -->
    <slot :dropZoneActive="active"></slot>
  </div>
</template>
