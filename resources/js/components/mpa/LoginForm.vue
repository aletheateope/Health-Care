<script setup>
import { ref } from "vue";
import axios from "axios";

import * as yup from "yup";

import { Form, FormField } from "@primevue/forms";
import Message from "primevue/message";

import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Checkbox from "primevue/checkbox";
import Button from "primevue/button";

const initialValues = {
    email: "",
    password: "",
    remember: false,
};

const errors = ref({});

async function onSubmit({ values }) {
    errors.value = {};
    try {
        await axios.post("/login", values);

        window.location.href = "/portal/dashboard";
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        }
    }
}

function clearError(field) {
    errors.value[field] = null;
}
</script>

<template>
    <Form :initialValues="initialValues" @submit="onSubmit">
        <div class="flex flex-col items-center gap-14 text-center">
            <div class="flex flex-col gap-2">
                <h3>Hello!</h3>
                <p>Log in to access your account and get started.</p>
            </div>
            <div class="flex flex-col gap-6 w-full">
                <FormField name="email" v-slot="{ field }">
                    <FloatLabel variant="on">
                        <InputText
                            v-bind="field"
                            id="email"
                            type="email"
                            fluid
                            :invalid="errors.email"
                            @update:modelValue="clearError('email')"
                        />
                        <label for="email">Email</label>
                    </FloatLabel>
                    <Message
                        v-if="errors.email"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ errors.email[0] }}</Message
                    >
                </FormField>
                <FormField name="password" v-slot="{ field }">
                    <FloatLabel variant="on">
                        <Password
                            v-bind="field"
                            id="password"
                            toggleMask
                            fluid
                            :feedback="false"
                            :invalid="errors.password"
                            @update:modelValue="clearError('password')"
                        />
                        <label for="password">Password</label>
                    </FloatLabel>
                    <Message
                        v-if="errors.password"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ errors.password[0] }}
                    </Message>
                </FormField>
                <div
                    class="flex gap-2 flex-row items-center justify-between sm:px-2"
                >
                    <FormField name="remember" v-slot="{ field }">
                        <div class="flex items-center gap-2">
                            <Checkbox
                                v-bind="field"
                                inputId="remember-me"
                                binary
                            />
                            <label for="remember-me">Remember me</label>
                        </div>
                    </FormField>
                    <Button
                        label="Forgot Password?"
                        variant="link"
                        class="p-0!"
                    />
                </div>
            </div>
            <Button type="submit" label="Login" fluid />
            <p>
                Dont have an account?
                <span>
                    <Button
                        label="Sign Up"
                        as="a"
                        variant="link"
                        href="/register"
                        type="button"
                        class="p-0!"
                    />
                </span>
            </p>
            <p class="border-b w-full text-center leading-[0.1em]">
                <span class="bg-color px-4">Or sign in with</span>
            </p>
            <div class="flex flex-col sm:flex-row w-full justify-center gap-4">
                <Button
                    icon="pi pi-google"
                    label="Google"
                    severity="secondary"
                />
                <Button
                    icon="pi pi-facebook"
                    label="Facebook"
                    severity="secondary"
                />
            </div>
        </div>
    </Form>
</template>
