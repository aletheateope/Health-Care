<script setup>
import { computed, ref } from "vue";
import { storeToRefs } from "pinia";

import { useAuthStore } from "@/stores/auth";

import Section from "@/components/Section.vue";

import Dialog from "primevue/dialog";
import { Form, FormField } from "@primevue/forms";
import SelectButton from "primevue/selectbutton";
import Select from "primevue/select";

const auth = useAuthStore();
const { user } = storeToRefs(auth);

const role = computed(() => user.value?.role.toLowerCase() || "");

const editScheduleModal = ref(false);

const selectedDays = ref([]);

const days = ref([
    { name: "Monday" },
    { name: "Tuesday" },
    { name: "Wednesday" },
    { name: "Thursday" },
    { name: "Friday" },
    { name: "Saturday" },
    { name: "Sunday" },
]);

const slots = ref([]);

const slots = [
    {label: "9:00 AM", values:""},
],
</script>

<style>
.select-days-btn {
    flex-wrap: wrap;
    overflow: hidden;

    button {
        width: 100%;
    }

    .p-togglebutton:first-child {
        border-inline-start-width: 0 !important;
        border-start-start-radius: 0 !important;
        border-end-start-radius: 0 !important;
    }

    .p-togglebutton:last-child {
        border-start-end-radius: 0 !important;
        border-end-end-radius: 0 !important;
    }
}

@media screen and (min-width: 640px) {
    .select-days-btn {
        button {
            width: auto;
            flex-grow: 1;
        }
    }
}
</style>

<template>
    <div v-if="role === 'doctor'" class="flex flex-col gap-4">
        <Section title="Personal Information" edit>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row gap-4 md:items-center">
                    <div>
                        <img
                            src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png"
                            alt="Profile Picture"
                            class="w-full h-full sm:size-54 border rounded-md border-color object-cover"
                        />
                    </div>
                    <div class="flex flex-col md:flex-grow gap-4">
                        <div class="flex flex-col">
                            <h6>Name</h6>
                            <p>
                                {{ user.profile.first_name }}
                                {{ user.profile.middle_name }}
                                {{ user.profile.last_name }}
                            </p>
                        </div>
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex flex-col flex-1">
                                <h6>Specialty</h6>
                                <p>
                                    {{
                                        user.profile.doctor?.specialty?.name ||
                                        "N/A"
                                    }}
                                </p>
                            </div>
                            <div class="flex flex-col flex-1">
                                <h6>Room</h6>
                                <p>
                                    {{
                                        user.profile.doctor?.room_number ||
                                        "N/A"
                                    }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex flex-col flex-1">
                                <h6>Email</h6>
                                <p>{{ user.email }}</p>
                            </div>
                            <div class="flex flex-col flex-1">
                                <h6>Clinic Number</h6>
                                <p>
                                    {{
                                        user.profile.doctor
                                            ?.clinic_phone_number || "N/A"
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <h6 class="text-base!">Doctor Notes</h6>
                    <p>{{ user.profile.doctor?.doctor_note || "N/A" }}</p>
                </div>
            </div>
        </Section>
        <Section title="Schedule" edit @edit-clicked="editScheduleModal = true">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex flex-col flex-1">
                        <h6>Monday</h6>
                        <p>test</p>
                    </div>
                    <div class="flex flex-col flex-1">
                        <h6>Tuesday</h6>
                        <p>test</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex flex-col flex-1">
                        <h6>Wednesday</h6>
                        <p>test</p>
                    </div>
                    <div class="flex flex-col flex-1">
                        <h6>Thursday</h6>
                        <p>test</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex flex-col flex-1">
                        <h6>Friday</h6>
                        <p>test</p>
                    </div>
                    <div class="flex flex-col flex-1">
                        <h6>Saturday</h6>
                        <p>test</p>
                    </div>
                </div>
                <div>
                    <h6>Sunday</h6>
                    <p>test</p>
                </div>
            </div>
        </Section>

        <Dialog
            v-model:visible="editScheduleModal"
            modal
            header="Update Schedule"
            appendTo="self"
            :dismissableMask="true"
            :style="{ width: '30rem' }"
        >
            <Form ref="editScheduleForm">
                <div class="flex flex-col gap-4">
                    <SelectButton
                        v-model="selectedDays"
                        :options="days"
                        optionLabel="name"
                        multiple
                        aria-labelledby="multiple"
                        class="select-days-btn rounded-md!"
                    />
                    <Button
                        label="Add Slot"
                        icon="pi pi-plus"
                        iconPos="right"
                    />
                </div>
            </Form>
            <template #footer>
                <div class="flex justify-end gap-2">
                    <Button
                        type="button"
                        label="Cancel"
                        severity="secondary"
                        @click="editScheduleModal = false"
                    ></Button>
                    <Button
                        type="submit"
                        label="Save"
                        @click="$refs.editScheduleForm.submit()"
                    />
                </div>
            </template>
        </Dialog>
    </div>
</template>
