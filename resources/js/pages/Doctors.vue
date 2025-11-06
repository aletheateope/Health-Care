<script setup>
import { ref, onMounted } from "vue";
import { storeToRefs } from "pinia";
import { useIntersectionObserver } from "@vueuse/core";

import { Form, FormField } from "@primevue/forms";
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import Checkbox from "primevue/checkbox";
import CheckboxGroup from "primevue/checkboxgroup";
import SelectButton from "primevue/selectbutton";

import { useDoctorStore } from "@/stores/doctor";

import CardDoctor from "@/components/CardDoctor.vue";

const selectedTime = ref(null);
const timeOptions = [
    { label: "AM", value: "am" },
    { label: "PM", value: "pm" },
];

const doctorStore = useDoctorStore();
const { doctors, loading, page, lastPage } = storeToRefs(doctorStore);
const { fetchDoctors } = doctorStore;

const loadTrigger = ref(null);

onMounted(() => {
    fetchDoctors(true);
});

useIntersectionObserver(loadTrigger, ([{ isIntersecting }]) => {
    if (isIntersecting && !loading.value) {
        fetchDoctors();
    }
});
</script>

<template>
    <div class="flex flex-col gap-12">
        <div class="flex flex-col gap-8">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col sm:flex-row gap-6">
                    <FormField class="w-full">
                        <FloatLabel variant="on">
                            <InputText id="doctor-name" fluid />
                            <label for="doctor-name">Doctor Name</label>
                        </FloatLabel>
                    </FormField>
                    <FormField class="w-full">
                        <FloatLabel variant="on">
                            <Select id="specialization" fluid />
                            <label for="specialization">Specialization</label>
                        </FloatLabel>
                    </FormField>
                </div>
                <FormField>
                    <FloatLabel variant="on">
                        <Select id="hmo" fluid />
                        <label for="hmo">HMO</label>
                    </FloatLabel>
                </FormField>
                <div
                    class="flex flex-col lg:flex-row justify-between px-2 gap-8"
                >
                    <div class="flex flex-col gap-3">
                        <h6 class="text-base">Schedule</h6>
                        <CheckboxGroup class="flex flex-wrap gap-10 gap-y-4">
                            <div class="flex items-center gap-2">
                                <Checkbox inputId="monday" />
                                <label for="monday">Monday</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <Checkbox inputId="tuesday" />
                                <label for="tuesday">Tuesday</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <Checkbox inputId="wednesday" />
                                <label for="wednesday">Wednesday</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <Checkbox inputId="thursday" />
                                <label for="thursday">Thursday</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <Checkbox inputId="friday" />
                                <label for="friday">Friday</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <Checkbox inputId="saturday" />
                                <label for="saturday">Saturday</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <Checkbox inputId="sunday" />
                                <label for="sunday">Sunday</label>
                            </div>
                        </CheckboxGroup>
                    </div>
                    <div class="flex flex-col gap-3 shrink-0">
                        <h6 class="text-base">Time</h6>
                        <SelectButton
                            v-model="selectedTime"
                            :options="timeOptions"
                            optionLabel="label"
                            :pt="{
                                pcToggleButton: {
                                    content: { class: 'px-8!' },
                                },
                            }"
                        />
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-end">
                <Button label="Search Doctor" />
            </div>
        </div>
        <div class="flex flex-col gap-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                <CardDoctor
                    v-for="doctor in doctors"
                    :key="doctor.id"
                    :id="doctor.id"
                    :name="`${doctor.first_name} ${doctor.last_name}`"
                    :specialty="doctor.specialty.name"
                />
            </div>
            <div ref="loadTrigger" class="flex justify-center items-center p-6">
                <template v-if="loading">
                    <i class="pi pi-spin pi-spinner text-3xl text-gray-500"></i>
                </template>
                <template v-else-if="!loading && lastPage && page > lastPage">
                    <p class="text-gray-500">No more doctors to load.</p>
                </template>
            </div>
        </div>
    </div>
</template>
