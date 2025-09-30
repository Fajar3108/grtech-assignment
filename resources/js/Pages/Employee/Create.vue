<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import { UploadOutlined } from "@ant-design/icons-vue";
import FormEmployee from "./Partials/Form.vue";

const props = defineProps({
  companies: Array,
});

const form = useForm({
  first_name: "",
  last_name: "",
  company_id: "",
  email: "",
  phone: "",
});

const submit = () => {
  form.post(route("employee.store"), {
    onSuccess: () => form.reset(),
  });
};
</script>

<template>
  <Head title="Add New Employee" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Add New Employee
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <FormEmployee
          :action="route('employee.store')"
          @submit="submit"
          :form="form"
          className="bg-white p-4 shadow sm:rounded-lg sm:p-8"
          :companies="companies"
        />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
