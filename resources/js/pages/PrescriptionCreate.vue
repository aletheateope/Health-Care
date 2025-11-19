<script setup>
import Breadcrumb from "@/components/Breadcrumb.vue";
import { Form, FormField } from "@primevue/forms";
import FloatLabel from "primevue/floatlabel";
import DatePicker from "primevue/datepicker";
import InputText from "primevue/inputtext";

const bcItems = [
    { label: "Prescriptions", route: "prescriptions" },
    { label: "New Prescription", route: "prescription-new" },
];
</script>

<template>
    <section class="flex flex-col gap-4">
        <Breadcrumb :items="bcItems" />
        <div>
            <div class="flex flex-col sm:flex-row gap-4">
                <FormField class="w-full">
                    <FloatLabel variant="on">
                        <DatePicker
                            inputId="date-issued"
                            iconDisplay="input"
                            showIcon
                            fluid
                        />
                        <label for="date-issued">Date Issued</label>
                    </FloatLabel>
                </FormField>
                <FormField class="w-full">
                    <FloatLabel variant="on">
                        <DatePicker
                            inputId="valid-date"
                            iconDisplay="input"
                            showIcon
                            fluid
                        />
                        <label for="valid-until">Valid Until</label>
                    </FloatLabel>
                </FormField>
            </div>
        </div>
    </section>
</template>
