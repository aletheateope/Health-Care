<script setup>
import { ref } from "vue";

import SelectButton from "primevue/selectbutton";
import Dialog from "primevue/dialog";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import TieredMenu from "primevue/tieredmenu";

import { Form, FormField } from "@primevue/forms";
import DatePicker from "primevue/datepicker";

const appointmentTypes = ref("upcoming");

const tabItems = [
    { label: "Upcoming", value: "upcoming" },
    { label: "Today", value: "today" },
    { label: "History", value: "history" },
];

const addAppointmentModal = ref(false);

// const appointments = ref([]);

// onMounted(async () => {
//     try {
//         const response = await axios.get("/appointments");
//         appointments.value = response.data.data;
//     } catch (error) {
//         console.error(error);
//     }
// });

const appointments = [
    {
        dateTime: "January 1, 2024 - 8:00 AM",
        doctor: "Dr. John Doe",
        appointmentType: "Consultation",
        room: "Room 1",
    },
];

const menu = ref();

const menuItems = ref([
    { label: "Edit", icon: "pi pi-pen-to-square" },
    { label: "Delete", icon: "pi pi-trash" },
]);

const moreMenu = (event) => {
    menu.value.toggle(event);
};
</script>

<template>
    <section class="flex flex-col gap-8 h-full" id="appointments-section">
        <div class="flex justify-between">
            <SelectButton
                v-model="appointmentTypes"
                :options="tabItems"
                optionLabel="label"
                optionValue="value"
            />
            <Button
                icon="pi pi-plus"
                label="Add Appointment"
                @click="addAppointmentModal = true"
            />
        </div>
        <DataTable
            :value="appointments"
            scrollable
            scrollHeight="100%"
            tableStyle="width: 100%"
            class="flex-grow overflow-hidden h-20"
        >
            <Column field="dateTime" header="Date and Time"></Column>
            <Column field="doctor" header="Doctor"></Column>
            <Column field="appointmentType" header="Appointment Type"></Column>
            <Column field="room" header="Room"></Column>
            <Column class="w-30">
                <template #header>
                    <div class="flex-1 text-center p-datatable-column-title">
                        Action
                    </div>
                </template>
                <template #body="{ data }">
                    <div class="text-center">
                        <Button
                            icon="pi pi-ellipsis-v"
                            aria-label="More"
                            severity="secondary"
                            variant="text"
                            aria-haspopup="true"
                            aria-controls="more"
                            @click="moreMenu"
                        />
                        <TieredMenu
                            ref="menu"
                            id="more"
                            :model="menuItems"
                            popup
                            appendTo="#appointments-section"
                        />
                    </div>
                </template>
            </Column>
        </DataTable>
    </section>
    <Dialog
        v-model:visible="addAppointmentModal"
        modal
        header="Schedule Appointment"
        appendTo="self"
        :dismissableMask="true"
        :style="{ width: '30rem' }"
    >
        <div class="mt-4">
            <p>
                Prefer a specific doctor?
                <span>
                    <RouterLink :to="{ name: 'doctor-appointment' }">
                        <Button
                            label="Book here"
                            as="a"
                            variant="link"
                            type="button"
                            class="p-0!"
                        />
                    </RouterLink>
                </span>
            </p>
        </div>
    </Dialog>
</template>
