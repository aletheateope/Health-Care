<script setup>
import { ref } from "vue";
import axios from "axios";

import * as yup from "yup";

import Button from "primevue/button";

import { Form, FormField } from "@primevue/forms";
import Message from "primevue/message";
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";
import RadioButtonGroup from "primevue/radiobuttongroup";
import RadioButton from "primevue/radiobutton";
import Password from "primevue/password";
import InputMask from "primevue/inputmask";
import DatePicker from "primevue/datepicker";

import { userInitialValues } from "@/utils/form-initial-values";

// const schema = yup.object({
//     email: yup.string().email("Please enter a valid email address."),
// });

// function yupResolver(values) {
//     try {
//         schema.validateSync(values, { abortEarly: false });
//         return { values, errors: {} };
//     } catch (err) {
//         return {
//             values: {},
//             errors: err.inner.reduce((all, curr) => {
//                 all[curr.path] = [curr.message];
//                 return all;
//             }, {}),
//         };
//     }
// }

const errors = ref({});

async function onSubmit({ values }) {
    errors.value = {};
    try {
        await axios.post("/register", values);
        window.location.href = "/portal/dashboard";
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
            console.log(errors.value);
        }
    }
}

function clearError(field) {
    errors.value[field] = null;
}
</script>

<template>
    <Form :initialValues="userInitialValues" @submit="onSubmit">
        <div
            class="flex flex-col rounded-md border border-color shadow-md py-10 px-24 w-200 gap-12 items-center"
        >
            <h3>Sign Up</h3>
            <div class="flex flex-col gap-6 w-full">
                <div class="flex flex-row gap-4">
                    <FormField
                        name="first_name"
                        v-slot="{ field }"
                        class="w-full"
                    >
                        <FloatLabel variant="on">
                            <InputText
                                v-bind="field"
                                id="first-name"
                                fluid
                                :invalid="errors.first_name"
                                @update:modelValue="clearError('first_name')"
                            />
                            <label for="first-name">First Name</label>
                        </FloatLabel>
                        <Message
                            v-if="errors.first_name"
                            severity="error"
                            size="small"
                            variant="simple"
                            >{{ errors.first_name[0] }}</Message
                        >
                    </FormField>
                    <FormField
                        name="middle_name"
                        v-slot="{ field }"
                        class="w-full"
                    >
                        <FloatLabel variant="on">
                            <InputText
                                v-bind="field"
                                id="middle-name"
                                fluid
                                :invalid="errors.middle_name"
                                @update:modelValue="clearError('middle_name')"
                            />
                            <label for="middle-name">Middle Name</label>
                        </FloatLabel>
                        <Message
                            v-if="errors.middle_name"
                            severity="error"
                            size="small"
                            variant="simple"
                            >{{ errors.middle_name[0] }}</Message
                        >
                    </FormField>
                    <FormField
                        name="last_name"
                        v-slot="{ field }"
                        class="w-full"
                    >
                        <FloatLabel variant="on">
                            <InputText
                                v-bind="field"
                                id="last-name"
                                fluid
                                :invalid="errors.last_name"
                                @update:modelValue="clearError('last_name')"
                            />
                            <label for="last-name">Last Name</label>
                        </FloatLabel>
                        <Message
                            v-if="errors.last_name"
                            severity="error"
                            size="small"
                            variant="simple"
                            >{{ errors.last_name[0] }}</Message
                        >
                    </FormField>
                </div>
                <FormField name="date_of_birth" v-slot="{ field }">
                    <FloatLabel variant="on">
                        <DatePicker
                            v-bind="field"
                            inputId="date-of-birth"
                            showIcon
                            iconDisplay="input"
                            fluid
                            :invalid="errors.date_of_birth"
                            @update:modelValue="clearError('date_of_birth')"
                        />
                        <label for="date-of-birth">Date of Birth</label>
                    </FloatLabel>
                    <Message
                        v-if="errors.date_of_birth"
                        severity="error"
                        size="small"
                        variant="simple"
                    >
                        {{ errors.date_of_birth[0] }}
                    </Message>
                </FormField>
                <FormField name="phone_number" v-slot="{ field }">
                    <FloatLabel variant="on">
                        <InputMask
                            v-bind="field"
                            id="phone-number"
                            mask="(+63) 999 999 9999"
                            fluid
                            :invalid="errors.phone_number"
                            @update:modelValue="clearError('phone_number')"
                        />
                        <label for="phone-number">Phone Number</label>
                    </FloatLabel>
                    <Message
                        v-if="errors.phone_number"
                        severity="error"
                        size="small"
                        variant="simple"
                    >
                        {{ errors.phone_number[0] }}
                    </Message>
                </FormField>
                <FormField name="gender" v-slot="{ field }">
                    <div class="flex flex-col gap-2">
                        <label for="gender">Gender</label>
                        <RadioButtonGroup
                            v-bind="field"
                            class="flex flex-wrap gap-4"
                            id="gender"
                            :invalid="errors.gender"
                            @update:modelValue="clearError('gender')"
                        >
                            <div class="flex items-center gap-2">
                                <RadioButton inputId="male" value="male" />
                                <label for="male">Male</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <RadioButton inputId="female" value="female" />
                                <label for="female">Female</label>
                            </div>
                        </RadioButtonGroup>
                    </div>
                    <Message
                        v-if="errors.gender"
                        severity="error"
                        size="small"
                        variant="simple"
                    >
                        {{ errors.gender[0] }}
                    </Message>
                </FormField>
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
                        >{{ errors.email[0] }}
                    </Message>
                </FormField>
                <FormField name="password" v-slot="{ field }">
                    <FloatLabel variant="on">
                        <Password
                            v-bind="field"
                            inputClass="w-full"
                            inputId="password"
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
                <FormField name="password_confirmation" v-slot="{ field }">
                    <FloatLabel variant="on">
                        <Password
                            v-bind="field"
                            inputClass="w-full"
                            inputId="password-confirmation"
                            toggleMask
                            fluid
                            :feedback="false"
                            :invalid="errors.password_confirmation"
                            @update:modelValue="
                                clearError('password_confirmation')
                            "
                        />
                        <label for="password-confirmation"
                            >Confirm Password</label
                        >
                    </FloatLabel>
                    <Message
                        v-if="errors.password_confirmation"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ errors.password_confirmation[0] }}
                    </Message>
                </FormField>
                <Button label="Submit" type="submit" />
                <p class="self-center">
                    Already have an Account?
                    <span>
                        <Button
                            class="p-0!"
                            label="Sign up"
                            as="a"
                            variant="link"
                            href="/login"
                            type="button"
                        />
                    </span>
                </p>
            </div>
        </div>
    </Form>
</template>
