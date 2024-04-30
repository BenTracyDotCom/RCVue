<script setup>
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ImageUploader from '@/Components/ImageUploader.vue';
import useFileList from '@/fileList.js';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  title: '',
  type: '',
  description: '',
  ipaid: 0.00,
  price: 0.00,
  image: ''
})

const submit = () => {
  console.log(form)
  form.post(route('parts.create'), {
    onFinish: () => form.reset()
  });
}

const { files, addFiles, removeFile } = useFileList()

</script>

<template>
  <AuthenticatedLayout>

    <Head title="Add a part" />
    <div>Add A Part!</div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="title" value="Title" />
        <TextInput id="title" type="text" class="" v-model="form.title" required autocomplete="title" />
        <InputLabel for="type" value="Type" />
        <select id="type" v-model="form.type" required>
          <option value="frame">Frame</option>
          <option value="esc">ESC</option>
          <option value="motor">Motor(s)</option>
          <option value="camera">Camera</option>
          <option value="rx">Receiver</option>
          <option value="tx">Transmitter</option>
          <option value="parbuild">Partially Built</option>
          <option value="build">RTF/BNF</option>
          <option value="prop">Props</option>
          <option value="fc">Flight Controller/AIO</option>
          <option value="accessory">Accessory</option>
          <option value="digital">Digital</option>
          <option value="vtx">Video Transmitter</option>
          <option value="vrx">Video Receiver</option>
        </select>
        <InputLabel for="description" value="Description" />
        <textarea id="description" v-model="form.description" />
        <InputLabel for="ipaid" value="What I paid" />
        <input type="number" step="0.01" id="ipaid" v-model="form.ipaid" />
        <InputLabel for="price" value="Sale price" />
        <input type="number" step="0.01" id="price" v-model="form.price" />
      </div>
      <ImageUploader class="drop-area" @files-dropped="addFiles" #default="{ dropZoneActive }">
        <div v-if="dropZoneActive">
          <div>Drop Them</div>
        </div>
        <div v-else>
          <div>Drag Your Files Here</div>
        </div>
      </ImageUploader>
      <PrimaryButton>Add Part</PrimaryButton>
    </form>
  </AuthenticatedLayout>
</template>