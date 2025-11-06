<script setup>
import Button from "primevue/button";
import { Form, FormField } from "@primevue/forms";
import InputText from "primevue/inputtext";
import FloatLabel from "primevue/floatlabel";
import InputMask from "primevue/inputmask";
import Textarea from "primevue/textarea";
</script>
<template>
    <Form>
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-6">
                <FormField>
                    <FloatLabel variant="on">
                        <InputText id="name" fluid />
                        <label for="name">Name</label>
                    </FloatLabel>
                </FormField>
                <FormField>
                    <FloatLabel variant="on">
                        <InputText id="email" fluid />
                        <label for="email">Email</label>
                    </FloatLabel>
                </FormField>
                <FormField>
                    <FloatLabel variant="on">
                        <InputMask id="phone-number" fluid />
                        <label for="phone-number">Phone Number</label>
                    </FloatLabel>
                </FormField>
                <FormField>
                    <FloatLabel variant="on">
                        <Textarea id="message" rows="5" fluid />
                        <label for="message">Message</label>
                    </FloatLabel>
                </FormField>
            </div>
            <div class="flex flex-row justify-end">
                <Button label="Submit" />
            </div>
        </div>
    </Form>
</template>
