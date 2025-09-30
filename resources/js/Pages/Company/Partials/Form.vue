<script setup>
import { UploadOutlined } from "@ant-design/icons-vue";

const props = defineProps({
  form: {
    type: Object,
    default: () => ({}),
  },
  action: String,
  className: String
});

const emit = defineEmits(["submit"]);
</script>

<template>
  <a-form
    :action="action"
    @submit.prevent="emit('submit')"
    :model="form"
    layout="vertical"
    :class="className"
    method="post"
  >
    <a-form-item
      label="Name"
      name="name"
      v-model:value="form.name"
      :rules="[{ required: true, message: 'Please input company name!' }]"
      :help="form.errors?.name"  :validateStatus="form.errors?.name ? 'error' : undefined"
    >
      <a-input v-model:value="form.name" placeholder="Name" />
    </a-form-item>
    <a-form-item label="Email" name="email" :help="form.errors?.email"  :validateStatus="form.errors?.email ? 'error' : undefined">
      <a-input v-model:value="form.email" placeholder="Email" />
    </a-form-item>

    <a-form-item label="Logo" name="logo">
      <a-upload
        v-model:file-list="form.logo"
        list-type="picture"
        :max-count="1"
        :before-upload="() => false"
        :help="form.errors?.logo"  :validateStatus="form.errors?.logo ? 'error' : undefined"
      >
        <a-button>
          <upload-outlined></upload-outlined>
          Upload
        </a-button>
      </a-upload>
    </a-form-item>

    <a-form-item label="Website">
      <a-input v-model:value="form.website" placeholder="https://example.com" :help="form.errors?.website"  :validateStatus="form.errors?.website ? 'error' : undefined" />
    </a-form-item>

    <a-button type="primary" html-type="submit">Submit</a-button>
  </a-form>
</template>

