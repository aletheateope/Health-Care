<script setup>
import { ref } from "vue";
import { storeToRefs } from "pinia";

import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";
import DataTable from "primevue/datatable";
import Column from "primevue/column";

import DataTableContainer from "@/components/datatable/Container.vue";

import { useAuthStore } from "@/stores/auth";

const auth = useAuthStore();
const { role } = storeToRefs(auth);

const patients = ref([
    {
        name: "test",
        age: "test",
        lastConsult: "test",
        doctor: "test",
    },
]);
</script>

<template>
    <section class="flex flex-col gap-8 h-full">
        <header class="flex flex-col sm:flex-row gap-6">
            <IconField class="flex-grow">
                <InputIcon class="pi pi-search" />
                <InputText v-model="value1" placeholder="Search" fluid />
            </IconField>
            <Button
                v-if="role === 'staff'"
                label="Add Patient"
                icon="pi pi-plus"
            />
        </header>
        <DataTableContainer>
            <DataTable
                :value="patients"
                scrollable
                tableStyle="min-width: 50rem"
                scrollHeight="100%"
                class="flex-grow h-0"
            >
                <Column field="name" header="Name"></Column>
                <Column field="age" header="Age"></Column>
                <Column field="lastConsult" header="Last Consultation"></Column>
                <Column field="doctor" header="Doctor"></Column>
            </DataTable>
        </DataTableContainer>
    </section>
</template>
