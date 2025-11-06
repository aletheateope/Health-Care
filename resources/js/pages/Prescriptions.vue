<script setup>
import { ref } from "vue";

import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import TieredMenu from "primevue/tieredmenu";

import DataTableContainer from "@/components/DataTableContainer.vue";

const prescriptions = ref([
    {
        patientName: "test",
        date: "test",
        validUntil: "test",
        prescribed: "test",
    },
    {
        patientName: "test",
        date: "test",
        validUntil: "test",
        prescribed: "test",
    },
]);

const menu = ref([]);

const menuItems = ref([
    { label: "Edit", icon: "pi pi-pen-to-square" },
    { label: "Delete", icon: "pi pi-trash" },
]);

const toggleMenu = (event, i) => {
    menu.value[i].toggle(event);
};
</script>

<template>
    <section class="flex flex-col gap-8 h-full" id="prescriptions-section">
        <header
            class="flex flex-col sm:flex-row justify-between gap-6 sm:gap-8"
        >
            <IconField class="flex-grow">
                <InputIcon class="pi pi-search" />
                <InputText placeholder="Search" fluid />
            </IconField>
            <Button label="Write Prescription" icon="pi pi-plus" />
        </header>
        <DataTableContainer>
            <DataTable
                :value="prescriptions"
                scrollable
                tableStyle="min-width: 50rem border"
                scrollHeight="100%"
                class="flex-grow h-0"
            >
                <Column field="patientName" header="Patient Name"></Column>
                <Column field="date" header="Date"></Column>
                <Column field="validUntil" header="Valid Until"></Column>
                <Column field="prescribed" header="Prescribed"></Column>
                <Column class="w-30">
                    <template #header>
                        <div
                            class="flex-1 text-center p-datatable-column-title"
                        >
                            Action
                        </div>
                    </template>
                    <template #body="{ data, index }">
                        <div class="text-center">
                            <Button
                                icon="pi pi-ellipsis-v"
                                aria-label="More"
                                severity="secondary"
                                variant="text"
                                aria-haspopup="true"
                                aria-controls="more"
                                @click="(e) => toggleMenu(e, index)"
                            />
                            <TieredMenu
                                v-for="(item, i) in prescriptions"
                                :key="i"
                                ref="menu"
                                id="more"
                                :model="menuItems"
                                popup
                                appendTo="#prescriptions-section"
                            />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </DataTableContainer>
    </section>
</template>
