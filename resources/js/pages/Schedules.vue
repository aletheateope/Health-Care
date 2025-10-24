<script setup>
import { ref } from "vue";

import SelectButton from "primevue/selectbutton";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import TieredMenu from "primevue/tieredmenu";

const appointmentType = ref("upcoming");

const tabItems = [
    { label: "Upcoming", value: "upcoming" },
    { label: "Today", value: "today" },
    { label: "History", value: "history" },
];

const schedules = ref([
    {
        dateTime: "test",
        patientName: "test",
        appointmentType: "test",
        room: "test",
    },
    {
        dateTime: "test",
        patientName: "test",
        appointmentType: "test",
        room: "test",
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
    .schedule-tab.p-selectbutton-fluid {
        width: auto;
        .p-togglebutton {
            flex: 0 0 auto;
        }
    }
}
</style>

<template>
    <section class="flex flex-col gap-8 h-full" id="schedules-section">
        <header class="flex flex-col sm:flex-row justify-between gap-6">
            <SelectButton
                v-model="appointmentType"
                :allowEmpty="false"
                :options="tabItems"
                optionLabel="label"
                optionValue="value"
                class="schedule-tab"
                fluid
            />
            <Button label="Add Consultation Appointment" icon="pi pi-plus" />
        </header>
        <div
            class="flex flex-col flex-grow border border-color p-4 bg-(--p-content-background) rounded-md"
        >
            <DataTable
                :value="schedules"
                scrollable
                tableStyle="min-width: 50rem"
                scrollHeight="100%"
                class="flex-grow h-0"
            >
                <Column field="dateTime" header="Date & Time"></Column>
                <Column field="patientName" header="Patient Name"></Column>
                <Column
                    field="appointmentType"
                    header="Appointment Type"
                ></Column>
                <Column field="room" header="Room"></Column>
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
                                v-for="(item, i) in schedules"
                                :key="i"
                                ref="menu"
                                id="more"
                                :model="menuItems"
                                popup
                                appendTo="#schedules-section"
                            />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </section>
</template>
