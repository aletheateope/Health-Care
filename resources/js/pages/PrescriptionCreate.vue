<script setup>
import { ref, watch } from "vue";
import { useDebounceFn } from "@vueuse/core";

import Breadcrumb from "@/components/Breadcrumb.vue";
import { Form, FormField } from "@primevue/forms";
import FloatLabel from "primevue/floatlabel";
import DatePicker from "primevue/datepicker";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import AutoComplete from "primevue/autocomplete";

import Section from "@/components/Section.vue";

const bcItems = [
    { label: "Prescriptions", route: "prescriptions" },
    { label: "New Prescription", route: "prescription-new" },
];

const selectedPatient = ref(null);
const patientItems = ref([]);

async function searchPatients(e) {
    const query = e.query;

    if (!query) {
        patientItems.value = [];
        return;
    }

    try {
        const res = await axios.get("/patients/search", {
            params: { q: query },
        });

        patientItems.value = res.data.data;
    } catch (err) {
        console.error(err);
    }
}

const debouncedSearchPatients = useDebounceFn(searchPatients, 300);

const patientAge = ref(null);

watch(selectedPatient, (newPatient) => {
    if (newPatient) {
        patientAge.value = newPatient.age;
    } else {
        patientAge.value = null;
    }
});

const today = ref(new Date());

const clinicalItems = ref([{ item: "", qty: null, sig: "" }]);

function onItemInput(index) {
    if (index === clinicalItems.value.length - 1) {
        const last = clinicalItems.value[index];
        if (last.item !== "") {
            clinicalItems.value.push({ item: "", qty: null, sig: "" });
        }
    }
}

function onItemBlur(index) {
    const current = clinicalItems.value[index];

    if (clinicalItems.value.length === 1) return;

    if (current.item === "" && current.qty === null && current.sig === "") {
        clinicalItems.value.splice(index, 1);
    }
}

const remarks = ref([""]);

function onRemarkInput(index) {
    if (index === remarks.value.length - 1) {
        if (remarks.value[index] !== "") {
            remarks.value.push("");
        }
    }
}

function onRemarkBlur(index) {
    if (remarks.value.length === 1) return; // keep at least 1

    if (remarks.value[index] === "") {
        remarks.value.splice(index, 1);
    }
}
</script>

<template>
    <div class="flex flex-col gap-4">
        <Breadcrumb :items="bcItems" />
        <div class="flex flex-col gap-8">
            <div class="flex flex-col gap-10">
                <Section title="Patient Information">
                    <div class="flex flex-col sm:flex-row gap-6">
                        <FormField class="w-full">
                            <FloatLabel variant="on">
                                <AutoComplete
                                    inputId="patient-name"
                                    v-model="selectedPatient"
                                    :suggestions="patientItems"
                                    :optionLabel="'full_name'"
                                    @complete="debouncedSearchPatients"
                                    fluid
                                />
                                <label for="patient-name">Name</label>
                            </FloatLabel>
                        </FormField>
                        <FormField class="w-full sm:w-[20%]">
                            <FloatLabel variant="on">
                                <InputNumber
                                    v-model="patientAge"
                                    inputId="age"
                                    :useGrouping="false"
                                    fluid
                                    disabled
                                />
                                <label for="age">Age</label>
                            </FloatLabel>
                        </FormField>
                    </div>
                </Section>
                <Section title="Prescription Information">
                    <div class="flex flex-col sm:flex-row gap-6">
                        <FormField class="w-full">
                            <FloatLabel variant="on">
                                <DatePicker
                                    inputId="date-issued"
                                    v-model="today"
                                    showIcon
                                    fluid
                                    disabled
                                    iconDisplay="input"
                                />
                                <label for="date-issued">Date Issued</label>
                            </FloatLabel>
                        </FormField>
                        <FormField class="w-full">
                            <FloatLabel variant="on">
                                <DatePicker
                                    inputId="valid-until"
                                    v-model="icondisplay"
                                    showIcon
                                    fluid
                                    iconDisplay="input"
                                    :minDate="new Date()"
                                />
                                <label for="valid-until">Valid Until</label>
                            </FloatLabel>
                        </FormField>
                    </div>
                </Section>
                <Section title="Clinical Order">
                    <div class="flex flex-col gap-8">
                        <div class="flex flex-col gap-6">
                            <div
                                v-for="(ci, index) in clinicalItems"
                                :key="index"
                                class="flex flex-col gap-3"
                            >
                                <h6 class="text-base!">Item {{ index + 1 }}</h6>
                                <div class="flex flex-col gap-4">
                                    <div class="flex flex-row gap-2 sm:gap-6">
                                        <FormField class="w-full">
                                            <FloatLabel variant="on">
                                                <InputText
                                                    :id="'item-' + (index + 1)"
                                                    fluid
                                                    v-model="ci.item"
                                                    @input="onItemInput(index)"
                                                    @blur="onItemBlur(index)"
                                                />
                                                <label
                                                    :for="'item-' + (index + 1)"
                                                    >Item</label
                                                >
                                            </FloatLabel>
                                        </FormField>
                                        <FormField class="w-[50%] sm:w-[30%]">
                                            <FloatLabel variant="on">
                                                <InputNumber
                                                    v-model="ci.qty"
                                                    :inputId="
                                                        'quantity-' +
                                                        (index + 1)
                                                    "
                                                    :useGrouping="false"
                                                    fluid
                                                    @blur="onItemBlur(index)"
                                                />
                                                <label
                                                    :for="
                                                        'quantity-' +
                                                        (index + 1)
                                                    "
                                                    >Qty</label
                                                >
                                            </FloatLabel>
                                        </FormField>
                                    </div>
                                    <FormField>
                                        <FloatLabel variant="on">
                                            <InputText
                                                :id="'sig-' + (index + 1)"
                                                fluid
                                                v-model="ci.sig"
                                                @blur="onItemBlur(index)"
                                            />
                                            <label :for="'sig-' + (index + 1)"
                                                >Sig.</label
                                            >
                                        </FloatLabel>
                                    </FormField>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3">
                            <h6 class="text-base!">Remarks</h6>
                            <div class="flex flex-col gap-4">
                                <FormField
                                    v-for="(r, index) in remarks"
                                    :key="index"
                                >
                                    <InputText
                                        fluid
                                        v-model="remarks[index]"
                                        @input="onRemarkInput(index)"
                                        @blur="onRemarkBlur(index)"
                                    />
                                </FormField>
                            </div>
                        </div>
                    </div>
                </Section>
            </div>
            <div class="flex flex-row justify-end">
                <Button label="Create" />
            </div>
        </div>
    </div>
</template>
