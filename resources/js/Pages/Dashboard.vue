<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Button } from "ant-design-vue";

defineProps({
  totalEmployee: Number,
  totalCompany: Number,
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <a-row :gutter="16">
              <a-col :span="12">
                <a-card>
                  <a-statistic
                    title="Total Company"
                    :value="totalCompany"
                    :value-style="{ color: '#3f8600' }"
                    style="margin-right: 50px"
                  >
                    <template #prefix>
                      <arrow-up-outlined />
                    </template>
                  </a-statistic>
                </a-card>
              </a-col>
              <a-col :span="12">
                <a-card>
                  <a-statistic
                    title="Total Employee"
                    :value="totalEmployee"
                    :value-style="{ color: '#cf1322' }"
                  >
                    <template #prefix>
                      <arrow-down-outlined />
                    </template>
                  </a-statistic>
                </a-card>
              </a-col>
            </a-row>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
