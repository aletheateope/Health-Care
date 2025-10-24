<script setup>
import { ref } from "vue";

import SelectButton from "primevue/selectbutton";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import TieredMenu from "primevue/tieredmenu";

const medRecordType = ref("1");

const tabItems = [
    { label: "Prescriptions", value: "1" },
    { label: "Test Results", value: "2" },
];

const medicalRecords = ref([
    {
        date: "test",
        doctor: "test",
        prescribed: "test",
        status: "test",
    },
    {
        date: "test",
        doctor: "test",
        prescribed: "test",
        status: "test",
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

<style>
@media (min-width: 640px) {
    .medical-record-tab.p-selectbutton-fluid {
        width: auto;

        .p-togglebutton {
            flex: 0 0 auto;
        }
    }
}
</style>

<template>
    <section class="flex flex-col gap-8 h-full" id="medical-records-section">
        <header>
            <SelectButton
                v-model="medRecordType"
                :allowEmpty="false"
                :options="tabItems"
                optionLabel="label"
                optionValue="value"
                class="medical-record-tab"
                fluid
            />
        </header>
        <div class="flex flex-col flex-grow">
            <DataTable
                :value="medicalRecords"
                scrollable
                tableStyle="min-width: 50rem border"
                scrollHeight="100%"
                class="flex-grow h-0"
            >
                <Column field="date" header="Date"></Column>
                <Column field="doctor" header="Doctor"></Column>
                <Column field="prescribed" header="Prescribed"></Column>
                <Column field="status" header="Status"></Column>
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
                                v-for="(item, i) in medicalRecords"
                                :key="i"
                                ref="menu"
                                id="more"
                                :model="menuItems"
                                popup
                                appendTo="#medical-records-section"
                            />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </section>
</template>
