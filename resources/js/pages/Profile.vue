<script setup>
import { computed, ref, watch } from "vue";
import { storeToRefs } from "pinia";

import { useAuthStore } from "@/stores/auth";

import Section from "@/components/Section.vue";

import Dialog from "primevue/dialog";
import { Form, FormField } from "@primevue/forms";
import Message from "primevue/message";
import SelectButton from "primevue/selectbutton";

import AutoComplete from "primevue/autocomplete";

const auth = useAuthStore();
const { user } = storeToRefs(auth);

const role = computed(() => user.value?.role.toLowerCase() || "");

const editScheduleModal = ref(false);

const schedules = ref([
    {
        selectedDays: [],
        timeSlots: [""],
    },
]);

const days = ref([
    { name: "Monday" },
    { name: "Tuesday" },
    { name: "Wednesday" },
    { name: "Thursday" },
    { name: "Friday" },
    { name: "Saturday" },
    { name: "Sunday" },
]);

const slots = [
    "6:00 AM",
    "6:30 AM",
    "7:00 AM",
    "7:30 AM",
    "8:00 AM",
    "8:30 AM",
    "9:00 AM",
    "9:30 AM",
    "10:00 AM",
    "10:30 AM",
    "11:00 AM",
    "11:30 AM",
    "12:00 PM",
    "12:30 PM",
    "1:00 PM",
    "1:30 PM",
    "2:00 PM",
    "2:30 PM",
    "3:00 PM",
    "3:30 PM",
    "4:00 PM",
    "4:30 PM",
    "5:00 PM",
    "5:30 PM",
    "6:00 PM",
    "6:30 PM",
    "7:00 PM",
    "7:30 PM",
    "8:00 PM",
    "8:30 PM",
    "9:00 PM",
    "9:30 PM",
    "10:00 PM",
    "10:30 PM",
    "11:00 PM",
    "11:30 PM",
    "12:00 AM",
    "12:30 AM",
    "1:00 AM",
    "1:30 AM",
    "2:00 AM",
    "2:30 AM",
    "3:00 AM",
    "3:30 AM",
    "4:00 AM",
    "4:30 AM",
    "5:00 AM",
    "5:30 AM",
];

const filteredSlots = ref([]);

function searchSlots(event) {
    const query = event.query.toLowerCase();
    filteredSlots.value = slots.filter((s) => s.toLowerCase().includes(query));
}

function timeToMinutes(timeStr) {
    const [time, modifier] = timeStr.split(" "); // "6:30", "AM"
    let [hours, minutes] = time.split(":").map(Number);

    if (modifier === "PM" && hours !== 12) hours += 12;
    if (modifier === "AM" && hours === 12) hours = 0;

    return hours * 60 + minutes;
}

function availableDays(currentSchedule) {
    const selectedDays = schedules.value
        .filter((s) => s !== currentSchedule)
        .flatMap((s) => s.selectedDays)
        .map((d) => d.name); // flatten and get names

    return days.value.filter((day) => !selectedDays.includes(day.name));
}

function watchSchedule(schedule) {
    watch(
        () => schedule.timeSlots,
        (newVal) => {
            if (schedule.selectedDays.length === 0) return;

            const nonEmptySlots = newVal.filter((slot) => slot);
            nonEmptySlots.sort((a, b) => timeToMinutes(a) - timeToMinutes(b));

            const merged = [...nonEmptySlots, ""];
            if (JSON.stringify(schedule.timeSlots) !== JSON.stringify(merged)) {
                schedule.timeSlots = merged;
            }
        },
        { deep: true }
    );

    watch(
        () => schedule.selectedDays,
        (newVal) => {
            if (newVal.length === 0) schedule.timeSlots = [];
            else if (schedule.timeSlots.length === 0) schedule.timeSlots = [""];
        },
        { deep: true }
    );
}

schedules.value.forEach((s) => watchSchedule(s));

watch(
    schedules,
    (newVal) => {
        for (let i = newVal.length - 2; i >= 0; i--) {
            const schedule = newVal[i];
            if (
                schedule.selectedDays.length === 0 &&
                schedule.timeSlots.every((slot) => !slot)
            ) {
                newVal.splice(i, 1);
            }
        }

        const lastSchedule = newVal[newVal.length - 1];
        if (
            lastSchedule.selectedDays.length > 0 ||
            lastSchedule.timeSlots.some((slot) => slot)
        ) {
            newVal.push({ selectedDays: [], timeSlots: [""] });
            watchSchedule(newVal[newVal.length - 1]);
        }
    },
    { deep: true }
);

function canSelectDays(scheduleIndex) {
    // All previous schedules
    for (let i = 0; i < scheduleIndex; i++) {
        const prev = schedules.value[i];
        // If previous schedule has selected days but no time slots, block
        if (
            prev.selectedDays.length > 0 &&
            prev.timeSlots.every((slot) => !slot)
        ) {
            return false;
        }
    }
    return true;
}
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
                <div class="flex flex-col gap-8">
                    <div
                        v-for="(schedule, idx) in schedules"
                        :key="idx"
                        class="flex flex-col gap-4"
                    >
                        <div class="flex flex-col gap-2">
                            <p
                                v-if="
                                    idx > 0 &&
                                    schedule.selectedDays.length === 0 &&
                                    availableDays(schedule).length > 0
                                "
                                class="xsmall text-center"
                            >
                                Add more time slots by selecting another
                                schedule in an empty day selection
                            </p>
                            <FormField>
                                <SelectButton
                                    v-model="schedule.selectedDays"
                                    multiple
                                    optionLabel="name"
                                    aria-labelledby="multiple"
                                    :options="availableDays(schedule)"
                                    :disabled="!canSelectDays(idx)"
                                    class="select-days-btn rounded-md!"
                                />
                                <Message
                                    severity="error"
                                    size="small"
                                    variant="simple"
                                >
                                </Message>
                            </FormField>
                        </div>
                        <div
                            v-if="schedule.selectedDays.length > 0"
                            class="flex flex-col gap-2"
                        >
                            <div
                                v-for="(slot, sidx) in schedule.timeSlots"
                                :key="sidx"
                            >
                                <FormField>
                                    <AutoComplete
                                        v-model="schedule.timeSlots[sidx]"
                                        dropdown
                                        fluid
                                        :suggestions="filteredSlots"
                                        @complete="searchSlots"
                                        placeholder="Select Time Slot"
                                    />
                                    <Message
                                        severity="error"
                                        size="small"
                                        variant="simple"
                                    >
                                    </Message>
                                </FormField>
                            </div>
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
