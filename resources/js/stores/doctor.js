import { ref } from "vue";

const defaultDoctor = {
    id: null,
    name: "Unknown Doctor",
};

export const selectedDoctor = ref({ ...defaultDoctor });

export function storeSelectedDoctor(doctor) {
    selectedDoctor.value = {
        id: doctor.id,
        name: `Dr. ${doctor.first_name} ${doctor.last_name}`,
    };
}

// Reset to default
export function resetSelectedDoctor() {
    selectedDoctor.value = { ...defaultDoctor };
}
