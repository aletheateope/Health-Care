<script setup>
import { ref, onMounted } from "vue";

import SelectButton from "primevue/selectbutton";
import Dialog from "primevue/dialog";
import ConfirmDialog from "primevue/confirmdialog";
import { useConfirm } from "primevue/useconfirm";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import TieredMenu from "primevue/tieredmenu";

import { Form, FormField } from "@primevue/forms";
import Message from "primevue/message";
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";
import RadioButtonGroup from "primevue/radiobuttongroup";
import RadioButton from "primevue/radiobutton";
import Password from "primevue/password";
import InputMask from "primevue/inputmask";
import DatePicker from "primevue/datepicker";
import Select from "primevue/select";
import Checkbox from "primevue/checkbox";
import CheckboxGroup from "primevue/checkboxgroup";

import { userInitialValues } from "@/utils/form";
import { useAppToast } from "@/utils/toast";
import { useTimezoneStore } from "@/stores/timezone";

const timezoneStore = useTimezoneStore();
const timezone = timezoneStore.timezone;

const toast = useAppToast();
const loading = ref(false);
const confirm = useConfirm();

const userTypes = ref("all");
const tabItems = [
    { label: "All", value: "all" },
    { label: "Doctors", value: "doctors" },
    { label: "Staffs", value: "staffs" },
    { label: "Patients", value: "patients" },
];

const roles = [
    { label: "Admin", value: "admin" },
    { label: "Doctor", value: "doctor" },
    { label: "Staff", value: "staff" },
    { label: "Patient", value: "patient" },
];

const addUserModal = ref(false);

const errors = ref({});

async function onSubmit({ values }) {
    errors.value = {};
    loading.value = true;

    try {
        const payload = {
            ...values,
            timezone,
        };

        const response = await axios.post("/users", payload);
        toast.success("User added successfully.");
        addUserModal.value = false;

        users.value.push(response.data.data);
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            toast.error("Failed to add user.");
        }
    } finally {
        loading.value = false;
    }
}

function clearError(field) {
    errors.value[field] = null;
}

const users = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get("/users");
        users.value = response.data.data;
    } catch (error) {
        console.error(error);
    }
});

const menu = ref([]);

const menuItems = (user) => [
    {
        label: "Edit",
        icon: "pi pi-pen-to-square",
        command: () => editUser(user),
    },
    {
        label: "Delete",
        icon: "pi pi-trash",
        command: () => deleteUser(user),
    },
];

const toggleMenu = (event, i) => {
    menu.value[i].toggle(event);
};

function editUser(user) {
    console.log("Edit user:", user);
}

function deleteUser(user) {
    confirm.require({
        message: `Are you sure you want to delete ${user.first_name} ${user.last_name}?`,
        header: "Confirm Deletion",
        icon: "pi pi-exclamation-triangle",
        rejectLabel: "Cancel",
        acceptLabel: "Delete",
        rejectClass: "p-button-outlined p-button-secondary",
        acceptClass: "p-button-danger",
        accept: async () => {
            try {
                await axios.delete(`/users/${user.id}`);
                users.value = users.value.filter((u) => u.id !== user.id);
                toast.success("User deleted successfully.");
            } catch (error) {
                console.log(error);
                toast.error("Failed to delete user.");
            }
        },
    });
}
</script>

<style>
@media (min-width: 640px) {
    .user-tab.p-selectbutton-fluid {
        width: auto;
        .p-togglebutton {
            flex: 0 0 auto;
        }
    }
}
</style>

<template>
    <Toast />
    <ConfirmDialog />
    <section class="flex flex-col gap-8 h-full" id="users-section">
        <header class="flex flex-col sm:flex-row gap-6">
            <SelectButton
                v-model="userTypes"
                :options="tabItems"
                :allowEmpty="false"
                optionLabel="label"
                optionValue="value"
                class="user-tab"
                fluid
            />
        </header>
        <div class="flex flex-col sm:flex-row gap-6">
            <IconField class="flex-grow">
                <InputIcon class="pi pi-search" />
                <InputText placeholder="Search" fluid />
            </IconField>
            <Button
                icon="pi pi-plus"
                label="Add User"
                @click="addUserModal = true"
            />
        </div>
        <div
            class="flex flex-col flex-grow border border-color p-4 bg-(--p-content-background) rounded-md"
        >
            <DataTable
                :value="users"
                scrollable
                scrollHeight="100%"
                tableStyle="width: 100%"
                class="flex-grow h-0"
            >
                <Column class="w-5">
                    <template #header>
                        <div
                            class="flex-1 text-center p-datatable-column-title"
                        >
                            <Checkbox binary />
                        </div>
                    </template>
                    <template #body>
                        <div class="text-center">
                            <Checkbox binary />
                        </div>
                    </template>
                </Column>
                <Column header="Name">
                    <template #body="{ data }">
                        {{ data.first_name }}
                        {{ data.last_name }}
                    </template>
                </Column>
                <Column field="email" header="Email"></Column>
                <Column field="role" header="Role"></Column>
                <Column class="w-30">
                    <template #header>
                        <div
                            class="flex-1 text-center p-datatable-column-title"
                        >
                            Action
                        </div>
                    </template>
                    <template #body="{ index }">
                        <div class="text-center">
                            <Button
                                icon="pi pi-ellipsis-v"
                                aria-label="More"
                                severity="secondary"
                                variant="text"
                                aria-haspopup="true"
                                aria-controls="more"
                                @click="(e) => toggleMenu(e, index)"
                            />
                            <TieredMenu
                                v-for="(user, i) in users"
                                :key="i"
                                ref="menu"
                                id="more"
                                :model="menuItems(user)"
                                popup
                                appendTo="#users-section"
                            />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </section>

    <Dialog
        v-model:visible="addUserModal"
        modal
        header="Add User"
        appendTo="self"
        :dismissableMask="true"
        class="w-[98%] md:w-[80%] lg:w-[50%] xl:w-150"
    >
        <Form
            :initialValues="userInitialValues"
            ref="addUserForm"
            @submit="onSubmit"
        >
            <div class="flex flex-col gap-6">
                <div class="flex flex-row gap-1">
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
                <FormField name="role" v-slot="{ field }">
                    <FloatLabel variant="on">
                        <Select
                            v-bind="field"
                            inputId="role"
                            :options="roles"
                            optionLabel="label"
                            optionValue="value"
                            class="w-full"
                            fluid
                            :invalid="errors.role"
                            @update:modelValue="clearError('role')"
                        />
                        <label for="role">Role</label>
                    </FloatLabel>
                    <Message
                        v-if="errors.role"
                        severity="error"
                        size="small"
                        variant="simple"
                        >{{ errors.role[0] }}
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
            </div>
        </Form>
        <template #footer>
            <div class="flex justify-end gap-2">
                <Button
                    type="button"
                    label="Cancel"
                    severity="secondary"
                    @click="addUserModal = false"
                />
                <Button
                    type="button"
                    label="Save"
                    :loading="loading"
                    @click="$refs.addUserForm.submit()"
                />
            </div>
        </template>
    </Dialog>
</template>
