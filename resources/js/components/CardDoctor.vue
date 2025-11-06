<script setup>
import { ref, onMounted, computed } from "vue";
import { storeToRefs } from "pinia";

import { useDoctorStore } from "@/stores/doctor";

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    specialty: {
        type: String,
        required: true,
    },
});

const doctorStore = useDoctorStore();
const { availabilities } = storeToRefs(doctorStore);
const { fetchAvailability } = doctorStore;

onMounted(() => fetchAvailability(props.id));
const groupedAvailability = computed(
    () => availabilities.value[props.id] || []
);
</script>

<template>
    <div
        class="flex flex-col border border-color shadow-md rounded-md gap-6 p-4"
    >
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <div class="flex flex-col">
                <div
                    class="max-w-54 sm:size-34 border border-color rounded-md overflow-hidden"
                >
                    <img
                        src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png"
                        alt=""
                        class="h-full w-full object-cover"
                    />
                </div>
            </div>
            <div
                class="flex flex-col gap-4 text-center sm:text-left items-center sm:items-start"
            >
                <div class="flex flex-col gap-1">
                    <h6>{{ name }}</h6>
                    <p>{{ specialty }}</p>
                </div>
                <Button
                    class="justify-start!"
                    label="Message"
                    icon="pi pi-comment"
                    severity="secondary"
                    size="small"
                />
            </div>
        </div>
        <div class="flex flex-col p-4 justify-between h-full gap-6">
            <div v-if="groupedAvailability.length" class="flex flex-col gap-2">
                <div v-for="(group, index) in groupedAvailability" :key="index">
                    <p>{{ group.days.join(", ") }}</p>
                    <p>{{ group.start_time }} - {{ group.end_time }}</p>
                </div>
            </div>
            <div v-else>
                <p>No available schedule.</p>
            </div>
            <div class="flex flex-col gap-1">
                <Button label="Book Appointment" icon="pi pi-calendar" fluid />
                <Button
                    class="text-color small"
                    label="View More Details"
                    variant="link"
                    fluid
                />
            </div>
        </div>
    </div>
</template>
