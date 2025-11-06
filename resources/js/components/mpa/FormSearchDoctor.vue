<script setup>
import Button from "primevue/button";
import { Form, FormField } from "@primevue/forms";
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import Checkbox from "primevue/checkbox";
import CheckboxGroup from "primevue/checkboxgroup";
import RadioButton from "primevue/radiobutton";
import RadioButtonGroup from "primevue/radiobuttongroup";
</script>
<template>
    <Form>
        <div class="flex flex-col gap-8">
            <div class="flex flex-col md:flex-row gap-4">
                <FormField class="flex-1">
                    <FloatLabel variant="on">
                        <InputText id="name" type="text" fluid />
                        <label for="name">Doctor's Name</label>
                    </FloatLabel>
                </FormField>
                <FormField class="flex-1">
                    <FloatLabel variant="on">
                        <Select id="specialty" fluid />
                        <label for="specialty">Specialty</label>
                    </FloatLabel>
                </FormField>
            </div>
            <FormField>
                <FloatLabel variant="on">
                    <Select id="hmo" fluid />
                    <label for="hmo">HMO</label>
                </FloatLabel>
            </FormField>
            <div class="flex flex-col lg:flex-row justify-between gap-8">
                <div class="flex flex-col gap-3">
                    <h6 class="text-base">Schedule</h6>
                    <CheckboxGroup class="flex flex-wrap gap-10">
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
                <div class="flex flex-col gap-3 shrink-0 mr-4">
                    <h6 class="text-base">Time</h6>
                    <RadioButtonGroup class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-2">
                            <RadioButton inputId="am" />
                            <label for="am">AM</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <RadioButton inputId="pm" />
                            <label for="pm">PM</label>
                        </div>
                    </RadioButtonGroup>
                </div>
            </div>
            <div class="flex flex-row justify-end">
                <Button label="Search Doctor" />
            </div>
        </div>
    </Form>
</template>
