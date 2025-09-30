<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import { UploadOutlined } from "@ant-design/icons-vue";
import FormCompany from "./Partials/Form.vue";

const form = useForm({
  email: "",
  name: "",
  website: "",
  logo: [],
});

const submit = () => {
  form.post(route("company.store"), {
    forceFormData: true,
    onSuccess: () => form.reset(),
  });
};
</script>

<template>
  <Head title="Add New Company" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Add New Company
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <FormCompany
          :action="route('company.store')"
          @submit="submit"
          :form="form"
          className="bg-white p-4 shadow sm:rounded-lg sm:p-8"
          :errorMessages="errors"
        />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
