<script setup>
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import VueSelectImage from 'vue-select-image';
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

const onSelectImage = (e) => {
  console.log(e)
}
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
        <InputLabel for="description" value="Description"/>
        <textarea id="description" v-model="form.description" />
        <InputLabel for="ipaid" value="What I paid" />
        <input type="number" step="0.01" id="ipaid" v-model="form.ipaid"/>
        <InputLabel for="price" value="Sale price" />
        <input type="number" step="0.01" id="price" v-model="form.price"/>
      </div>
<vue-select-image
:dataImages="dataImages"
@onselectimage="onSelectImage"
>
</vue-select-image>
      <PrimaryButton>Add Part</PrimaryButton>
    </form>
  </AuthenticatedLayout>
</template>