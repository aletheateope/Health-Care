<script setup>
import { ref } from "vue";

import SelectButton from "primevue/selectbutton";
import Dialog from "primevue/dialog";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import TieredMenu from "primevue/tieredmenu";

import { Form, FormField } from "@primevue/forms";
import DatePicker from "primevue/datepicker";
import InputText from "primevue/inputtext";

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
        class="w-[96%] md:w-[80%] xl:w-[50%]"
    >
        <p class="mb-4">
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
        <Form ref="addAppointmentForm" @submit="onSubmit">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <DatePicker v-model="date" inline showWeek class="flex-1" />
                    <div class="flex-1">
                        <FormField>
                            <label for="date">Date</label>
                            <InputText
                                id="date"
                                v-model="value"
                                disabled
                                fluid
                            />
                        </FormField>
                    </div>
                </div>
            </div>
        </Form>
        <template #footer>
            <div class="flex justify-end gap-2">
                <Button
                    type="button"
                    label="Cancel"
                    severity="secondary"
                    @click="addAppointmentModal = false"
                />
                <Button
                    type="button"
                    label="Book Appointment"
                    @click="$refs.addAppointmentForm.submit()"
                />
            </div>
        </template>
    </Dialog>
</template>
