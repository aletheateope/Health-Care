<script setup>
import Breadcrumb from "@/components/Breadcrumb.vue";

const bcItems = [
    { label: "Appointments", route: "appointments" },
    { label: "Doctor Selection", route: "doctor-appointment" },
];
</script>

<template>
    <section>
        <Breadcrumb :items="bcItems" />
    </section>
</template>
