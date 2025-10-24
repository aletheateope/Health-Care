<script setup>
const props = defineProps({
    title: {
        type: String,
        default: "",
    },
    edit: {
        type: Boolean,
        default: false,
    },
    footer: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["edit-btn", "cancel-btn", "save-btn"]);
</script>

<template>
    <section class="flex flex-col rounded-md border border-color p-4 gap-4">
        <header class="flex flex-row justify-between">
            <h6>{{ title }}</h6>
            <Button
                v-if="edit"
                aria-label="edit"
                icon="pi pi-pen-to-square"
                variant="text"
                severity="info"
                size="small"
                @click="emit('edit-btn')"
            />
        </header>
        <slot />
        <footer v-if="footer" class="flex flex-row justify-end gap-4">
            <Button
                label="Cancel"
                severity="secondary"
                @click="emit('cancel-btn')"
            />
            <Button label="Save" @click="emit('save-btn')" />
        </footer>
    </section>
</template>
