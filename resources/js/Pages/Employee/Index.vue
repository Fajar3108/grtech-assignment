<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, Form, usePage, useForm } from "@inertiajs/vue3";
import { ref, createVNode, reactive } from "vue";
import FormCompany from "./Partials/Form.vue";
import { Modal } from "ant-design-vue";
import { ExclamationCircleOutlined } from "@ant-design/icons-vue";

defineProps({
  employees: {
    type: Object,
  },
  companies: Array,
});

const formEdit = useForm({
  first_name: "",
  last_name: "",
  company_id: "",
  email: "",
  phone: "",
});

const isEditOpen = ref(false);
const isDeleteOpen = ref(false);
const isCompanyDetailOpen = ref(false);

const selectedCompany = reactive({})

const columns = [
  {
    title: "First Name",
    dataIndex: "first_name",
    key: "first_name",
  },
  {
    title: "Last Name",
    dataIndex: "last_name",
    key: "last_name",
  },
  {
    title: "Company",
    dataIndex: "company.name",
    key: "company",
  },
  {
    title: "Email",
    dataIndex: "email",
    key: "email",
  },
  {
    title: "Phone",
    dataIndex: "phone",
    key: "phone",
  },
  {
    title: "Action",
    key: "action",
  },
];

const goToPage = (page) => {
  router.get(route("employee.index"), { page }, { preserveState: true });
};

const showEditModal = (record) => {
  isEditOpen.value = true;

  Object.assign(formEdit, record)
};

const submitEdit = () => {
  router.post(route("employee.update", formEdit.id), {
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

const deleteEmployee = (id) => {
  Modal.confirm({
    title: "Are you sure?",
    icon: createVNode(ExclamationCircleOutlined),
    onOk() {
      router.delete(route("employee.destroy", id));
    },
  });
};

const showCompanyDetail = (company) => {
    isCompanyDetailOpen.value = true;
    Object.assign(selectedCompany, company);
}
</script>

<template>
  <Head title="Company" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Employee
        </h2>

        <a-button type="primary" :href="route('employee.create')">
          Add New Employee
        </a-button>
      </div>
    </template>

    <a-modal v-model:open="isEditOpen" title="Edit Company" :footer="null">
      <FormCompany
        :action="route('company.update', formEdit.id)"
        @submit="submitEdit"
        :form="formEdit"
        className="bg-white pt-4"
        :companies="companies"
      />
    </a-modal>

    <a-modal v-model:open="isCompanyDetailOpen" title="Detail Company" :footer="null">
      <a-descriptions title="" bordered :column="1">
        <a-descriptions-item label="Name">{{selectedCompany.name}}</a-descriptions-item>
        <a-descriptions-item label="Email">{{selectedCompany.email}}</a-descriptions-item>
        <a-descriptions-item label="Website">
            <a :href="selectedCompany.website" target="_blank">{{selectedCompany.website}}</a>
        </a-descriptions-item>
        <a-descriptions-item label="Logo">
            <a-avatar
                :size="64"
                shape="square"
                v-if="selectedCompany.logo"
                :src="`/storage/${selectedCompany.logo}`"
            />
        </a-descriptions-item>
      </a-descriptions>
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
            :data-source="employees.data"
            row-key="id"
            bordered
            :pagination="{
              current: employees.current_page,
              pageSize: employees.per_page,
              total: employees.total,
              onChange: (page) => goToPage(page),
            }"
          >
            <template #bodyCell="{ column, record }">
              <template v-if="column.key === 'company'">
                <a-button @click="() => showCompanyDetail(record.company)">
                    {{ record.company.name }}
                </a-button>
              </template>
              <template v-else-if="column.key === 'action'">
                <a-button
                  type="link"
                  html-type="submit"
                  danger
                  @click="() => deleteEmployee(record.id)"
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
