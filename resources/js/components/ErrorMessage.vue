<script setup>
import Message from "primevue/message";

const props = defineProps({
    error: Array,
    message: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <Message
        v-if="error && error.length"
        severity="error"
        size="small"
        variant="simple"
    >
        {{ message ?? error[0] }}
    </Message>
</template>
