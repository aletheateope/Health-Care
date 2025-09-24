<script setup>
import FloatLabel from "primevue/floatlabel";
import Password from "primevue/password";

const props = defineProps({
    id: String,
});
</script>

<template>
    <FloatLabel variant="on">
        <Password
            class="w-full"
            inputClass="w-full"
            :inputId="props.id"
            :feedback="false"
            toggleMask
        />
        <label :for="props.id">Password</label>
    </FloatLabel>
</template>
