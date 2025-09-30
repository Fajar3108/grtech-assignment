<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, Form, usePage, useForm } from "@inertiajs/vue3";
import { ref, createVNode } from "vue";
import FormCompany from "./Partials/Form.vue";
import { Modal } from "ant-design-vue";
import { ExclamationCircleOutlined } from "@ant-design/icons-vue";

defineProps({
  companies: {
    type: Object,
  },
});

const formEdit = useForm({
  id: "",
  name: "",
  email: "",
  logo: [],
  website: "",
});

const isEditOpen = ref(false);
const isDeleteOpen = ref(false);

const columns = [
  {
    title: "Name",
    dataIndex: "name",
    key: "name",
  },
  {
    title: "Email",
    dataIndex: "email",
    key: "email",
  },
  {
    title: "Logo",
    dataIndex: "logo",
    key: "logo",
  },
  {
    title: "Website",
    dataIndex: "website",
    key: "website",
  },
  {
    title: "Action",
    key: "action",
  },
];

const goToPage = (page) => {
  router.get(route("company.index"), { page }, { preserveState: true });
};

const showEditModal = (record) => {
  isEditOpen.value = true;

  formEdit.id = record.id;
  formEdit.name = record.name;
  formEdit.email = record.email;
  formEdit.website = record.website;
  formEdit.logo = record.logo
    ? [
        {
          uid: "-1",
          name: record.logo.split("/").pop(),
          status: "done",
          url: `/storage/${record.logo}`,
        },
      ]
    : [];
};

const submitEdit = () => {
  router.post(route("company.update", formEdit.id), {
    ...formEdit,
     _method: 'put',

  }, {
    onSuccess: () => {
      isEditOpen.value = false;
      formEdit.reset();
    },
    onError: (err) => formEdit.setError(err)
  });
};

const deleteCompany = (id) => {
  Modal.confirm({
    title: "Are you sure?",
    icon: createVNode(ExclamationCircleOutlined),
    onOk() {
      router.delete(route("company.destroy", id));
    },
  });
};
</script>

<template>
  <Head title="Company" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Company
        </h2>

        <a-button type="primary" :href="route('company.create')">
          Add New Company
        </a-button>
      </div>
    </template>

    <a-modal v-model:open="isEditOpen" title="Edit Company" :footer="null">
      <FormCompany
        :action="route('company.update', formEdit.id)"
        @submit="submitEdit"
        :form="formEdit"
        className="bg-white pt-4"
      />
    </a-modal>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
          <a-alert
            message="Success"
            :description="$page.props.flash?.success"
            v-if="$page.props.flash?.success"
            class="mb-5"
            type="success"
            banner
            closable
          />
          <a-table
            :columns="columns"
            :data-source="companies.data"
            row-key="id"
            bordered
            :pagination="{
              current: companies.current_page,
              pageSize: companies.per_page,
              total: companies.total,
              onChange: (page) => goToPage(page),
            }"
          >
            <template #bodyCell="{ column, record }">
              <template v-if="column.key === 'logo'">
                <a-avatar
                  :size="64"
                  shape="square"
                  v-if="record.logo"
                  :src="`/storage/${record.logo}`"
                />
              </template>
              <template v-else-if="column.key === 'website'">
                <a :href="record.website" target="_blank">{{ record.website }}</a>
              </template>
              <template v-else-if="column.key === 'action'">
                <a-button
                  type="link"
                  html-type="submit"
                  danger
                  @click="() => deleteCompany(record.id)"
                  >Delete</a-button
                >
                <a-divider type="vertical" />
                <a-button
                  type="link"
                  html-type="button"
                  @click="() => showEditModal(record)"
                  >Edit</a-button
                >
              </template>
            </template>
          </a-table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
