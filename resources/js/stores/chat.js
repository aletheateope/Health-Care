import { ref } from "vue";

const defaultRecipient = {
    id: null,
    name: "Unknown Recipient",
};

export const selectedRecipient = ref({ ...defaultRecipient });

export function storeSelectedRecipient(recipient) {
    selectedRecipient.value = {
        id: recipient.user_id,
        name: `${recipient.first_name} ${recipient.last_name}`,
    };
}

// Reset to default
export function resetSelectedRecipient() {
    selectedRecipient.value = { ...defaultRecipient };
}
