<script setup>
import { UploadOutlined } from "@ant-design/icons-vue";
import { ref } from 'vue';

const props = defineProps({
  form: {
    type: Object,
    default: () => ({}),
  },
  action: String,
  className: String,
  companies: Array,
})

const filterOption = (input, company) => {
  return company.value.toLowerCase().indexOf(input.toLowerCase()) >= 0;
};

const emit = defineEmits(["submit"]);
</script>

<template>
  <a-form
    :action="action"
    @submit.prevent="emit('submit')"
    :model="form"
    layout="vertical"
    :class="className"
  >
    <a-form-item
      label="First Name"
      name="first_name"
      v-model:value="form.first_name"
      :rules="[{ required: true, message: 'Please input your first name!' }]"
      :help="form.errors?.first_name"  :validateStatus="form.errors?.first_name ? 'error' : undefined"
    >
      <a-input v-model:value="form.first_name" placeholder="First Name" />
    </a-form-item>

    <a-form-item
      label="Last Name"
      name="last_name"
      v-model:value="form.last_name"
      :rules="[{ required: true, message: 'Please input your last name!' }]"
      :help="form.errors?.last_name"  :validateStatus="form.errors?.last_name ? 'error' : undefined"
    >
      <a-input v-model:value="form.last_name" placeholder="Last Name" />
    </a-form-item>

    <a-form-item
      label="Company"
      name="company_id"
      v-model:value="form.company_id"
      :rules="[{ required: true, message: 'Please select a Company!' }]"
      :help="form.errors?.company_id"  :validateStatus="form.errors?.company_id ? 'error' : undefined"
    >
      <a-select
        v-model:value="form.company_id"
        show-search
        placeholder="Select a Company"
        :options="companies"
        :filter-option="filterOption"
    ></a-select>
    </a-form-item>

    <a-form-item label="Email" name="email" :help="form.errors?.email"  :validateStatus="form.errors?.email ? 'error' : undefined">
      <a-input v-model:value="form.email" placeholder="Email" />
    </a-form-item>

    <a-form-item label="Phone">
      <a-input v-model:value="form.phone" placeholder="08xxxxxx" :help="form.errors?.phone"  :validateStatus="form.errors?.phone ? 'error' : undefined" />
    </a-form-item>

    <a-button type="primary" html-type="submit">Submit</a-button>
  </a-form>
</template>

