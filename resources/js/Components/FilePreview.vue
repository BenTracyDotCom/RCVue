<script setup>
defineProps({
  file: { type: Object, required: true },
  tag: { type: String, default: 'li' },
})
defineEmits(['remove'])
</script>

<template>
  <component :is="tag" class="file-preview">
    <button @click="$emit('remove', file)" class="close-icon" aria-label="Remove">×</button>
    <img :src="file.url" :alt="file.file.name" :title="file.file.name" class="h-48"/>
  </component>
</template>
