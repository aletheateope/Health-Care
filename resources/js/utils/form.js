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

export function clearError(errorsRef, field) {
    errorsRef.value[field] = null;
}
