import { ref } from "vue";

export const userInitialValues = {
    first_name: "",
    middle_name: "",
    last_name: "",
    date_of_birth: "",
    phone_number: "",
    gender: "male",
    role: "patient",
    email: "",
    password: "",
    password_confirmation: "",
};

export function useFormErrors() {
    const errors = ref({});

    function clearError(field) {
        errors.value[field] = null;

        const rootKey = field.split(".")[0];
        if (errors.value[rootKey]) {
            errors.value[rootKey] = null;
        }
    }

    function clearAll() {
        Object.keys(errors.value).forEach((key) => {
            errors.value[key] = null;
        });
    }

    return { errors, clearError, clearAll };
}
