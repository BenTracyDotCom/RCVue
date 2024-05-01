<script setup>
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ImageUploader from '@/Components/ImageUploader.vue';
import useFileList from '@/fileList.js';
import createUploader from '@/file-uploader.js';
import  FilePreview  from  '@/Components/FilePreview.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

//TODO: simplify to add single file and add to form before submitting

const form = useForm({
  _method: 'put',
  title: '',
  type: '',
  description: '',
  ipaid: null,
  price: null,
  image: null
})

const submit = () => {
  console.log(form)
  form.post(route('parts.create'), {
    onFinish: () => form.reset()
  });
}

//This is the storage and helper functions we created
const { files, addFiles, removeFile, replaceFile } = useFileList()

//This lets us open a dialog to add click-uploaded files to the same state array as drag-n-dropping
function onInputChange(e) {
  replaceFile(e.target.files)
  e.target.value = null
}

//This will be my API endpoint to store the file data in my database
const stuff = 'error.err'

const { uploadFiles } = createUploader(stuff)

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
      <ImageUploader class="drop-area" @files-dropped="replaceFile" #default="{ dropZoneActive }">
        <label for="file-input">
          <span v-if="dropZoneActive">
            <span>Drop It Here</span>
            <span class="smaller">to add/replace it</span>
          </span>
          <span v-else>
            <span>Drag Your File Here</span>
            <span class="smaller">
              or <strong><em>click here</em></strong> to select file
            </span>
          </span>
          <input type="file" id="file-input" @change="onInputChange" />
        </label>
        <ul class="image-list" v-show="files.length">
          <FilePreview  v-for="file of files" :key="file.id" :file="file" tag="li" @remove="removeFile" />
        </ul>
      </ImageUploader>
      <PrimaryButton>Add Part</PrimaryButton>
    </form>
  </AuthenticatedLayout>
</template>